# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#   * Rearrange models' order
#   * Make sure each model has one field with primary_key=True
#   * Make sure each ForeignKey has `on_delete` set to the desired behavior.
#   * Remove `managed = False` lines if you wish to allow Django to create, modify, and delete the table
# Feel free to rename the models, but don't rename db_table values or field names.
from __future__ import unicode_literals

from django.db import models


class AuthGroup(models.Model):
    name = models.CharField(unique=True, max_length=80)

    class Meta:
        managed = False
        db_table = 'auth_group'


class AuthGroupPermissions(models.Model):
    group = models.ForeignKey(AuthGroup, models.DO_NOTHING)
    permission = models.ForeignKey('AuthPermission', models.DO_NOTHING)

    class Meta:
        managed = False
        db_table = 'auth_group_permissions'
        unique_together = (('group', 'permission'),)


class AuthPermission(models.Model):
    name = models.CharField(max_length=255)
    content_type = models.ForeignKey('DjangoContentType', models.DO_NOTHING)
    codename = models.CharField(max_length=100)

    class Meta:
        managed = False
        db_table = 'auth_permission'
        unique_together = (('content_type', 'codename'),)


class AuthUser(models.Model):
    password = models.CharField(max_length=128)
    last_login = models.DateTimeField(blank=True, null=True)
    is_superuser = models.BooleanField()
    username = models.CharField(unique=True, max_length=150)
    first_name = models.CharField(max_length=30)
    last_name = models.CharField(max_length=30)
    email = models.CharField(max_length=254)
    is_staff = models.BooleanField()
    is_active = models.BooleanField()
    date_joined = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'auth_user'


class AuthUserGroups(models.Model):
    user = models.ForeignKey(AuthUser, models.DO_NOTHING)
    group = models.ForeignKey(AuthGroup, models.DO_NOTHING)

    class Meta:
        managed = False
        db_table = 'auth_user_groups'
        unique_together = (('user', 'group'),)


class AuthUserUserPermissions(models.Model):
    user = models.ForeignKey(AuthUser, models.DO_NOTHING)
    permission = models.ForeignKey(AuthPermission, models.DO_NOTHING)

    class Meta:
        managed = False
        db_table = 'auth_user_user_permissions'
        unique_together = (('user', 'permission'),)


class CacheDeviceInventory(models.Model):
    ip = models.CharField(primary_key=True, max_length=200)
    mac_address = models.CharField(max_length=200)
    visible_hostname = models.CharField(max_length=200, blank=True, null=True)
    ts_update = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'cache_device_inventory'


class CacheKelas(models.Model):
    kd_kelas = models.CharField(primary_key=True, max_length=200)
    nip_koordinator = models.CharField(max_length=200, blank=True, null=True)
    nama_dosen_koordinator = models.CharField(max_length=1000, blank=True, null=True)
    ts_update = models.DateTimeField()
    thn = models.IntegerField()
    term = models.IntegerField()
    kd_org = models.CharField(max_length=200, blank=True, null=True)
    nama_kelas = models.CharField(max_length=500, blank=True, null=True)
    kd_mata_kuliah = models.CharField(max_length=200, blank=True, null=True)
    kd_kurikulum = models.CharField(max_length=200, blank=True, null=True)
    nama_mata_kuliah_ing = models.CharField(max_length=200, blank=True, null=True)
    nama_mata_kuliah_ind = models.CharField(max_length=200, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'cache_kelas'


class CacheKelasPengajar(models.Model):
    kd_kelas = models.CharField(primary_key=True, max_length=200)
    nip_dosen = models.CharField(max_length=200)
    nama_dosen = models.CharField(max_length=1000)
    bobot = models.DecimalField(max_digits=65535, decimal_places=65535)
    ts_update = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'cache_kelas_pengajar'
        unique_together = (('kd_kelas', 'nip_dosen'),)


class CacheKelasSesiPerkuliahan(models.Model):
    id_kuliah = models.BigIntegerField(primary_key=True)
    kd_kelas = models.CharField(max_length=200)
    tanggal = models.DateField()
    wkt_mulai = models.DateTimeField()
    wkt_selesai = models.DateTimeField()
    ts_update = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'cache_kelas_sesi_perkuliahan'


class CacheKelasSesiPerkuliahanDosenPengajar(models.Model):
    id_kuliah = models.BigIntegerField(primary_key=True)
    nip = models.CharField(max_length=200)
    nama_dosen = models.CharField(max_length=200)
    nama_dosen_dengan_gelar = models.CharField(max_length=300)
    ldap_acc = models.CharField(max_length=200)
    ts_update = models.DateTimeField()
    ts_last_sync_with_siak = models.DateTimeField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'cache_kelas_sesi_perkuliahan_dosen_pengajar'
        unique_together = (('id_kuliah', 'nip'),)


class CacheKelasSesiPerkuliahanMahasiswaPeserta(models.Model):
    id_kuliah = models.BigIntegerField(primary_key=True)
    npm = models.CharField(max_length=200)
    kd_org = models.CharField(max_length=200)
    ts_update = models.DateTimeField()
    status_presensi = models.IntegerField()
    ts_last_sync_with_siak = models.DateTimeField(blank=True, null=True)
    nama_mahasiswa = models.CharField(max_length=200, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'cache_kelas_sesi_perkuliahan_mahasiswa_peserta'
        unique_together = (('id_kuliah', 'npm', 'kd_org'),)


class CacheRfidTagNoIdentitas(models.Model):
    rfid_tag = models.CharField(primary_key=True, max_length=100)
    kode_identitas = models.CharField(max_length=100)
    kode_organisasi = models.CharField(max_length=100)

    class Meta:
        managed = False
        db_table = 'cache_rfid_tag_no_identitas'


class DiscoveryKelasSesiPerkuliahanDevice(models.Model):
    id_kuliah = models.BigIntegerField(primary_key=True)
    mac_address = models.CharField(max_length=100)
    catatan = models.CharField(max_length=200, blank=True, null=True)
    ts_update = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'discovery_kelas_sesi_perkuliahan_device'
        unique_together = (('id_kuliah', 'mac_address'),)


class DiscoveryKelasSesiPerkuliahanDosenPengajar(models.Model):
    id_kuliah = models.BigIntegerField(primary_key=True)
    nip = models.CharField(max_length=200)
    ts_presensi_device = models.DateTimeField()
    mac_address_device = models.CharField(max_length=200)
    ts_update = models.DateTimeField()
    sudah_sync_ke_siak = models.BooleanField()
    ts_sync_ke_siak = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'discovery_kelas_sesi_perkuliahan_dosen_pengajar'
        unique_together = (('id_kuliah', 'nip'),)


class DiscoveryKelasSesiPerkuliahanMahasiswaPeserta(models.Model):
    id_kuliah = models.BigIntegerField(primary_key=True)
    npm = models.CharField(max_length=200)
    kd_org = models.CharField(max_length=200)
    ts_presensi_device = models.DateTimeField()
    mac_address_device = models.CharField(max_length=200)
    ts_update = models.DateTimeField()
    sudah_sync_ke_siak = models.BooleanField()
    ts_sync_ke_siak = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'discovery_kelas_sesi_perkuliahan_mahasiswa_peserta'
        unique_together = (('id_kuliah', 'npm', 'kd_org'),)


class DjangoAdminLog(models.Model):
    action_time = models.DateTimeField()
    object_id = models.TextField(blank=True, null=True)
    object_repr = models.CharField(max_length=200)
    action_flag = models.SmallIntegerField()
    change_message = models.TextField()
    content_type = models.ForeignKey('DjangoContentType', models.DO_NOTHING, blank=True, null=True)
    user = models.ForeignKey(AuthUser, models.DO_NOTHING)

    class Meta:
        managed = False
        db_table = 'django_admin_log'


class DjangoContentType(models.Model):
    app_label = models.CharField(max_length=100)
    model = models.CharField(max_length=100)

    class Meta:
        managed = False
        db_table = 'django_content_type'
        unique_together = (('app_label', 'model'),)


class DjangoMigrations(models.Model):
    app = models.CharField(max_length=255)
    name = models.CharField(max_length=255)
    applied = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'django_migrations'


class DjangoSession(models.Model):
    session_key = models.CharField(primary_key=True, max_length=40)
    session_data = models.TextField()
    expire_date = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'django_session'


class KonfigurasiKelasJadwalRutin(models.Model):
    kd_kelas = models.CharField(primary_key=True, max_length=200)
    hari_ke = models.IntegerField()
    jam_mulai = models.TimeField()
    jam_selesai = models.TimeField()
    tgl_mulai_otomatis_buat_jadwal = models.DateTimeField()
    tgl_berakhir_otomatis_buat_jadwal = models.DateTimeField()
    aktif = models.BooleanField()
    kd_mk = models.CharField(max_length=500, blank=True, null=True)
    nama_mk = models.CharField(max_length=500, blank=True, null=True)
    nama_kelas = models.CharField(max_length=500, blank=True, null=True)
    nama_hari = models.CharField(max_length=500, blank=True, null=True)
    ts_update = models.DateTimeField()
    kd_org = models.CharField(max_length=200, blank=True, null=True)
    thn = models.IntegerField(blank=True, null=True)
    term = models.IntegerField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'konfigurasi_kelas_jadwal_rutin'
        unique_together = (('kd_kelas', 'hari_ke', 'jam_mulai'),)


class KonfigurasiPengecualianJadwalRutin(models.Model):
    seq = models.BigAutoField(primary_key=True)
    tipe = models.CharField(max_length=200)
    kd_org = models.CharField(max_length=200, blank=True, null=True)
    kd_kelas = models.CharField(max_length=200, blank=True, null=True)
    tgl_pengecualian = models.DateField()
    operator = models.CharField(max_length=500, blank=True, null=True)
    keterangan = models.TextField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'konfigurasi_pengecualian_jadwal_rutin'


class LogPresentronik(models.Model):
    seq = models.BigAutoField(primary_key=True)
    mac_address = models.CharField(max_length=20)
    no_identitas = models.CharField(max_length=50)
    ts_import = models.DateTimeField()
    ts_presensi_device = models.DateTimeField(blank=True, null=True)
    nama = models.CharField(max_length=200)
    kd_org = models.CharField(max_length=200, blank=True, null=True)
    rfid_tag = models.CharField(max_length=200, blank=True, null=True)
    tipe_perangkat = models.CharField(max_length=200, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'log_presentronik'


class TmpEuisJadwalKuliah(models.Model):
    id_kuliah = models.CharField(primary_key=True, max_length=200)
    tanggal = models.DateField()
    mac_address = models.CharField(max_length=200, blank=True, null=True)
    wkt_mulai = models.DateTimeField(blank=True, null=True)
    wkt_selesai = models.DateTimeField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'tmp_euis_jadwal_kuliah'
        unique_together = (('id_kuliah', 'tanggal'),)


class TmpEuisPeserta(models.Model):
    id_kuliah = models.CharField(primary_key=True, max_length=50)
    no_identitas = models.CharField(max_length=50)

    class Meta:
        managed = False
        db_table = 'tmp_euis_peserta'
        unique_together = (('id_kuliah', 'no_identitas'),)
