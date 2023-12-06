<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <form action="" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk" required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="id_kategory" class="form-control" required>
                            <option value="">--Pilih Kategori--</option>
                            @foreach ($kategori as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Merk</label>
                        <input type="text" class="form-control" name="merk" required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label>Harga beli</label>
                        <input type="number" class="form-control" name="harga_beli" required>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Harga jual</label>
                        <input type="number" class="form-control" name="harga_jual" required>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Diskon</label>
                        <input type="number" class="form-control" name="diskon" required value="0">
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" name="stok" required value="0">
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal Delete-->
<div class="modal fade bs-example-modal-sm" id="modal-form-delete" tabindex="-1" role="dialog"
    aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <form action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <p>Hapus kategori <b name="nama_kategori"></b>?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
