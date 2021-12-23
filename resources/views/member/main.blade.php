@extends('layouts.master')
@section('title', 'Member')

<!-- Header -->
@section('content-title', 'Member')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Master</a></li>
    <li class="breadcrumb-item active">Member Area</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success" id="btnAdd"><i class="fas fa-plus-circle"> Tambah </i></button>
                    <button class="btn btn-danger" id="btnDeleteSemua"><i class="fas fa-trash"> Hapus </i></button>
                    <button class="btn btn-warning" id="btnCetakMember"><i class="fas fa-print">
                            Cetak Member
                        </i></button>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <form action="" id="formMember" method="POST">
                            @csrf
                            <table class="table table-bordered table-hover text-center" id="datatable">
                                <thead>
                                    <th width="5%">
                                        <input type="checkbox" name="select_all" id="select_all">
                                    </th>
                                    <th width="3%">No</th>
                                    <th width="20%">Kode member</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
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


    @include('member.modal')


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
                ajax: "{{ route('getMember') }}",
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
                        data: 'kode_member',
                        name: 'kode_member'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
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


        $('#btnAdd').click(function(e) {
            $('#modal').modal('show')
            $('#modal form')[0].reset()
            $('.print-error-msg').hide()
            $('#judulModal').html('Tambah Member')
            $('#id_kategori').select2()
            statuscrud = 'c'
        });

        $('#btnDeleteSemua').click(function(e) {
            let form = $('#formMember').serialize()
            let id = $(this).attr('id')
            if (confirm('Yakin untuk menghapus data yang dipilih ?')) {
                if ($('input:checked').length > 1) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('deleteSelectMember', '') }}" + "/" + id,
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

        $('#btnCetakMember').click(function(e) {
            let form = $('#formMember').serialize()
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak !')
            } else if ($('input:checked').length < 3) {
                alert('Pilih data minimal 3 !')
            } else {
                $('#formMember').attr('action', '{{ route('cetakMember') }}').attr('target', '_blank').submit()
            }

        });

        $('#btnSave').click(function(e) {
            var form = $('#form').serialize()

            if (statuscrud == 'c') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('addMember') }}",
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
                            printErrorMsg(xhr.responseJSON.error);
                        }
                    }
                });
            } else if (statuscrud == 'u') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('updateMember') }}",
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
                url: "{{ route('editMember', '') }}" + "/" + id,
                data: id,
                dataType: "json",
                success: function(res) {
                    $('#modal').modal('show')
                    $('#judulModal').html('Edit Member')
                    $('#id_member').val(res.data.id_member)
                    $('#nama').val(res.data.nama)
                    $('#alamat').val(res.data.alamat)
                    $('#telepon').val(res.data.telepon)
                    // $('#nama_Member').val(res.data[0].nama_Member)
                    // $('#merk').val(res.data[0].merk)
                    // $('#harga_beli').val(res.data[0].harga_beli)
                    // $('#harga_jual').val(res.data[0].harga_jual)
                    // $('#diskon').val(res.data[0].diskon)
                    // $('#stok').val(res.data[0].stok)
                    // $('#id_kategori').val(res.data[0].id_kategori).trigger('change')
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
                    url: "{{ route('deleteMember', '') }}" + "/" + id,
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


        $('#select_all').click(function(e) {
            $(':checkbox').prop('checked', this.checked);

        });
    </script>

@endpush
