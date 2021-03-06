<body>
    <div class="container">
        <?php
        if (!empty($this->session->userdata('ses_id_kelas'))) {
            echo "kelas : " . $kelas->nama_kelas;
        }
        ?>
        <div class="row mt-2">
            <div class="col-12">
                <?= @$this->session->flashdata('msg') ?>
                <?= $this->session->flashdata('pesan'); ?>
                <?php if ($this->session->userdata('akses') != 'admin') : ?>
                    <div class="card">
                        <div class="card-body">
                            <?= form_open_multipart('penilaian/nilai/uploaddata'); ?>
                            <div class="form-row">
                                <div class="col ">
                                    <input type="file" class="form-control-file" id="importexcel" name="importexcel" accept=".xlsx, .xls">
                                </div>
                                <div class="col-4" style="border: black;">
                                    <select name="tahun_akademik" id="" class="form-control">
                                        <?php foreach ($tahun_akademik as $t) :
                                            if ($t->status == 'aktif') :
                                        ?>
                                                <option value="<?= $t->id; ?>"><?= $t->tahun_akademik . " " . $t->semester; ?></option>
                                        <?php
                                            endif;
                                        endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                <?php endif ?>
                <div class="card mt-2">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">NIS</th>
                                    <th scope="col">TUGAS</th>
                                    <th scope="col">UTS</th>
                                    <th scope="col">UAS</th>
                                    <th scope="col">MAPEL</th>
                                    <th scope="col">GURU</th>
                                    <th scope="col">TAHUN AJARAN</th>
                                    <th colspan="2">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($nilai as $n) :
                                ?>
                                    <tr>
                                        <th><?= $i++; ?></th>
                                        <td><?= $n['nis']; ?></td>
                                        <td><?= $n['tugas']; ?></td>
                                        <td><?= $n['uts']; ?></td>
                                        <td><?= $n['uas']; ?></td>
                                        <td><?= $n['nama_mapel']; ?></td>
                                        <td><?= $n['nama_guru']; ?></td>
                                        <td>
                                            <?php echo $n['tahun_akademik'];

                                            if ($n['semester'] == "ganjil") { ?>
                                                <span class="badge badge-warning">Ganjil</span>
                                            <?php } else { ?>
                                                <span class="badge badge-success">Genap</span>
                                            <?php } ?>
                                        </td>
                                        <td width="20px"><?= anchor('penilaian/nilai/update/' . $n['id_nilai'], '<div class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></div>') ?></td>

                                        <td width="20px">
                                            <a onclick="deleteConfirm('<?php echo site_url('penilaian/nilai/delete/' . $n['id_nilai']) ?>')" href="#!" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>