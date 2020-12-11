<div class="container-fluid">
    <div class="alert alert-success" role="alert">
        <i class="fas fa-university"></i> Kelas
    </div>

    <?= $this->session->flashdata('pesan'); ?>

    <?= anchor('administrator/kelas/tambah_kelas', '<button class="btn btn-primary btn-sm mb-2"><i class="fas fa-plus fa-sm"></i> Tambah Kelas</button>') ?>

    <table class="table tabel-bordered table-hover table-striped">
        <tr>
            <th>NO</th>
            <th>Nama Kelas</th>
            <th>Nama Guru</th>
            <th colspan="2">AKSI</th>
        </tr>

        <?php
        $no = 1;
        foreach ($kelas as $mp) : ?>
            <tr>
                <td width="20px;"><?= $no++; ?></td>
                <td><?= $mp->nama_kelas; ?></td>
                <td><?= $mp->nama_guru; ?></td>
                <td width="20px"><?= anchor('administrator/kelas/update/' . $mp->id_kelas, '<div class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></div>') ?></td>
                <td width="20px"><?= anchor('administrator/kelas/delete/' . $mp->id_kelas, '<div onclick="return confirm(\'Yakin akan menghapus?\')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></div>') ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>