import json
import os
import csv
import io
import zipfile
from datetime import datetime
from pathlib import Path
from collections import Counter, defaultdict
from django.http import JsonResponse, FileResponse, HttpResponseRedirect
from django.shortcuts import render
from django.urls import reverse
from django.views.decorators.csrf import csrf_exempt

import sys
BASE_DIR = Path(__file__).resolve().parents[2]
sys.path.append(str(BASE_DIR))

from lot_cover_1000 import GAFantasy5Generator

DEFAULT_SETTINGS = {
    'count': 1000,
    'max_seq2': 1,
    'max_seq3': 0,
    'max_mod_tot': 1,
    'sum_min': 70,
    'sum_max': 139,
    'include_scores': True,
    'load_historical': True,
}

SETTINGS_FILE = BASE_DIR / 'dashboard_settings.json'

def load_settings():
    try:
        with open(SETTINGS_FILE, 'r') as f:
            settings = json.load(f)
            for key, val in DEFAULT_SETTINGS.items():
                settings.setdefault(key, val)
            return settings
    except FileNotFoundError:
        return DEFAULT_SETTINGS.copy()


def save_settings(settings):
    with open(SETTINGS_FILE, 'w') as f:
        json.dump(settings, f, indent=2)


def index(request):
    settings = load_settings()
    return render(request, 'dashboard.html', {'settings': settings})


@csrf_exempt
def api_settings(request):
    if request.method == 'GET':
        return JsonResponse(load_settings())
    try:
        new_settings = json.loads(request.body.decode())
        if new_settings.get('count', 0) < 1 or new_settings.get('count', 0) > 10000:
            return JsonResponse({'error': 'Count must be between 1 and 10000'}, status=400)
        if new_settings.get('sum_min', 0) >= new_settings.get('sum_max', 0):
            return JsonResponse({'error': 'Sum minimum must be less than maximum'}, status=400)
        save_settings(new_settings)
        return JsonResponse({'success': True, 'settings': new_settings})
    except Exception as e:
        return JsonResponse({'error': str(e)}, status=500)


@csrf_exempt
def api_generate(request):
    if request.method != 'POST':
        return JsonResponse({'error': 'Invalid method'}, status=405)
    try:
        settings = json.loads(request.body.decode()) if request.body else load_settings()
        generator = GAFantasy5Generator()
        generator.max_seq2 = settings.get('max_seq2', 1)
        generator.max_seq3 = settings.get('max_seq3', 0)
        generator.max_mod_tot = settings.get('max_mod_tot', 1)
        generator.sum_range = (settings.get('sum_min', 70), settings.get('sum_max', 139))

        count = settings.get('count', 1000)
        include_scores = settings.get('include_scores', True)
        draws = generator.generate_draws(count=count, include_scores=include_scores)

        timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
        csv_filename = f"ga_fantasy5_{count}_draws_{timestamp}.csv"
        json_filename = f"ga_fantasy5_{count}_draws_{timestamp}.json"
        generator.save_draws_csv(draws, csv_filename)
        generator.save_draws_json(draws, json_filename)

        if draws and isinstance(draws[0], dict):
            combinations = [d['combination'] for d in draws]
            scores = [d['score'] for d in draws]
            sums = [d['sum'] for d in draws]
            summary = {
                'total_draws': len(draws),
                'score_range': f"{min(scores):.4f} - {max(scores):.4f}",
                'avg_score': f"{sum(scores)/len(scores):.4f}",
                'sum_range': f"{min(sums)} - {max(sums)}",
                'avg_sum': f"{sum(sums)/len(sums):.1f}",
                'files': {'csv': csv_filename, 'json': json_filename},
            }
        else:
            summary = {
                'total_draws': len(draws),
                'files': {'csv': csv_filename, 'json': json_filename},
            }
        return JsonResponse({'success': True, 'summary': summary, 'settings_used': settings})
    except Exception as e:
        return JsonResponse({'error': str(e)}, status=500)


def analyze_draws_summary(draws):
    try:
        sums = [int(d['Sum']) for d in draws]
        sum_counter = Counter(sums)
        scores = [float(d['Score']) for d in draws] if 'Score' in draws[0] else []
        even_counts = [int(d['Even']) for d in draws if 'Even' in d]
        even_counter = Counter(even_counts)
        positions = defaultdict(lambda: defaultdict(int))
        for d in draws:
            positions[1][int(d['Num1'])] += 1
            positions[2][int(d['Num2'])] += 1
            positions[3][int(d['Num3'])] += 1
            positions[4][int(d['Num4'])] += 1
            positions[5][int(d['Num5'])] += 1
        all_numbers = []
        for d in draws:
            all_numbers.extend([int(d['Num1']), int(d['Num2']), int(d['Num3']), int(d['Num4']), int(d['Num5'])])
        number_counter = Counter(all_numbers)
        analysis = {
            'sums': {
                'range': f"{min(sums)} - {max(sums)}",
                'average': f"{sum(sums)/len(sums):.1f}",
                'most_common': [{'sum': s, 'count': c} for s, c in sum_counter.most_common(5)],
            },
            'even_odd': {
                'distribution': [
                    {'even': k, 'odd': 5 - k, 'count': v, 'percent': f"{v/len(draws)*100:.1f}%"}
                    for k, v in sorted(even_counter.items())
                ]
            },
            'hottest_numbers': [
                {'number': n, 'count': c, 'percent': f"{c/len(all_numbers)*100:.2f}%"}
                for n, c in number_counter.most_common(10)
            ],
            'coldest_numbers': [
                {'number': n, 'count': c, 'percent': f"{c/len(all_numbers)*100:.2f}%"}
                for n, c in number_counter.most_common()[-10:]
            ],
        }
        if scores:
            analysis['scores'] = {
                'range': f"{min(scores):.4f} - {max(scores):.4f}",
                'average': f"{sum(scores)/len(scores):.4f}"
            }
        return analysis
    except Exception as e:
        return {'error': str(e)}


def load_csv(filename):
    draws = []
    with open(filename, 'r') as f:
        reader = csv.DictReader(f)
        draws = list(reader)
    return draws


def api_analyze(request, filename):
    path = BASE_DIR / filename
    if not path.exists():
        return JsonResponse({'error': 'File not found'}, status=404)
    try:
        draws = load_csv(path)
        if not draws:
            return JsonResponse({'error': 'No data in file'}, status=400)
        analysis = analyze_draws_summary(draws)
        return JsonResponse({'success': True, 'filename': filename, 'total_draws': len(draws), 'analysis': analysis})
    except Exception as e:
        return JsonResponse({'error': str(e)}, status=500)


def api_files(request):
    files = []
    for fname in os.listdir(BASE_DIR):
        if fname.startswith('ga_fantasy5_') and fname.endswith('.csv'):
            stat = os.stat(BASE_DIR / fname)
            files.append({
                'name': fname,
                'size': stat.st_size,
                'modified': datetime.fromtimestamp(stat.st_mtime).strftime('%Y-%m-%d %H:%M:%S'),
            })
    files.sort(key=lambda x: x['modified'], reverse=True)
    return JsonResponse({'files': files})


def download_file(request, filename):
    path = BASE_DIR / filename
    if not path.exists():
        return HttpResponseRedirect(reverse('index'))
    return FileResponse(open(path, 'rb'), as_attachment=True)


@csrf_exempt
def api_download_batch(request):
    if request.method != 'POST':
        return JsonResponse({'error': 'Invalid method'}, status=405)
    try:
        filenames = json.loads(request.body.decode()).get('files', [])
        if not filenames:
            return JsonResponse({'error': 'No files specified'}, status=400)
        memory_file = io.BytesIO()
        with zipfile.ZipFile(memory_file, 'w', zipfile.ZIP_DEFLATED) as zf:
            for fname in filenames:
                fpath = BASE_DIR / fname
                if fpath.exists():
                    zf.write(fpath, arcname=fname)
        memory_file.seek(0)
        zip_name = f"ga_fantasy5_batch_{datetime.now().strftime('%Y%m%d_%H%M%S')}.zip"
        response = FileResponse(memory_file, as_attachment=True, filename=zip_name)
        return response
    except Exception as e:
        return JsonResponse({'error': str(e)}, status=500)


@csrf_exempt
def api_delete_file(request, filename):
    if request.method != 'DELETE':
        return JsonResponse({'error': 'Invalid method'}, status=405)
    path = BASE_DIR / filename
    if not path.exists():
        return JsonResponse({'error': 'File not found'}, status=404)
    try:
        os.remove(path)
        json_path = BASE_DIR / filename.replace('.csv', '.json')
        if json_path.exists():
            os.remove(json_path)
        return JsonResponse({'success': True, 'deleted': filename})
    except Exception as e:
        return JsonResponse({'error': str(e)}, status=500)
