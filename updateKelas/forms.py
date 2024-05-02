from django import forms
from data.models import CacheKelasSesiPerkuliahan

class UpdateForm(forms.ModelForm):
    class Meta:
        model = CacheKelasSesiPerkuliahan
        fields =[
            'wkt_mulai',
            'wkt_selesai',
        ]
        # widgets = {
        #     'wkt_mulai'     : forms.DateTimeField(),
        #     'wkt_selesai'   : forms.DateTimeField(),
        # }
        # attrs = {'class': 'form-control'}