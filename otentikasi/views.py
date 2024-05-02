from django.shortcuts import render, redirect
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required

context = {
    'title'     : 'LOGIN',
    'heading'   : 'LOGIN',
}

def checkLogin(request):
    """
    check apakah dia sudah auth atau belum
    :param request:
    """

    if request.user.is_authenticated():
        return redirect('kelasJadwal:listKelasJadwalSemua')
    return redirect('otentikasi:login')


def loginView(request):
    """
    Menampilkan laman login
    :param request:
    :return:
    """
    context = {
        'page_title': 'LOGIN',
    }
    user = None

    if request.method == "GET":
        if request.user.is_authenticated():
            # logika untuk user
            return redirect('kelasJadwal:listKelasJadwalSemua')
        else:
            # logika untuk anonymous
            return render(request, 'login.html', context)

    if request.method == "POST":

        username_login = request.POST['username']
        password_login = request.POST['password']

        user = authenticate(request, username=username_login, password=password_login)

        if user is not None:
            login(request, user)
            return redirect('kelasJadwal:listKelasJadwalSemua')
        else:
            return redirect('otentikasi:login')


@login_required
def logoutView(request):
    """
    Melakukan proses logout
    :param request:
    :return:
    """
    logout(request)
    return redirect('otentikasi:login')

def groupCheck(group):
    switcher = {
        'FK'        : '01.01',
        'FKG'       : '02.01',
        'MIPA'      : '03.01',
        'FT'        : '04.01',
        'FH'        : '05.01',
        'FEB'       : '06.01',
        'FIB'       : '07.01',
        'FPsi'      : '08.01',
        'FISIP'     : '09.01',
        'FKM'       : '10.01',
        'Fasilkom'  : '12.01',
        'FIK'       : '13.01',
        'Farmasi'   : '17.01',
        'FIA'       : '18.01',
        'SIL'       : '19.01',
        'SKSG'      : '20.01',
        'admin'     : '',
    }
    return switcher.get(group)