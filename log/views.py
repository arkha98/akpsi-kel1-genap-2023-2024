from django.shortcuts import render, redirect
from django.contrib.auth.decorators import login_required
import datetime

from data.models import LogPresentronik as log
from otentikasi.views import groupCheck

# Create your views here.

context = {
    'title'     : 'Log',
    'heading'   : 'Log',
}

@login_required
def listLogHariIni(request):
    context['tag'] = 'listLogHariIni'
    context['listLog'] = log.objects.all().filter(kd_org__contains=groupCheck(str(request.user.groups.all()[0])),
                                                  ts_presensi_device__range=[
                                                      datetime.datetime.now() - datetime.timedelta(days=1),
                                                      datetime.datetime.now()]).order_by('-ts_presensi_device')

    return render(request, 'log/listLog.html', context)


@login_required
def filterListLog(request):
    context['tag'] = 'filterListLog'

    print(type(request.POST['waktu_1']))

    if request.method == 'POST':
        if request.POST['waktu_1'] == '' and request.POST['waktu_2'] == '':
            return redirect('log:listLogHariIni')
        elif request.POST['waktu_1'] == '' and request.POST['waktu_2'] != '':
            context['listLog'] = log.objects.all().filter(
                kd_org__contains=groupCheck(str(request.user.groups.all()[0])),
                ts_presensi_device__range=["2018-01-01 00:00:00", request.POST['waktu_2']]).order_by(
                '-ts_presensi_device')
        elif request.POST['waktu_2'] != '' and request.POST['waktu_2'] == '':
            context['listLog'] = log.objects.all().filter(
                kd_org__contains=groupCheck(str(request.user.groups.all()[0])),
                ts_presensi_device__range=[request.POST['waktu_1'], datetime.datetime.now()]).order_by(
                '-ts_presensi_device')
        elif request.POST['waktu_1'] != '' and request.POST['waktu_2'] != '':
            context['listLog'] = log.objects.all().filter(
                kd_org__contains=groupCheck(str(request.user.groups.all()[0])),
                ts_presensi_device__range=[request.POST['waktu_1'], request.POST['waktu_2']]).order_by(
                '-ts_presensi_device')

    return render(request, 'log/listLog.html', context)