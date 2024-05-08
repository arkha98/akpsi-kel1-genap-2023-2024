@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile.index') }}">Profil</a>
                        </li>
                        <li class="breadcrumb-item active">Detail Profil</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class=" col-xs-12 col-md-12">

                    @include('layouts.sub-layout-admin.status_message')

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detail Profil</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <span>
                            <div class="row card-body">
                                <div class="col-xs-12 col-md-4">

                                    <div class="form-group">
                                        <label class="col-md-12" for="nama_lengkap">Nama Lengkap</label>
                                        <span class="col-md-12">{{ $data_user['nama_lengkap'] }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="email">Email</label>
                                        <span class="col-md-12">{{ $data_user['email'] }}</span>
                                    </div>                                    

                                </div>

                                <div class="col-xs-12 col-md-4">

                                    <div class="form-group">
                                        <label class="col-md-12" for="flag_aktif">Status Aktif</label>
                                        <span class="col-md-12">{{ $data_user['flag_aktif']==1? 'Aktif' : 'Tidak Aktif' }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="role_akun_id">Role Akun</label>
                                        <span class="col-md-12">{{ $data_user['desc_role_akun'] }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="role_akun_id">Divisi</label>
                                        <span class="col-md-12">{{ $data_user['nama_divisi'] }}</span>
                                    </div>

                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <form action="{{ route('admin.profil.edit') }}" method="post">@csrf<button class="btn btn-primary btn-flat">Edit</button></form>
                            </div>
                        </span>
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection

@section('javascripts')
<script>
    $(document).ready(function() {
        $('#role_akun_id').select2({width: '100%', fontsize: '15px'});
        $('#flag_aktif').select2({width: '100%'});
        $('#jenis_kelamin').select2({width: '100%'});


    });

    $(function () {
        //Date picker
        $('#tanggal_lahir').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        bsCustomFileInput.init();
    });

</script>
@endsection
