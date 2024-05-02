from django.conf.urls import url
from . import views

urlpatterns = [
    url(r'^$', views.listKelasJadwalSemua, name='listKelasJadwalSemua'),
    url(r'^cari/$', views.filterKelasJadwal, name='filterKelasJadwal'),
    url(r'^update/$', views.updateKelasJadwal, name='updateKelasJadwal'),
    # url(r'^update/(?P<update_kd_kelas>[0-9]+)/(?P<update_hari_ke>[0-9]+)/(?P<update_jam_mulai>.*)$', views.updateKelasJadwal, name='updateKelasJadwal'),
]
