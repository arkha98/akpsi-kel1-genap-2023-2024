from django.shortcuts import render, redirect
from django.contrib.auth.decorators import login_required
from .forms import UpdateForm
import datetime

from data.models import CacheKelas as kelas, CacheKelasSesiPerkuliahan as sesi
from otentikasi.views import groupCheck

context = {
    'title'     : 'Kelas',
    'heading'   : 'Kelas',
}

@login_required
def listKelasSemua(request):
    """
    list semua kelas tanpa filter
    :param request:
    :return:
    """
    context['tag'] = 'listKelas'
    context['listKelas'] = kelas.objects.all().filter(
        kd_org__icontains=groupCheck(str(request.user.groups.all()[0])),
        thn__in=[datetime.datetime.now().year - 1, datetime.datetime.now().year]).order_by(
        '-nama_mata_kuliah_ind').reverse().order_by('-term').reverse()

    return render(request, 'updateKelas/listKelas.html', context)


@login_required
def filterListKelas(request):
    """
    list kelas dengan filter pencarian berdasarkan nama
    :param request:
    :return:
    """
    context['tag'] = 'filterListKelas'

    if request.method == 'POST':
        jurusan = request.POST['cari_jurusan']+"."+groupCheck(str(request.user.groups.all()[0]))
        if request.POST['cari_tahun'] == '' and request.POST['cari_term'] == '':
            context['listKelas'] = kelas.objects.all().filter(nama_kelas__icontains=request.POST['cari_nama_kelas'],
                                                              kd_org__icontains=groupCheck(
                                                                  str(request.user.groups.all()[0])),
                                                              kd_kurikulum__icontains=jurusan).order_by(
                '-nama_mata_kuliah_ind').reverse().order_by('-term').reverse().order_by('-thn').reverse()
        elif request.POST['cari_tahun'] == '' and request.POST['cari_term'] != '':
            context['listKelas'] = kelas.objects.all().filter(nama_kelas__icontains=request.POST['cari_nama_kelas'],
                                                              term=request.POST['cari_term'],
                                                              kd_org__icontains=groupCheck(
                                                                  str(request.user.groups.all()[0])),
                                                              kd_kurikulum__icontains=jurusan).order_by(
                '-nama_mata_kuliah_ind').reverse().order_by('-thn').reverse()
        elif request.POST['cari_tahun'] != '' and request.POST['cari_term'] == '':
            context['listKelas'] = kelas.objects.all().filter(nama_kelas__icontains=request.POST['cari_nama_kelas'],
                                                              thn=request.POST['cari_tahun'],
                                                              kd_org__icontains=groupCheck(
                                                                  str(request.user.groups.all()[0])),
                                                              kd_kurikulum__icontains=jurusan).order_by(
                '-nama_mata_kuliah_ind').reverse().order_by('-term').reverse()
        elif request.POST['cari_tahun'] != '' and request.POST['cari_term'] != '':
            context['listKelas'] = kelas.objects.all().filter(nama_kelas__icontains=request.POST['cari_nama_kelas'],
                                                              thn=request.POST['cari_tahun'],
                                                              term=request.POST['cari_term'],
                                                              kd_org__icontains=groupCheck(
                                                                  str(request.user.groups.all()[0])),
                                                              kd_kurikulum__icontains=jurusan).order_by(
                '-nama_mata_kuliah_ind').reverse()

    return render(request, 'updateKelas/listKelas.html', context)


@login_required
def listSesiKelas(request, kd_kelas_tmp):
    """
    list sesi kelas sesuai dengan kode kelas yang dipilih
    :param request:
    :param kd_kelas_tmp:
    :return:
    """
    context['tag'] = 'listSesiKelas'
    context['listKelas'] = sesi.objects.filter(kd_kelas__icontains=kd_kelas_tmp).order_by('-wkt_mulai').reverse()

    return render(request, 'updateKelas/listSesi.html', context)


@login_required
def updateKelas(request, update_id):
    """
    update jadwal kelas
    :param request:
    :param update_id:
    :return:
    """
    context['tag'] = 'updateKelas'
    tmp = sesi.objects.all().filter(id_kuliah=int(update_id))
    sesi_update = tmp[0]
    data = {
        'wkt_mulai': sesi_update.wkt_mulai,
        'wkt_selesai': sesi_update.wkt_selesai,
    }
    print(sesi_update.wkt_mulai.date())
    kelas_form = UpdateForm(request.POST or None, initial=data, instance=sesi_update)
    if request.method == 'POST':
        if kelas_form.is_valid():
            kelas_form.save()

            # update tanggal dan ts_update
            tmp = sesi.objects.all().filter(id_kuliah=int(update_id))
            sesi.objects.all().filter(id_kuliah=int(update_id)).update(tanggal=tmp[0].wkt_mulai.date(),
                                                                       ts_update=datetime.datetime.now())

        return redirect('/updateKelas/listKelas/{}'.format(sesi_update.kd_kelas))

    context['kelas_form'] = kelas_form

    return render(request, 'updateKelas/updateKelas.html', context)