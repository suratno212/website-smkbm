<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Jadwal Pelajaran</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Daftar Jadwal Pelajaran</h3>
            </div>
            <div class="card-body">
              <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?= session()->getFlashdata('success') ?>
                </div>
              <?php endif; ?>

              <div class="mb-3 d-flex align-items-center gap-2">
                <form method="get" action="" class="form-inline">
                  <label for="kelas_id" class="mr-2">Pilih Kelas:</label>
                  <select name="kelas_id" id="kelas_id" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach ($kelas as $k): ?>
                      <option value="<?= $k['kd_kelas'] ?>" <?= $filter_kelas == $k['kd_kelas'] ? 'selected' : '' ?>><?= $k['nama_kelas'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </form>
                <a href="<?= base_url('admin/jadwal/cetak?kelas_id=' . $filter_kelas) ?>" target="_blank" class="btn btn-success ml-2"><i class="fas fa-print"></i> Cetak Jadwal</a>
                <button class="btn btn-primary ml-2" data-toggle="modal" data-target="#modalDuplicateJadwal">Duplikasi Jadwal</button>
                <button class="btn btn-primary ml-2" id="btnModelBaru">Buat Model Baru</button>
              </div>

              <?php
              $jamList = [
                ['label' => '07:30–08:30', 'start' => '07:30', 'end' => '08:30'],
                ['label' => '08:30–09:30', 'start' => '08:30', 'end' => '09:30'],
                ['label' => '09:30–10:00', 'start' => '09:30', 'end' => '10:00', 'istirahat' => 'Istirahat 1'],
                ['label' => '10:00–11:00', 'start' => '10:00', 'end' => '11:00'],
                ['label' => '11:00–12:00', 'start' => '11:00', 'end' => '12:00'],
                ['label' => '12:00–13:00', 'start' => '12:00', 'end' => '13:00', 'istirahat' => 'Istirahat 2'],
                ['label' => '13:00–14:00', 'start' => '13:00', 'end' => '14:00'],
                ['label' => '14:00–15:00', 'start' => '14:00', 'end' => '15:00'],
                ['label' => '15:00–16:00', 'start' => '15:00', 'end' => '16:00'],
              ];
              $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
              // Buat array jadwal indexed by hari & jam_mulai
              $jadwalMatrix = [];
              foreach ($jadwal as $j) {
                $keyJam = substr($j['jam_mulai'], 0, 5); // ambil jam:menit saja
                $jadwalMatrix[$j['hari']][$keyJam] = $j;
              }
              ?>
              <table class="table table-bordered text-center jadwal-matrix">
                <thead class="thead-light">
                  <tr>
                    <th>Jam/Hari</th>
                    <?php foreach ($hariList as $hari): ?>
                      <th><?= $hari ?></th>
                    <?php endforeach; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($jamList as $jam): ?>
                    <tr>
                      <td><strong><?= $jam['label'] ?></strong><?php if (isset($jam['istirahat'])): ?><br><span class="badge bg-warning text-dark"><?= $jam['istirahat'] ?></span><?php endif; ?></td>
                      <?php foreach ($hariList as $hari): ?>
                        <td class="jadwal-cell" data-hari="<?= $hari ?>" data-jam="<?= $jam['start'] ?>" style="cursor:pointer;min-width:120px;min-height:60px;background:#e3f2fd;text-align:left;vertical-align:middle;" onclick="editJadwal('<?= $hari ?>','<?= $jam['start'] ?>')">
                          <?php if (isset($jadwalMatrix[$hari][$jam['start']])): ?>
                            <div style="font-weight:bold;"><?= esc($jadwalMatrix[$hari][$jam['start']]['nama_mapel']) ?></div>
                            <div><small><?= esc($jadwalMatrix[$hari][$jam['start']]['nama_guru']) ?></small></div>
                          <?php else: ?>
                            <span class="text-muted">-</span>
                          <?php endif; ?>
                        </td>
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

              <!-- Modal Edit Jadwal -->
              <div class="modal fade" id="modalEditJadwal" tabindex="-1" role="dialog" aria-labelledby="modalEditJadwalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <form id="formEditJadwal" method="post" action="<?= base_url('admin/jadwal/store') ?>">
                      <?= csrf_field() ?>
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalEditJadwalLabel">Edit Jadwal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="kelas_id" value="<?= esc($filter_kelas) ?>">
                        <input type="hidden" name="hari" id="modal_hari">
                        <input type="hidden" name="jam_mulai" id="modal_jam_mulai">
                        <input type="hidden" name="jam_selesai" id="modal_jam_selesai">
                        <div class="form-group">
                          <label for="modal_mapel_id">Mata Pelajaran</label>
                          <select name="mapel_id" id="modal_mapel_id" class="form-control" required>
                            <?php foreach ($mapel as $m): ?>
                              <option value="<?= $m['kd_mapel'] ?>"><?= $m['nama_mapel'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="modal_guru_id">Guru</label>
                          <select name="guru_id" id="modal_guru_id" class="form-control" required>
                            <?php foreach ($guru as $g): ?>
                              <option value="<?= $g['nik_nip'] ?>"><?= $g['nama'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Modal Duplikasi Jadwal -->
              <div class="modal fade" id="modalDuplicateJadwal" tabindex="-1" role="dialog" aria-labelledby="modalDuplicateJadwalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <form method="post" action="<?= base_url('admin/jadwal/duplicate') ?>">
                      <?= csrf_field() ?>
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalDuplicateJadwalLabel">Duplikasi Jadwal (Template)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="kelas_asal">Kelas Asal</label>
                          <select name="kelas_asal" id="kelas_asal" class="form-control" required>
                            <option value="">-- Pilih Kelas Asal --</option>
                            <?php foreach ($kelas as $k): ?>
                              <option value="<?= $k['kd_kelas'] ?>"><?= $k['nama_kelas'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="tahun_akademik_asal">Tahun Akademik Asal</label>
                          <select name="tahun_akademik_asal" id="tahun_akademik_asal" class="form-control" required>
                            <option value="">-- Pilih Tahun Akademik Asal --</option>
                            <?php foreach ($tahun_akademik as $ta): ?>
                              <option value="<?= isset($ta['kd_tahun_akademik']) ? $ta['kd_tahun_akademik'] : (isset($ta['id']) ? $ta['id'] : '') ?>"><?= $ta['tahun'] ?> - Semester <?= $ta['semester'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="kelas_tujuan">Kelas Tujuan</label>
                          <select name="kelas_tujuan" id="kelas_tujuan" class="form-control" required>
                            <option value="">-- Pilih Kelas Tujuan --</option>
                            <?php foreach ($kelas as $k): ?>
                              <option value="<?= $k['kd_kelas'] ?>"><?= $k['nama_kelas'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="tahun_akademik_tujuan">Tahun Akademik Tujuan</label>
                          <select name="tahun_akademik_tujuan" id="tahun_akademik_tujuan" class="form-control" required>
                            <option value="">-- Pilih Tahun Akademik Tujuan --</option>
                            <?php foreach ($tahun_akademik as $ta): ?>
                              <option value="<?= isset($ta['kd_tahun_akademik']) ? $ta['kd_tahun_akademik'] : (isset($ta['id']) ? $ta['id'] : '') ?>"><?= $ta['tahun'] ?> - Semester <?= $ta['semester'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Duplikasi</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <script>
                function editJadwal(hari, jamMulai) {
                  // Set value ke modal
                  document.getElementById('modal_hari').value = hari;
                  document.getElementById('modal_jam_mulai').value = jamMulai;
                  // Cari jam_selesai dari jamList
                  var jamSelesai = '';
                  <?php foreach ($jamList as $jam): ?>
                    if (jamMulai === '<?= $jam['start'] ?>') jamSelesai = '<?= $jam['end'] ?>';
                  <?php endforeach; ?>
                  document.getElementById('modal_jam_selesai').value = jamSelesai;
                  $('#modalEditJadwal').modal('show');
                }
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>