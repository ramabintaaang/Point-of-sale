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
                <form action="" method="post" id="form">
                    @csrf
                    <div class="form-group row">
                        <label for="nama_supplier" class="col-md-2 my-auto control-label">Nama</label>
                        <div class="col-md-8">
                            <input type="hidden" name="id_supplier" id="id_supplier" class="form-control">
                            <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" autofocus
                                required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telepon" class="col-md-2 my-auto control-label">telepon</label>
                        <div class="col-md-8">
                            <input type="text" name="telepon" id="telepon" class="form-control"
                                onkeypress="return inputAngka(event)">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-md-2 my-auto control-label">Alamat</label>
                        <div class="col-md-8">
                            <textarea name="alamat" id="alamat" class="form-control" rows="3"> </textarea>

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
