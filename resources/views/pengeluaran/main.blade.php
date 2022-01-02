@extends('layouts.master')
@section('title', 'Pengeluaran')

<!-- Header -->
@section('content-title', 'Pengeluaran')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/pengeluaran') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Pengeluaran</li>
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
                        <table class="table table-bordered table-hover" id="datatable">
                            <thead>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Nominal</th>
                                <th width="10%">Aksi</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('pengeluaran.modal')


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






        function loaddata() {
            $('#datatable').DataTable({
                processing: true,
                autoWidth: false,
                destroy: true,
                serverSide: true,
                ajax: "{{ route('getPengeluaran') }}",
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
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal'
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
            $('#judulModal').html('Tambah Pengeluaran')
            statuscrud = 'c'
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
                // data: id,
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
                    url: "{{ route('deletePengeluaran', '') }}" + "/" + id,

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
