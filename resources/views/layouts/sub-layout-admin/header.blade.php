<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
           <span class="nav-link" id="spanCountDownSesiAdmin"></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<div class="modal fade" id="modalTimeoutLogoutAdmin" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Logout</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-12" for="kode_ujian">Apakah Anda Masih Ingin Lanjut?</label>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" id="btnLanjutSesiAdmin" class="btn btn-primary btn-flat" data-dismiss="modal">Lanjut Sesi</button>
                <button type="button" class="btn btn-danger btn-flat" onclick="logout();">Logout :&nbsp;<span id="spanCountDownLogoutAdmin"></span></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

