from django.shortcuts import render, redirect
from django.contrib.auth.decorators import login_required
from .forms import UpdateForm
import datetime

from data.models import KonfigurasiKelasJadwalRutin as jadwal
from otentikasi.views import groupCheck

context = {
    'title'     : 'Jadwal Rutin',
    'heading'   : 'Jadwal Rutin',
}

@login_required
def listKelasJadwalSemua(request):
    """
    list semua kelas tanpa filter
    :param request:
    :return:
    """
    context['tag'] = 'Kelas Jadwal'
    context['listKelasJadwal'] = jadwal.objects.all().filter(
        kd_org__contains=groupCheck(str(request.user.groups.all()[0])),
        thn__in=[datetime.datetime.now().year - 1, datetime.datetime.now().year]).order_by(
        '-nama_kelas').reverse().order_by('-term').reverse().reverse()

    return render(request, 'kelasJadwal/listKelasJadwal.html', context)


@login_required
def filterKelasJadwal(request):
    """
    list kelas dengan filter pencarian berdasarkan nama
    :param request:
    :return:
    """
    context['tag'] = 'filterListKelas'
    if request.method == 'POST':
        if str(request.POST['cari_tahun']) == '' and str(request.POST['cari_term']) == '':
            context['listKelasJadwal'] = jadwal.objects.all().filter(nama_mk__icontains=request.POST['cari_nama_kelas'],
                                                              kd_org__contains=groupCheck(
                                                                  str(request.user.groups.all()[0]))).order_by(
                '-nama_kelas').reverse().order_by('-term').reverse().order_by('-thn').reverse()
        elif str(request.POST['cari_tahun']) == '' and str(request.POST['cari_term']) != '':
            context['listKelasJadwal'] = jadwal.objects.all().filter(nama_mk__icontains=request.POST['cari_nama_kelas'],
                                                              term=request.POST['cari_term'],
                                                              kd_org__contains=groupCheck(
                                                                  str(request.user.groups.all()[0]))).order_by(
                '-nama_kelas').reverse().order_by('-thn').reverse()
        elif str(request.POST['cari_tahun']) != '' and str(request.POST['cari_term']) == '':
            context['listKelasJadwal'] = jadwal.objects.all().filter(nama_mk__icontains=request.POST['cari_nama_kelas'],
                                                              thn=request.POST['cari_tahun'],
                                                              kd_org__contains=groupCheck(
                                                                  str(request.user.groups.all()[0]))).order_by(
                '-nama_kelas').reverse().order_by('-term').reverse()
        elif str(request.POST['cari_tahun']) != '' and str(request.POST['cari_term']) != '':
            context['listKelasJadwal'] = jadwal.objects.all().filter(nama_mk__icontains=request.POST['cari_nama_kelas'],
                                                              thn=request.POST['cari_tahun'],
                                                              term=request.POST['cari_term'],
                                                              kd_org__contains=groupCheck(
                                                                  str(request.user.groups.all()[0]))).order_by(
                '-nama_kelas').reverse()

    return render(request, 'kelasJadwal/listKelasJadwal.html', context)

@login_required
def updateKelasJadwal(request):
    """
    update kelas Jadwal rutin
    :param request:
    :param update_kd_kelas:
    :return:
    """
    if request.method == 'POST':
        midnight = datetime.time(0,0)
        print('update_aktif' in request.POST)
        print('nani')
        # mulai = datetime.datetime.combine(request.GET.get('update_tgl_mulai_otomatis_buat_jadwal'), midnight)
        # berakhir = datetime.datetime.combine(request.GET.get('update_tgl_berakhir_otomatis_buat_jadwal'), midnight)
        aktif = False
        if ('update_aktif' in request.POST):
            aktif = True
        jadwal.objects.all().filter(kd_kelas=request.POST.get('update_kd_kelas'),
                                    hari_ke=request.POST.get('update_hari_ke'), jam_mulai=request.POST.get('update_jam_mulai')).update(
            tgl_mulai_otomatis_buat_jadwal=request.POST['update_tgl_mulai_otomatis_buat_jadwal'])
        jadwal.objects.all().filter(kd_kelas=request.POST.get('update_kd_kelas'),
                                    hari_ke=request.POST.get('update_hari_ke'), jam_mulai=request.POST.get('update_jam_mulai')).update(
            tgl_berakhir_otomatis_buat_jadwal=request.POST['update_tgl_berakhir_otomatis_buat_jadwal'])
        jadwal.objects.all().filter(kd_kelas=request.POST.get('update_kd_kelas'),
                                    hari_ke=request.POST.get('update_hari_ke'), jam_mulai=request.POST.get('update_jam_mulai')).update(
            aktif=aktif)
        jadwal.objects.all().filter(kd_kelas=request.POST.get('update_kd_kelas'),
                                    hari_ke=request.POST.get('update_hari_ke'),
                                    jam_mulai=request.POST.get('update_jam_mulai')).update(ts_update=datetime.datetime.now())

        return redirect('kelasJadwal:listKelasJadwalSemua')
    else:
        context['tag'] = 'updateKelas'
        print(type(request.GET.get('update_jam_mulai_h')))
        update_jam_mulai = datetime.time(int(request.GET.get('update_jam_mulai_h')),
                                         int(request.GET.get('update_jam_mulai_m')),
                                         int(request.GET.get('update_jam_mulai_s')))
        print (update_jam_mulai)
        tmp = jadwal.objects.all().filter(kd_kelas=request.GET.get('update_kd_kelas'),
                                          hari_ke=request.GET.get('update_hari_ke'),
                                          jam_mulai=update_jam_mulai)
        kelasJadwal_update = tmp[0]
        # data = {
        #     'tgl_mulai_otomatis_buat_jadwal': kelasJadwal_update.tgl_mulai_otomatis_buat_jadwal,
        #     'tgl_berakhir_otomatis_buat_jadwal': kelasJadwal_update.tgl_berakhir_otomatis_buat_jadwal,
        #     'aktif' : kelasJadwal_update.aktif,
        # }
        # kelasJadwal_form = UpdateForm(request.POST or None, initial=data, instance=kelasJadwal_update)

        context['kelas_tgl_mulai'] = kelasJadwal_update.tgl_mulai_otomatis_buat_jadwal.strftime("%Y-%m-%d")
        context['kelas_tgl_berakhir'] = kelasJadwal_update.tgl_berakhir_otomatis_buat_jadwal.strftime("%Y-%m-%d")
        context['kelas_aktif'] = kelasJadwal_update.aktif
        context['update_kd_kelas'] = request.GET.get('update_kd_kelas')
        context['update_hari_ke'] = request.GET.get('update_hari_ke')
        context['update_jam_mulai'] = str(update_jam_mulai)

        return render(request, 'kelasJadwal/updateKelasJadwal.html', context)