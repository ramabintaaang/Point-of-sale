@extends('layouts.master')
@section('title', 'Produk')

<!-- Header -->
@section('content-title', 'Produk')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Master</a></li>
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success" id="btnAdd"><i class="fas fa-plus-circle"> Tambah </i></button>
                    <button class="btn btn-danger" id="btnDeleteSemua"><i class="fas fa-trash"> Hapus </i></button>
                    <button class="btn btn-warning" id="btnCetakBarcode"><i class="fas fa-print">
                            Cetak Barcode
                        </i></button>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <form action="" id="formProduk" method="POST">
                            @csrf
                            <table class="table table-bordered table-hover text-center" id="datatable">
                                <thead>
                                    <th width="5%">
                                        <input type="checkbox" name="select_all" id="select_all">
                                    </th>
                                    <th width="3%">No</th>
                                    <th>Kode Produk</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Merk</th>
                                    <th>Harga beli</th>
                                    <th>Harga jual</th>
                                    <th>Diskon</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('produk.modal')


@endsection

@push('js')

    <script>
        $(document).ready(function() {
            loaddata()
            $('#select_all').prop('checked', false)
        });

        ///variabel global
        var statuscrud = null

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });





        function loaddata() {
            $('#datatable').DataTable({
                processing: true,
                autoWidth: false,
                destroy: true,
                ajax: "{{ route('getProduk') }}",
                columns: [{
                        data: 'select_all',
                        searchable: false,
                        sortable: false,
                    },
                    {
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
                        data: 'nama_kategori',
                        name: 'nama_kategori'
                    },
                    {
                        data: 'merk',
                        name: 'merk'
                    },
                    {
                        data: 'harga_jual',
                        name: 'harga_jual'
                    },
                    {
                        data: 'harga_beli',
                        name: 'harga_beli'
                    },
                    {
                        data: 'diskon',
                        name: 'diskon'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
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
            $('#modal').modal('show')
            $('#modal form')[0].reset()
            $('#judulModal').html('Tambah Produk')
            $('#id_kategori').select2()
            statuscrud = 'c'
        });

        $('#btnDeleteSemua').click(function(e) {
            let form = $('#formProduk').serialize()
            let id = $(this).attr('id')
            if (confirm('Yakin untuk menghapus data yang dipilih ?')) {
                if ($('input:checked').length > 1) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('deleteSelectProduk', '') }}" + "/" + id,
                        data: form,
                        dataType: "json",
                        success: function(res) {
                            loaddata();
                        }
                    });
                } else {
                    alert('Data belum ada yang terpilih !!!');
                }
            } else {

            }
        });

        $('#btnCetakBarcode').click(function(e) {
            let form = $('#formProduk').serialize()
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak !')
            } else if ($('input:checked').length < 3) {
                alert('Pilih data minimal 3 !')
            } else {
                $('#formProduk').attr('action', '{{ route('cetakBarcode') }}').attr('target', '_blank').submit()
            }

        });

        $('#btnSave').click(function(e) {
            var form = $('#form').serialize()

            if (statuscrud == 'c') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('addProduk') }}",
                    data: form,
                    dataType: "json",
                    success: function(res) {
                        $('#modal').modal('hide')
                        loaddata()
                        Toast.fire({
                            icon: 'success',
                            title: 'Tambah data berhasil'
                        })
                    }
                });
            } else if (statuscrud == 'u') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('updateProduk') }}",
                    data: form,
                    dataType: "json",
                    success: function(res) {
                        $('#modal').modal('hide')
                        loaddata()
                        Toast.fire({
                            icon: 'success',
                            title: 'Update data berhasil'
                        })

                    }
                });
            }

        });

        $(document).on('click', '.edit', function() {
            let id = $(this).attr('id')
            statuscrud = 'u'
            $.ajax({
                type: "get",
                url: "{{ route('editProduk', '') }}" + "/" + id,
                data: id,
                dataType: "json",
                success: function(res) {
                    $('#modal').modal('show')
                    $('#judulModal').html('Edit Produk')
                    $('#id_produk').val(res.data[0].id_produk)
                    $('#nama_produk').val(res.data[0].nama_produk)
                    $('#merk').val(res.data[0].merk)
                    $('#harga_beli').val(res.data[0].harga_beli)
                    $('#harga_jual').val(res.data[0].harga_jual)
                    $('#diskon').val(res.data[0].diskon)
                    $('#stok').val(res.data[0].stok)
                    $('#id_kategori').val(res.data[0].id_kategori).trigger('change')
                    console.log(res.data[0].nama_kategori)
                    console.log(res.data[0])
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
                    url: "{{ route('deleteProduk', '') }}" + "/" + id,
                    data: form,
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

        $('#id_kategori').select2()

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                console.log(key);
                $('.' + key + '_err').text(value);
            });
        }

        $('#select_all').click(function(e) {
            $(':checkbox').prop('checked', this.checked);

        });
    </script>

@endpush
