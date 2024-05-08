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
                        <li class="breadcrumb-item active">Master User</li>
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
                <div class="col-12">

                    @include('layouts.sub-layout-admin.status_message')

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Data User</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="card-group">
                                <form action="{{ route('admin.user-management.add') }}" method="post">@csrf<button class="btn btn-success btn-flat"><i class="fa fa-plus-circle"></i>&nbsp;Tambah</button></form>
                            </div>
                            &emsp;
                            <div class="card-text">
                                <table id="dtuser" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <th>#</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
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
    $(function () {
        var table = $('#dtuser').DataTable({
            "language": {
                "infoFiltered": ""
            },
            // dom: 'Blfrtip',
            processing: true,
            serverSide: true,
            ajax:{
                "url": "{{ route('admin.user-management.pagination') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            buttons:[],
            columns: [
                { "data": "sort_number" },
                { "data": "nip" },
                { "data": "nama_lengkap" },
                { "data": "email" },
                { "data": "nama_role" },
                { "data": "flag_aktif" },
                { "data": "options" }
            ],
            "order": [[ 1, "asc" ]],
            'columnDefs': [ {
                'targets': [0,6],
                'orderable': false,
            }],
        });
    });
</script>
@endsection
