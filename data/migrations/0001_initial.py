# -*- coding: utf-8 -*-
# Generated by Django 1.11 on 2019-08-16 03:26
from __future__ import unicode_literals

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='CacheKelas',
            fields=[
                ('kd_kelas', models.CharField(max_length=200, primary_key=True, serialize=False)),
                ('nip_koordinator', models.CharField(blank=True, max_length=200, null=True)),
                ('nama_dosen_koordinator', models.CharField(blank=True, max_length=1000, null=True)),
                ('ts_update', models.DateTimeField()),
                ('thn', models.IntegerField()),
                ('term', models.IntegerField()),
                ('kd_org', models.CharField(blank=True, max_length=200, null=True)),
                ('nama_kelas', models.CharField(blank=True, max_length=500, null=True)),
                ('kd_mata_kuliah', models.CharField(blank=True, max_length=200, null=True)),
                ('kd_kurikulum', models.CharField(blank=True, max_length=200, null=True)),
                ('nama_mata_kuliah_ing', models.CharField(blank=True, max_length=200, null=True)),
                ('nama_mata_kuliah_ind', models.CharField(blank=True, max_length=200, null=True)),
            ],
            options={
                'db_table': 'cache_kelas',
                'managed': False,
            },
        ),
        migrations.CreateModel(
            name='CacheKelasSesiPerkuliahan',
            fields=[
                ('id_kuliah', models.BigIntegerField(primary_key=True, serialize=False)),
                ('kd_kelas', models.CharField(max_length=200)),
                ('tanggal', models.DateField()),
                ('wkt_mulai', models.DateTimeField()),
                ('wkt_selesai', models.DateTimeField()),
                ('ts_update', models.DateTimeField()),
            ],
            options={
                'db_table': 'cache_kelas_sesi_perkuliahan',
                'managed': False,
            },
        ),
        migrations.CreateModel(
            name='LogPresentronik',
            fields=[
                ('seq', models.BigAutoField(primary_key=True, serialize=False)),
                ('mac_address', models.CharField(max_length=20)),
                ('no_identitas', models.CharField(max_length=50)),
                ('ts_import', models.DateTimeField()),
                ('ts_presensi_device', models.DateTimeField(blank=True, null=True)),
                ('nama', models.CharField(max_length=200)),
                ('kd_org', models.CharField(blank=True, max_length=200, null=True)),
                ('rfid_tag', models.CharField(blank=True, max_length=200, null=True)),
                ('tipe_perangkat', models.CharField(blank=True, max_length=200, null=True)),
            ],
            options={
                'db_table': 'log_presentronik',
                'managed': False,
            },
        ),
    ]