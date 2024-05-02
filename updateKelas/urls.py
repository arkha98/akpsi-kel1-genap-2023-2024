from django.conf.urls import url
from . import views

urlpatterns = [
    url(r'^$', views.listKelasSemua, name='listKelasSemua'),
    url(r'^cari/$', views.filterListKelas, name='filterListKelas'),
    url(r'^listKelas/(?P<kd_kelas_tmp>[0-9]+)$', views.listSesiKelas, name='listKelas'),
    url(r'^update/(?P<update_id>[0-9]+)$', views.updateKelas, name='updateKelas'),
]
