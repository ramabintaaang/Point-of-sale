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
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form action="" method="post" id="form">
                    @csrf
                    <div class="form-group row">
                        <label for="alamat" class="col-md-2 my-auto control-label">Deskripsi</label>
                        <div class="col-md-8">
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"> </textarea>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telepon" class="col-md-2 my-auto control-label">Nominal</label>
                        <div class="col-md-8">
                            <input type="text" name="nominal" id="nominal" class="form-control"
                                onkeypress="return inputAngka(event)">
                            <input type="hidden" name="id_pengeluaran" id="id_pengeluaran" class="form-control">

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
<!-- /.modal --> --}}



<div class="modal fade" id="modalSupplier">
    <div class="modal-dialog modal-xl">
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
                <table class="table table-stripped table-bordered" id="tabelSupplier">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn  btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn  btn-sm btn-primary" id="btnSave">Simpan</button>
            </div>
        </div>

    </div>

</div>


<div class="modal fade" id="modalProduk">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="judulModal"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-stripped table-bordered" id="tabelProduk">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode produk</th>
                        <th>Nama</th>
                        <th>harga beli</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>

</div>
