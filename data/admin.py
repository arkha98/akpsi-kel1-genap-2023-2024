from django.contrib import admin
from data import models

# Register your models here.
admin.site.register(models.LogPresentronik)
admin.site.register(models.CacheKelas)
admin.site.register(models.CacheKelasPengajar)
admin.site.register(models.CacheKelasSesiPerkuliahan)
admin.site.register(models.CacheKelasSesiPerkuliahanDosenPengajar)
admin.site.register(models.CacheKelasSesiPerkuliahanMahasiswaPeserta)
admin.site.register(models.CacheDeviceInventory)