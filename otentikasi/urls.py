from django.conf.urls import url
from . import views

urlpatterns = [
    url(r'^login/$', views.loginView, name='login'),
    url(r'^logout/$', views.logoutView, name='logout'),
    url(r'^$', views.checkLogin, name='checkLogin'),
]