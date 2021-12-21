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
                        <label for="nama_produk" class="col-md-3 my-auto control-label">Nama</label>
                        <div class="col-md-8">
                            <input type="hidden" name="id_produk" id="id_produk" class="form-control">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" autofocus
                                required>
                            <span class="text-danger error-text nama_produk_err"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-md-3 my-auto control-label">Kategori</label>
                        <div class="col-md-8">
                            <select name="id_kategori" id="id_kategori" class="form-control optionkategori"
                                style="width: 100%">
                                <option value="">Pilih Kategori</option>
                                @foreach ($data as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-md-3 my-auto control-label">Merk</label>
                        <div class="col-md-8">
                            <input type="text" name="merk" id="merk" class=" form-control">
                            <span class="text-danger error-text merk_err"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_beli" class="col-md-3 my-auto control-label">Harga Beli</label>
                        <div class="col-md-8">
                            <input type="text" onkeypress="return inputAngka(event)" name="harga_beli" id="harga_beli"
                                class=" form-control">
                            <span class="text-danger error-text harga_beli_err"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_jual" class="col-md-3 my-auto control-label">Harga Jual</label>
                        <div class="col-md-8">
                            <input type="text" name="harga_jual" id="harga_jual" class=" form-control"
                                onkeypress="return inputAngka(event)">
                            <span class="text-danger error-text harga_jual_err"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="diskon" class="col-md-3 my-auto control-label">Diskon</label>
                        <div class="col-md-8">
                            <input type="number" onkeypress="return inputAngka(event)" name="diskon" id="diskon"
                                class=" form-control" value="0">
                            <span class="text-danger error-text diskon_err"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stok" class="col-md-3 my-auto control-label">Stok</label>
                        <div class="col-md-8">
                            <input type="number" onkeypress="return inputAngka(event)" name="stok" id="stok"
                                class=" form-control" value="0">
                            <span class="text-danger error-text stok_err"></span>
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
