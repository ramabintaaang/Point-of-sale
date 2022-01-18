<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
            aria-controls="nav-home" aria-selected="true">Daftar Pembelian</a>
        <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
            aria-controls="nav-profile" aria-selected="false"></a>
        {{-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                    role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a> --}}
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

        <div class="table table-responsive mt-4">
            <table class="table table-bordered table-hover" id="datatable">
                <thead>
                    <th width="5%">No</th>
                    <th>Tanggal</th>
                    <th>Kode Pembelian</th>
                    <th>Supplier</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th width="10%">Aksi</th>

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4><strong>Supplier yang dipilih</strong></h4>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td>Nama</td>
                                    <td>: </td>
                                    <td id="id_pemb"> </td>
                                    <td id="nama_sup"></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: </td>
                                    <td id="almt_sup"> </td>
                                </tr>
                                <tr>
                                    <td>Telepon</td>
                                    <td>: </td>
                                    <td id="telp_sup"> </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1>Kode : <div class="badge badge-info" id="kode_pemb"></div>
                        </h1>

                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col md-12">
                <div class="form-group row">
                    {{-- <label for="inputPassword" class="col-sm-1 col-form-label">Produk</label> --}}
                    {{-- <div class="col-sm-3"> --}}
                    <input type="text" class="form-control" id="produk" hidden>
                    <input type="text" class="form-control" id="id_produk" hidden>

                    {{-- </div> --}}
                    <button type="button" class="btn btn-primary" id="btnCariProduk"> <i class="fa fa-search"
                            aria-hidden="true"> Cari Produk </i>
                    </button>
                    <button type="button" class="btn btn-success ml-3" id="btnSavePembelianDetail"> <i
                            class="fa fa-long-arrow-right" aria-hidden="true"> Simpan transaksi </i>


                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table table-responsive mt-4">
                    <table class="table table-bordered table-hover" id="dt_pembelianDetail">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode Produk</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th width="10%">Aksi</th>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <form action="" id="formPembelian">
            <div class="row mt-4">
            </div>
        </form>
    </div>
    {{-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                ...</div> --}}
</div>
