@extends('layouts.admin')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                <!-- /.col-md-6 -->
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Selamat Datang</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Administrator</h6>

                            {{-- <p class="card-text">Silakan memilih menu yang diinginkan
                            </p> --}}
                            {{-- <a href="#" class="btn btn-primary">Ujian</a> --}}
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
