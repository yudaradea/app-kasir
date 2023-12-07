@extends('layouts.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Aplikasi Kasir - Category')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Category
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Category</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-xs-6">
                            <p style="font-size: 22px">List Category</p>
                        </div>
                        <div class="col-xs-6 text-right">
                            <button onclick="addForm('{{ route('category.store') }}')"
                                class="btn btn-primary xs btn-flat"><i class="fa fa-plus-circle"
                                    style="margin-right: 6px"></i>Tambah
                                Category</button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-bordered" role="grid">
                            <thead class="text-center">
                                <th width="5%">No</th>
                                <th>Kategory</th>
                                <th width="15%">Aksi</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    @includeIf('pages.category.form')
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

        $('#modal-form').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            $(this).find('.errors').text('');
        })

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('category') }}",
                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'nama_kategori',
                        name: 'nama_kategori'
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
                            }
                            return;
                        });
                }
            })
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Kategori');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form form [name_method]').val('post');
            $('#modal-form form [name=nama_kategori]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Kategori');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name_method]').val('patch');
            $('#modal-form form [name=nama_kategori]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form form [name=nama_kategori]').val(response.nama_kategori);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                })
        }

        function deleteData(url) {
            $('#modal-form-delete').modal('show');
            $('#modal-form-delete .modal-title').text('Hapus Kategori');

            $('#modal-form-delete form')[0].reset();
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
                            alert('Hapus data gagal, terdapat produk dalam kategori ini')
                            return;
                        });
                }
            })

            $.get(url)
                .done((response) => {
                    $('#modal-form-delete form [name=nama_kategori]').text(response.nama_kategori);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                })
        }
    </script>
@endpush
