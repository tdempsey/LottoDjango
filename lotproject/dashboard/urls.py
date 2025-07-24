from django.urls import path
from . import views

urlpatterns = [
    path('', views.index, name='index'),
    path('api/settings', views.api_settings, name='api_settings'),
    path('api/generate', views.api_generate, name='api_generate'),
    path('api/analyze/<str:filename>', views.api_analyze, name='api_analyze'),
    path('api/files', views.api_files, name='api_files'),
    path('download/<str:filename>', views.download_file, name='download_file'),
    path('api/download-batch', views.api_download_batch, name='api_download_batch'),
    path('api/delete/<str:filename>', views.api_delete_file, name='api_delete_file'),
]
