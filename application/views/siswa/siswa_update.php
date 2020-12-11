<div class="container-fluid">
    <div class="alert alert-success" role="alert">
        <i class="fas fa-university"></i> Form Update Siswa
    </div>

    <?php foreach ($siswa as $gr) : ?>
        <?= form_open_multipart('administrator/siswa/update_siswa_aksi'); ?>

        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label for="">nis</label>
                    <input type="hidden" name="id_siswa" value="<?= $gr->id_siswa; ?>">
                    <input type="text" name="nis" class="form-control" value="<?= $gr->nis; ?>">
                    <?= form_error('nis', '<div class="text-danger small">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="">Nama siswa</label>
                    <input type="text" name="nama_siswa" class="form-control" value="<?= $gr->nama_siswa; ?>">
                    <?= form_error('nama_siswa', '<div class="text-danger small">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="">Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="<?= $gr->alamat; ?>">
                    <?= form_error('alamat', '<div class="text-danger small">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="" class="form-control" value="<?= $gr->jenis_kelamin; ?>">
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                    </select>
                    <?= form_error('jenis_kelamin', '<div class="text-danger small">', '</div>'); ?>
                </div>
                <!-- <div class="form-group">
                    <label for="">Kelas</label>
                    <select name="nama_kelas" id="" class="form-control">
                        <option value=""><?= $gr->nama_kelas; ?></option>
                        <?php foreach ($kelas as $kls) : ?>
                            <option value="<?= $kls->nama_kelas; ?>"><?= $kls->nama_kelas; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('nama_kelas', '<div class="text-danger small">', '</div>'); ?>
                </div> -->
                <div class="form-group">
                    <label for="">Kelas</label>
                    <select name="nama_kelas" id="" class="form-control">
                        <option><?= $gr->nama_kelas; ?></option>
                        <?php foreach ($kelas as $kls) : ?>
                            <option value="<?= $kls->nama_kelas; ?>"><?= $kls->nama_kelas; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <?php foreach ($detail as $dt) : ?>
                        <img src="<?= base_url('assets/uploads/') . $gr->photo; ?>" style="width:20%;">
                    <?php endforeach; ?><br><br>
                    <label for="">Foto</label><br>
                    <input type="file" name="userfile" value="<?= $gr->photo; ?>">
                </div>

                <button type="submit" class="btn btn-primary mb-5">Simpan</button>

            </div>
        </div>

        <?= anchor('administrator/siswa', '<div class="btn btn-primary btn-sm mb-5">Kembali</div>') ?>
        <?php form_close(); ?>
    <?php endforeach; ?>
</div>