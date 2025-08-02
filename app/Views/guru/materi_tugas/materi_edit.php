<?= $this->extend('layout/guru') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Edit Materi</h3>
    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('guru/materitugas/updateMateri/' . $materi['kd_materi']) ?>" method="post" enctype="multipart/form-data" class="mt-3">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="kd_kelas" class="form-label">Kelas</label>
            <select name="kd_kelas" id="kd_kelas" class="form-select" required>
                <option value="">- Pilih Kelas -</option>
                <?php if (!empty($kelas_diampu)): foreach ($kelas_diampu as $k): ?>
                        <option value="<?= $k['kd_kelas'] ?>" <?= (old('kd_kelas', $materi['kd_kelas']) == $k['kd_kelas']) ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
                <?php endforeach;
                endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="kd_mapel" class="form-label">Mata Pelajaran</label>
            <select name="kd_mapel" id="kd_mapel" class="form-select" required>
                <option value="">- Pilih Mata Pelajaran -</option>
                <?php if (!empty($mapel_diampu)): foreach ($mapel_diampu as $m): ?>
                        <option value="<?= $m['kd_mapel'] ?>" <?= (old('kd_mapel', $materi['kd_mapel']) == $m['kd_mapel']) ? 'selected' : '' ?>><?= esc($m['nama_mapel']) ?></option>
                <?php endforeach;
                endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Materi</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?= old('judul', $materi['judul']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required><?= old('deskripsi', $materi['deskripsi']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">File Materi (pdf, doc, docx, ppt, pptx, max 10MB)</label>
            <?php if ($materi['file']): ?>
                <div class="alert alert-info">
                    <strong>File saat ini:</strong> <?= $materi['file'] ?>
                    <br><small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                </div>
            <?php endif; ?>
            <input type="file" name="file" id="file" class="form-control">
        </div>
        <div class="mb-3">
            <label for="video_url" class="form-label">Link Video YouTube (Opsional)</label>
            <input type="url" name="video_url" id="video_url" class="form-control" value="<?= old('video_url', $materi['video_url'] ?? '') ?>" placeholder="https://www.youtube.com/watch?v=...">
            <small class="form-text text-muted">Masukkan link video YouTube untuk materi pembelajaran</small>
            <div id="videoPreview" class="mt-2" style="display: none;">
                <div class="alert alert-info">
                    <strong>Preview Video:</strong>
                    <div id="videoEmbed"></div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Materi</button>
        <a href="<?= base_url('guru/materitugas/materi') ?>" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoUrlInput = document.getElementById('video_url');
        const videoPreview = document.getElementById('videoPreview');
        const videoEmbed = document.getElementById('videoEmbed');

        function extractYouTubeVideoId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        function showVideoPreview(url) {
            const videoId = extractYouTubeVideoId(url);
            if (videoId) {
                videoEmbed.innerHTML = `
                <div class="ratio ratio-16x9 mt-2">
                    <iframe src="https://www.youtube.com/embed/${videoId}" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            `;
                videoPreview.style.display = 'block';
            } else {
                videoPreview.style.display = 'none';
            }
        }

        videoUrlInput.addEventListener('input', function() {
            const url = this.value.trim();
            if (url) {
                showVideoPreview(url);
            } else {
                videoPreview.style.display = 'none';
            }
        });

        // Show preview if there's already a value
        if (videoUrlInput.value.trim()) {
            showVideoPreview(videoUrlInput.value);
        }
    });
</script>
<?= $this->endSection() ?>