@extends('layouts.master')
@section('title', 'Pembelian')

<!-- Header -->
@section('content-title', 'Pembelian')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/pengeluaran') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Pembelian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success" id="btnAdd"><i class="fas fa-plus-circle"> Tambah
                        </i></button>
                    <input type="hidden" id="gen" value="{{ auth()->id() }}">
                    <input type="hidden" id="kode_pembelian" value="">
                    <button class="btn btn-danger" id="btnBatal" hidden><i class="fa fa-undo"> Batal </i></button>
                    <div class="card-body">
                        @include('pembelian.tabs')
                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('pembelian.modal')


@endsection

@push('js')

    <script>
        $(document).ready(function() {
            loaddata()
        });


        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        ///variabel global
        var statuscrud = null

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function loadSupplier() {
            $('#tabelSupplier').DataTable({
                processing: true,
                autoWidth: false,
                destroy: true,
                serverSide: true,
                ajax: "{{ route('getDataSupplier') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: 'nama_supplier',
                        name: 'nama_supplier'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'telepon',
                        name: 'telepon'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false
                    }
                ],
            });
        }

        function loadProduk() {
            $('#tabelProduk').DataTable({
                processing: true,
                autoWidth: false,
                destroy: true,
                serverSide: true,
                ajax: "{{ route('getDataProduk') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: 'kode_produk',
                        name: 'kode_produk'
                    },
                    {
                        data: 'nama_produk',
                        name: 'nama_produk'
                    },
                    {
                        data: 'harga_beli',
                        name: 'harga_beli'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false
                    }
                ],
            });
        }

        function loaddata() {
            $('#datatable').DataTable({
                processing: true,
                autoWidth: false,
                destroy: true,
                serverSide: true,
                ajax: "{{ route('getPembelian') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'kode_pembelian',
                        name: 'kode_pembelian'
                    },
                    {
                        data: 'nama_supplier',
                        name: 'nama_supplier'
                    },
                    {
                        data: 'total_item',
                        name: 'total_item'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'diskon',
                        name: 'diskon'
                    },
                    {
                        data: 'bayar',
                        name: 'bayar'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false
                    }
                ],
            });
        }

        $('#btnAdd').click(function(e) {
            $('#modalSupplier').modal('show')
            $('#judulModal').html('Supplier')
            loadSupplier()

        });



        $(document).on('click', '.pilihProduk', function(e) {
            let id = $(this).attr('id')

            $('#modalProduk').modal('hide')
            $.ajax({
                type: "post",
                url: "{{ route('addDetailProdukPembelian') }}",
                data: {
                    'id_pembelian': $('#id_pemb').html(),
                    'id_produk': id,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: "json",
                success: function(res) {
                    // console.log(res)
                    // $('#produk').val(res[0].nama_produk)
                    // $('#id_produk').val(res[0].id_produk)
                }
            });
        });

        function loadPembelian() {
            let id = $(this).attr('id')
            $.ajax({
                type: "get",
                url: "{{ route('getPembelian', '') }}" + "/" + id,
                dataType: "json",
                success: function(res) {
                    $('#id_pemb').html(res.data[0].id_pembelian)
                    $('#id_sup').html(res.data[0].id_supplier)
                    $('#nama_sup').html(res.data[0].nama_supplier)
                    $('#telp_sup').html(res.data[0].telepon)
                }
            });
        }

        function dataPembelian() {
            let id = $(this).attr('id')
            let kode_pembelian = $('#kode_pembelian').val()
            // let url = '{{ route('dataPembelian', 'id') }}';
            // url = url.replace('id', id);
            $.ajax({
                type: "get",
                url: "{{ route('dataPembelian', '') }}" + "/" + kode_pembelian,
                dataType: "json",
                success: function(res) {
                    console.log(res)
                    loaddata();
                    $('#kode_pemb').html(res.data[0].kode_pembelian)
                    $('#id_pemb').html(res.data[0].id_pembelian)
                    $('#nama_sup').html(res.data[0].nama_supplier)
                    $('#telp_sup').html(res.data[0].telepon)
                    $('#almt_sup').html(res.data[0].alamat)
                    $('#id_sup').html(res.data[0].id_supplier)
                }
            });
        }

        $(document).on('click', '.pilih', function(e) {
            let start = Date.now();
            let oke = start.toString().substr(8, 5);
            let id_auth = $('#gen').val()
            let input = (id_auth + oke)
            $('#kode_pembelian').val(input)

            let id = $(this).attr('id')
            let kode_pembelian = $('#kode_pembelian').val()
            $.ajax({
                type: "post",
                url: "{{ route('addPembelian') }}",
                data: {
                    'id_supplier': id,
                    'kode_pembelian': kode_pembelian,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: "json",
                success: function(res) {
                    $('#modalSupplier').modal('hide')
                    $('#nav-profile-tab').removeClass('disabled')
                    $('#nav-profile-tab').click()
                    $('#nav-profile-tab').html('Transaksi Pembelian')
                    $('#btnAdd').attr('hidden', true)
                    $('#btnBatal').attr('hidden', false)
                    dataPembelian();


                }
            });
        });

        $('#btnCariProduk').click(function(e) {
            $('#modalProduk').modal('show')
            $('#judulModal').html('Cari Produk')
            loadProduk();


        });

        // $('#btnBatal').click(function(e) {
        //     let c = confirm('Yakin batal ? jika yakin data input akan hilang')
        //     if (c) {
        //         $('#nav-home-tab').click()
        //         $('#nav-profile-tab').addClass('disabled')
        //         $('#nav-profile-tab').html('')
        //         $('#btnAdd').attr('hidden', false)
        //         $('#btnBatal').attr('hidden', true)
        //     }
        // });

        $(document).on('click', '#btnBatal', function() {
            let id = $(this).attr('id')
            let kode_pembelian = $('#kode_pemb').html()
            let c = confirm('Yakin batal ? input dan data akan hilang')
            // var id_pembelian = $('#id_pembelian').val()
            if (c) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('deletePembelianFromBatal') }}",
                    // url: "{{ route('deletePembelianFromBatal', '') }}" + "/" + kode_pembelian,
                    data: {
                        'kode_pembelian': kode_pembelian,
                        '_token': "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    success: function(res) {
                        $('#nav-home-tab').click()
                        $('#nav-profile-tab').addClass('disabled')
                        $('#nav-profile-tab').html('')
                        $('#btnAdd').attr('hidden', false)
                        $('#btnBatal').attr('hidden', true)
                        loaddata();
                    },
                });

            }
        });


        $('#btnSave').click(function(e) {
            var form = $('#form').serialize()

            if (statuscrud == 'c') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('addPengeluaran') }}",
                    data: form,
                    dataType: "json",
                    success: function(res) {
                        $('#modal').modal('hide')
                        loaddata()
                        Toast.fire({
                            icon: 'success',
                            title: 'Tambah data berhasil'
                        })
                    },
                    error(xhr) {
                        if ($.isEmptyObject(xhr.responseJSON.error)) {
                            // alert(xhr.success);
                        } else {
                            console.log(xhr.responseJSON.error)
                            printErrorMsg(xhr.responseJSON.error);
                        }
                    }
                });
            } else if (statuscrud == 'u') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('updatePengeluaran') }}",
                    data: form,
                    dataType: "json",
                    success: function(res) {
                        $('#modal').modal('hide')
                        loaddata()
                        Toast.fire({
                            icon: 'success',
                            title: 'Update data berhasil'
                        })

                    },
                    error(xhr) {
                        if ($.isEmptyObject(xhr.responseJSON.error)) {
                            // alert(xhr.success);
                        } else {
                            printErrorMsg(xhr.responseJSON.error);
                        }
                    }
                });
            }

        });

        $(document).on('click', '.edit', function() {
            let id = $(this).attr('id')
            statuscrud = 'u'
            $.ajax({
                type: "get",
                url: "{{ route('editPengeluaran', '') }}" + "/" + id,
                data: id,
                dataType: "json",
                success: function(res) {
                    $('#modal').modal('show')
                    $('#judulModal').html('Edit Pengeluaran')
                    console.log(res.data[0])
                    $('#deskripsi').val(res.data[0].deskripsi)
                    $('#id_pengeluaran').val(res.data[0].id_pengeluaran)
                    $('#nominal').val(res.data[0].nominal)
                }
            });
        });


        $(document).on('click', '.hapus', function(e) {
            let id = $(this).attr('id')
            var form = $('#form').serialize()
            let c = confirm('Yakin ingin menghapus data ?')
            if (c) {
                $.ajax({
                    type: "post",
                    url: "{{ route('deletePembelian') }}",
                    data: {
                        'id_pembelian': id,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    success: function(res) {
                        $('#modal').modal('hide')
                        loaddata()
                        Toast.fire({
                            icon: 'success',
                            title: 'Hapus data berhasil'
                        })
                    },
                    error(xhr) {
                        console.log(xhr)
                    }
                })
            }
        });
    </script>

@endpush
