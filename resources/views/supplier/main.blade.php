@extends('layouts.master')
@section('title', 'Supplier')

<!-- Header -->
@section('content-title', 'Supplier')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Master</a></li>
    <li class="breadcrumb-item active">Supplier</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success" id="btnAdd"><i class="fas fa-plus-circle"> Tambah </i></button>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover text-center" id="datatable">
                            <thead>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th width="20%">Aksi</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('Supplier.modal')


@endsection

@push('js')

    <script>
        $(document).ready(function() {
            loaddata()
        });

        ///variabel global
        var statuscrud = null

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // var swalDelete = Toast.fire({
        //     icon: 'success',
        //     title: 'hapus data berhasil'
        // })
        // var swalUpdate = Toast.fire({
        //     icon: 'success',
        //     title: 'Update data berhasil'
        // })






        function loaddata() {
            $('#datatable').DataTable({
                processing: true,
                autoWidth: false,
                destroy: true,
                serverSide: true,
                ajax: "{{ route('getSupplier') }}",
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
                        data: 'telepon',
                        name: 'telepon'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
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
            $('#judulModal').html('Tambah Supplier')
            statuscrud = 'c'
        });


        $('#btnSave').click(function(e) {
            var form = $('#form').serialize()

            if (statuscrud == 'c') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('addSupplier') }}",
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
                    url: "{{ route('updateSupplier') }}",
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
                url: "{{ route('editSupplier', '') }}" + "/" + id,
                data: id,
                dataType: "json",
                success: function(res) {
                    $('#modal').modal('show')
                    $('#judulModal').html('Edit Supplier')
                    console.log(res.data[0])
                    $('#id_supplier').val(res.data[0].id_supplier)
                    $('#nama_supplier').val(res.data[0].nama_supplier)
                    $('#telepon').val(res.data[0].telepon)
                    $('#alamat').val(res.data[0].alamat)
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
                    url: "{{ route('deleteSupplier', '') }}" + "/" + id,
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
    </script>

@endpush
