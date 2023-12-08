@extends('layouts.master')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Aplikasi Kasir - Category')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Product
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Product</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-xs-6">
                            <p style="font-size: 22px">List Product</p>
                        </div>
                        <div class="col-xs-6 text-right">
                            <div class="btn-group">
                                <button onclick="addForm('{{ route('product.store') }}')" class="btn btn-primary "><i
                                        class="fa fa-plus-circle" style="margin-right: 4px"></i>Tambah
                                    Product</button>

                                <button onclick="cetakBarcode('{{ route('produk.cetak.barcode') }}')"
                                    class="btn btn-secondary " style="margin-left: 6px"><i class="fa fa-barcode"
                                        style="margin-right: 4px"></i>Cetak barcode</button>

                                <button onclick="hapusSelected('{{ route('produk.hapus.selected') }}')"
                                    class="btn btn-danger " style="margin-left: 6px"><i class="fa fa-trash"
                                        style="margin-right: 4px"></i>Hapus
                                    Selected</button>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive">

                        <form action="" method="POST" class="form-produk">
                            @csrf
                            <table class="table table-striped table-bordered" role="grid">
                                <thead class="text-center">
                                    <th><input type="checkbox" name="select_all" id="select_all"></th>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Merk</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Diskon</th>
                                    <th>Stok</th>
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

    @includeIf('pages.product.form')
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
                ajax: "{{ route('product.index') }}",
                columns: [

                    {
                        data: 'select_all',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'kode_produk',

                    },
                    {
                        data: 'nama_produk',

                    },
                    {
                        data: 'nama_kategori',

                    },
                    {
                        data: 'merk',

                    },

                    {
                        data: 'harga_beli',

                    },
                    {
                        data: 'harga_jual',

                    },
                    {
                        data: 'diskon',

                    },
                    {
                        data: 'stok',

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
            $('#modal-form .modal-title').text('Tambah Produk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form form [name=_method]').val('post');
            $('#modal-form form [name=nama_produk]').focus();
        }

        // Edit produk
        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Produk');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('patch');
            $('#modal-form form [name=nama_produk]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form form [name=nama_produk]').val(response.nama_produk);
                    $('#modal-form form [name=id_kategory]').val(response.id_kategory);
                    $('#modal-form form [name=merk]').val(response.merk);
                    $('#modal-form form [name=harga_beli]').val(response.harga_beli);
                    $('#modal-form form [name=harga_jual]').val(response.harga_jual);
                    $('#modal-form form [name=diskon]').val(response.diskon);
                    $('#modal-form form [name=stok]').val(response.stok);

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
                    $('#modal-form-delete form [name=nama_produk]').text(response.nama_produk);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                })
        }

        function hapusSelected(url) {
            if ($('input:checked').length >= 1) {
                let dataTerpilih = $('[name="id_produk[]"]:checked').length;
                $('#modal-form-delete-selected').modal('show');
                $('#modal-form-delete-selected .modal-title').text('Hapus Kategori');

                $('#modal-form-delete-selected form').attr('action', url);

                $('#modal-form-delete-selected form [name=dataTerpilih]').text(dataTerpilih);

                $('#modal-form-delete-selected').validator().on('submit', function(e) {
                    if (!e.preventDefault()) {
                        $.ajax({
                                url: $('#modal-form-delete-selected form').attr('action'),
                                type: 'post',
                                data: $('.form-produk').serialize()
                            })
                            .done((response) => {
                                $('#modal-form-delete-selected').modal('hide');
                                table.ajax.reload();
                                toastr.success(response);
                                $('#select_all').prop('checked', false);
                            })
                            .fail((errors) => {
                                alert('gagal menghapus data terpilih')
                                return;
                            });
                    }
                })
            } else {
                alert('pilih data yang akan dihapus');
                return;
            }
        }

        // cetak barcode
        function cetakBarcode(url) {
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak')
            } else if ($('input:checked').length < 3) {
                alert('minimal pilih 3 produk')
            } else {
                $('.form-produk').attr('target', '_blank').attr('action', url).submit();
            }
        }
    </script>
@endpush
