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
                        <li class="breadcrumb-item active">Edit User</li>
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
                            <h3 class="card-title">Form Edit User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.user-management.action-edit') }}">
                            @csrf
                            {{-- {!! Form::hidden('id', $data_user->id) !!}
                            {!! Form::hidden('form_token', $form_token) !!} --}}
                            <input type="hidden" value="{{ $data_user['id'] }}" name="id">
                            <input type="hidden" value="{{ $form_token }}" name="form_token">
                            <div class="row card-body">
                                <div class="col-xs-12 col-md-4">

                                    <div class="form-group">
                                        <label for="nip">NIP <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="nip"
                                            name="nip" placeholder="NIP"
                                            value="{{ $data_user['nip'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Lengkap <span style="color: red">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="nama_lengkap"
                                            name="nama_lengkap" placeholder="Nama Lengkap"
                                            value="{{ $data_user['nama_lengkap'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span style="color: red">*</span></label>
                                        <input type="email" class="form-control form-control-sm" id="email" name="email"
                                            placeholder="Email" value="{{ $data_user['email'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control form-control-sm" id="password"
                                            name="password" placeholder="Password">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="check_ubah_password"
                                            name="check_ubah_password">
                                        <label class="form-check-label" for="check_ubah_password">Ubah Password</label>
                                    </div>    
                                    
                                    <div class="form-group">
                                        <label for="flag_aktif">Status Aktif <span style="color: red">*</span></label>
                                        <select class="form-control form-control-sm" id="flag_aktif" name="flag_aktif"
                                            required>
                                            <option selected="selected">Pilih Status</option>
                                            <option value="1" @if ($data_user['flag_aktif']==1 ) selected @endif>Aktif
                                            </option>
                                            <option value="0" @if ($data_user['flag_aktif']==0 ) selected @endif>Tidak
                                                Aktif</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-xs-12 col-md-4">

                                    

                                    {{-- <div class="form-group">
                                        <label for="user_role_id">User Role <span style="color: red">*</span></label>
                                        <select class="form-control form-control-sm" id="user_role_id"
                                            name="user_role_id" required>
                                            <option selected="selected">Pilih Role Akun</option>
                                            <option value="{{ CustomHelper::_ROLE_SUPER_ADMIN }}"
                                                {{ $data_user['user_role_id'] == CustomHelper::_ROLE_SUPER_ADMIN ? 'selected' : '' }}>
                                                Superadmin</option>
                                            <option value="{{ CustomHelper::_ROLE_OPERATOR }}"
                                                {{ $data_user['user_role_id'] == CustomHelper::_ROLE_OPERATOR ? 'selected' : '' }}>
                                                Operator</option>
                                        </select>
                                    </div> --}}

                                    {{-- <div class="form-group">
                                        <label for="divisi_id">Divisi (Required jika Operator)</label>
                                        <select class="form-control form-control-sm" id="divisi_id" name="divisi_id">
                                            <option value="">Pilih Divisi</option>
                                            @foreach ($divisiDropdownArr as $item)
                                            <option value="{{ $item->id }}" @if ($item->id == $data_user['divisi_id'])
                                                selected
                                            @endif>{{ $item->kode_divisi . ' - ' . $item->nama_divisi }}</option>
                                            @endforeach
                                        </select>
                                    </div>                                     --}}

                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-flat">Submit</button>
                                &nbsp;
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
