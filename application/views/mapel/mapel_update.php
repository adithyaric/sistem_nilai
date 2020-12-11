<div class="container-fluid">
    <div class="alert alert-success" role="alert">
        <i class="fas fa-edit"></i> Form Edit Mata Pelajaran
    </div>

    <?php foreach ($mapel as $mp) : ?>
        <form action="<?= base_url('administrator/mapel/update_aksi') ?>" method="post">

            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="">Nama Mata Pelajaran</label>
                        <input type="hidden" name="id_mapel" class="form-control" value="<?= $mp->id_mapel ?>">
                        <input type="text" name="nama_mapel" class="form-control" value="<?= $mp->nama_mapel ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Guru</label>
                        <select name="nama_guru" id="" class="form-control">
                            <option><?= $mp->nama_guru; ?></option>
                            <?php foreach ($guru as $gr) : ?>
                                <option value="<?= $gr->nama_guru; ?>"><?= $gr->nama_guru; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>

                </div>
            </div>

        </form>
    <?php endforeach; ?>

</div>