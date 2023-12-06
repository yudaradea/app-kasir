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
                            <button onclick="addForm('{{ route('category-store') }}')"
                                class="btn btn-primary xs btn-flat"><i class="fa fa-plus-circle"
                                    style="margin-right: 6px"></i>Tambah
                                Category</button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-bordered text-center" role="grid">
                            <thead>
                                <th width="5%">No</th>
                                <th>Kategory</th>
                                <th width="15%"><i class="fa fa-cog"></i> Aksi</th>
                            </thead>

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

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                // ajax: {
                //     url: '{{ route('category-data') }}'
                // }
            });

            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('#modal-form form').attr('action'),
                            type: 'post',
                            data: $('#modal-form form').serialize()
                        })
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            if (errors.status == 422) {
                                $.each(errors.responseJSON.errors, function(i, error) {
                                    var el = $(document).find('[name="' + i + '"]');

                                    el.after($('<span style="color: red;">' + error[0] +
                                        '</span>'));
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
            $('#modal-form [name_method]').val('post');
            $('#modal-form [name=nama_kategori]').focus();


        }
    </script>
@endpush
