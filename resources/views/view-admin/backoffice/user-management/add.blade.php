@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user-management.index') }}">Master User</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah User</li>
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
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.user-management.action-add') }}">
                            @csrf
                            <div class="row card-body">
                                <div class="col-xs-12 col-md-4">

                                    <div class="form-group">
                                        <label for="nip">NIP <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="nip" name="nip"
                                            placeholder="NIP" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="nama_lengkap" name="nama_lengkap"
                                            placeholder="Nama Lengkap" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span style="color: red">*</span></label>
                                        <input type="email" class="form-control form-control-sm" id="email" name="email"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password <span style="color: red">*</span></label>
                                        <input type="password" class="form-control form-control-sm" id="password" name="password"
                                            placeholder="Password" required>
                                    </div>           
                                    
                                    <div class="form-group">
                                        <label for="flag_aktif">Status Aktif <span style="color: red">*</span></label>
                                        <select class="form-control form-control-sm" id="flag_aktif" name="flag_aktif" required>
                                            <option selected="selected">Pilih Status</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-xs-12 col-md-4">

                                    

                                    {{-- <div class="form-group">
                                        <label for="user_role_id">Role Akun <span style="color: red">*</span></label>
                                        <select class="form-control form-control-sm" id="user_role_id" name="user_role_id" required>
                                            <option selected="selected">Pilih Role Akun</option>
                                            <option value="{{ CustomHelper::_ROLE_SUPER_ADMIN }}">Superadmin</option>
                                            <option value="{{ CustomHelper::_ROLE_OPERATOR }}">Operator</option>
                                        </select>
                                    </div> --}}

                                    {{-- <div class="form-group">
                                        <label for="divisi_id">Divisi (Required jika Operator)</label>
                                        <select class="form-control form-control-sm" id="divisi_id" name="divisi_id">
                                            <option selected="selected" value="">Pilih Divisi</option>
                                            @foreach ($divisiDropdownArr as $item)
                                            <option value="{{ $item->id }}">{{ $item->kode_divisi . ' - ' . $item->nama_divisi }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer align-content-md-end">
                                <button type="submit" class="btn btn-success btn-flat">Submit</button>
                                <a href="{{ route('admin.user-management.index') }}" class="btn btn-info btn-flat">Back</a>
                            </div>
                        </form>
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
        $('#user_role_id').select2({width: '100%', fontsize: '15px'});
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
