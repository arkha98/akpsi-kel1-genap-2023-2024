from django import forms
from data.models import KonfigurasiKelasJadwalRutin

class UpdateForm(forms.ModelForm):
    class Meta:
        model = KonfigurasiKelasJadwalRutin
        fields =[
            'tgl_mulai_otomatis_buat_jadwal',
            'tgl_berakhir_otomatis_buat_jadwal',
            'aktif',
        ]
        # widgets = {
        #     'wkt_mulai'     : forms.DateTimeField(),
        #     'wkt_selesai'   : forms.DateTimeField(),
        # }
        # attrs = {'class': 'form-control'}