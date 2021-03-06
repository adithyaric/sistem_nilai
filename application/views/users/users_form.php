<div class="container-fluid">
  <div class="alert alert-success" role="alert">
    <i class="fas fa-university"></i> Form Tambah Users
  </div>

  <form action="<?= base_url('administrator/users/tambah_users_aksi') ?>" method="post">
    <div class="row">
      <div class="col-md-6">
        <?= @$this->session->flashdata('msg') ?>
        <div class="form-group">
          <label for="">Username</label>
          <input type="text" name="username" value="<?= set_value('username'); ?>" placeholder="Masukkan username" class="form-control">
          <?= form_error('username', '<div class="text-danger small">', '</div>'); ?>
        </div>
        <div class="form-group">
          <label for="">Password</label>
          <input type="password" name="password" value="<?= set_value('password'); ?>" placeholder="Masukkan password" class="form-control">
          <?= form_error('password', '<div class="text-danger small">', '</div>'); ?>
        </div>
        <div class="form-group">
          <label for="">Email</label>
          <input type="text" name="email" value="<?= set_value('email'); ?>" placeholder="Masukkan email" class="form-control">
          <?= form_error('email', '<div class="text-danger small">', '</div>'); ?>
        </div>
        <div class="form-group">
          <label for="">Blokir</label>
          <select name="blokir" id="" class="form-control">
            <option value="Y" selected>Ya</option>
            <option value="N">Tidak</option>
          </select>
          <?= form_error('blokir', '<div class="text-danger small">', '</div>'); ?>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <?= anchor('administrator/users', '<div class="btn btn-info">Kembali</div>') ?>
      </div>
    </div>
  </form>
</div>