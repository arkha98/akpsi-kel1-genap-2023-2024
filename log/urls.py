from django.conf.urls import url
from . import views

urlpatterns = [
    url(r'^$', views.listLogHariIni, name='listLogHariIni'),
    url(r'^cari/', views.filterListLog, name='filterListLog'),
]