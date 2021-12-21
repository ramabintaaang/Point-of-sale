<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="judulModal"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form action="" method="post" id="formKategori">
                    @csrf
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-md-2 my-auto control-label">Nama</label>
                        <div class="col-md-6">
                            <input type="hidden" name="id_kategori" id="id_kategori" class="form-control">
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" autofocus
                                required>
                            <span class="text-danger error-text nama_kategori_err"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn  btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn  btn-sm btn-primary" id="btnSave">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- <div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="judulModal"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="formKategori">
                    @csrf
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-md-2 my-auto control-label">Nama</label>
                        <div class="col-md-6">
                            <input type="hidden" name="id_kategori" id="id_kategori" class="form-control">
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" autofocus
                                required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn  btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn  btn-sm btn-primary" id="btnSave">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal --> --}}
