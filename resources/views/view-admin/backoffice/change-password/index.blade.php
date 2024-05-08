@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ubah Password</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile.change-password.index') }}">Ubah Password</a>
                        </li>
                        <li class="breadcrumb-item active">Ubah Password</li>
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
                <div class=" col-xs-4 col-md-4">

                    @include('layouts.sub-layout-admin.status_message')

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Ubah Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.change-password.action.change-password') }}">
                            @csrf
                            <div class="row card-body">
                                <div class="col-xs-12 col-md-12">

                                    <div class="form-group">
                                        <label for="old_password">Password Lama <span style="color: red">*</span></label>
                                        <input type="password" class="form-control form-control-sm" id="old_password" name="old_password"
                                            placeholder="Password Lama" min="5" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Password Baru <span style="color: red">*</span></label>
                                        <input type="password" class="form-control form-control-sm" id="new_password" name="new_password"
                                            placeholder="Password Baru" min="5" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password_repeat">Ulangi Password Baru <span style="color: red">*</span></label>
                                        <input type="password" class="form-control form-control-sm" id="new_password_repeat" name="new_password_repeat"
                                            placeholder="Ulangi Password Baru" min="5" required>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer align-content-md-end">
                                <button type="submit" class="btn btn-success btn-flat">Submit</button>
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
        $('#flag_aktif').select2({width: '100%', fontsize: '15px'});

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
