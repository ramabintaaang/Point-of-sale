@extends('layouts.master')
@section('title', 'Kategori')

<!-- Header -->
@section('content-title', 'Kategori')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Master</a></li>
    <li class="breadcrumb-item active">Kategori</li>
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
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('Kategori.modal')


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
                ajax: "{{ route('getKategori') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                    },
                    // {
                    //     data: 'id_kategori',
                    //     name: 'id_kategori'
                    // },
                    {
                        data: 'nama_kategori',
                        name: 'nama_kategori'
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
            $('#judulModal').html('Tambah Kategori')
            statuscrud = 'c'
        });


        $('#btnSave').click(function(e) {
            var form = $('#formKategori').serialize()

            if (statuscrud == 'c') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('addKategori2') }}",
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
                    url: "{{ route('updateKategori2') }}",
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
                url: "{{ route('editKategori2', '') }}" + "/" + id,
                data: id,
                dataType: "json",
                success: function(res) {
                    $('#modal').modal('show')
                    $('#id_kategori').val(res.data.id_kategori)
                    $('#nama_kategori').val(res.data.nama_kategori)
                }
            });
        });


        $(document).on('click', '.hapus', function(e) {
            let id = $(this).attr('id')
            var form = $('#formKategori').serialize()
            let c = confirm('Yakin ingin menghapus data ?')
            if (c) {
                $.ajax({
                    type: "post",
                    url: "{{ route('deleteKategori2', '') }}" + "/" + id,
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

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                console.log(key);
                $('.' + key + '_err').text(value);
            });
        }
    </script>

@endpush
