@extends('layouts.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Aplikasi Kasir - Category')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Member
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Member</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-xs-6">
                            <p style="font-size: 22px">List Member</p>
                        </div>
                        <div class="col-xs-6 text-right">
                            <div class="btn-group">
                                <button onclick="addForm('{{ route('member.store') }}')" class="btn btn-primary "><i
                                        class="fa fa-plus-circle" style="margin-right: 4px"></i>Tambah
                                    Member</button>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive">

                        <form action="" method="POST" class="form-produk">
                            @csrf
                            <table class="table table-striped table-bordered" role="grid">
                                <thead class="text-center">
                                    <th width="5%">No</th>
                                    <th>Kode Member</th>
                                    <th>Nama Member</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th width="10%">Aksi</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    @includeIf('pages.member.form')
@endsection
@push('style')
    <style>
        .modal-dialog {
            margin-top: 0;
            margin-bottom: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .modal.fade .modal-dialog {
            transform: translate(0, -100%);
        }

        .modal.in .modal-dialog {
            transform: translate(0, 0);
        }
    </style>
@endpush

@push('scripts')
    <script>
        let table;

        // reset modal ketika di close
        $('#modal-form').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            $(this).find('.errors').text('');
        })

        // checked all
        $('#select_all').on('click', function() {
            $(':checkbox').prop('checked', this.checked);
        });

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('member.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'kode_member',

                    },
                    {
                        data: 'nama',

                    },
                    {
                        data: 'alamat',

                    },
                    {
                        data: 'telepon',

                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },

                ]
            });

            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('#modal-form form').attr('action'),
                            type: 'POST',
                            data: $('#modal-form form').serialize()
                        })
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            toastr.success(response);
                        })
                        .fail((errors) => {
                            if (errors.status == 422) {
                                $.each(errors.responseJSON.errors, function(i, error) {
                                    var el = $(document).find('[name="' + i + '"]');

                                    el.after($('<p class="errors" style="color: red;">' + error[
                                            0] +
                                        '</p>'));
                                });
                            } else {
                                alert('tidak dapat menambah data');
                            }
                            return;
                        });
                }
            });

        });

        // tambah produk
        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Member');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form form [name=_method]').val('post');
            $('#modal-form form [name=nama]').focus();
        }

        // Edit produk
        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Member');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('patch');
            $('#modal-form form [name=nama]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form form [name=nama]').val(response.nama);
                    $('#modal-form form [name=alamat]').val(response.alamat);
                    $('#modal-form form [name=telepon]').val(response.telepon);

                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                })
        }

        // Hapus Product
        function deleteData(url) {
            $('#modal-form-delete').modal('show');
            $('#modal-form-delete .modal-title').text('Hapus Kategori');

            $('#modal-form-delete form').attr('action', url);

            $('#modal-form-delete').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('#modal-form-delete form').attr('action'),
                            type: 'DELETE',
                            data: $('#modal-form-delete form').serialize()
                        })
                        .done((response) => {
                            $('#modal-form-delete').modal('hide');
                            table.ajax.reload();
                            toastr.success(response);
                        })
                        .fail((errors) => {
                            alert('gagal menghapus data')
                            return;
                        });
                }
            })
            $.get(url)
                .done((response) => {
                    $('#modal-form-delete form [name=nama').text(response.nama);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                })
        }

        // cetak barcode
        function cetakBarcode(url) {

            $('.form-produk').attr('target', '_blank').attr('action', url).submit();

        }
    </script>
@endpush
