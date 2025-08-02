<?= $this->extend('layout/calonsiswa') ?>
<?= $this->section('content') ?>
<style>
    .cat-header {
        background: linear-gradient(90deg, #1976d2 60%, #64b5f6 100%);
        color: #fff;
        border-radius: 10px 10px 0 0;
        padding: 20px 30px 10px 30px;
        margin-bottom: 0;
    }
    .cat-info-table td { padding: 2px 10px; font-size: 1.1em; }
    .cat-soal-card { border-radius: 0 0 10px 10px; }
    .cat-nav-grid { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; margin-top: 10px; }
    .cat-nav-btn { width: 36px; height: 36px; border-radius: 6px; border: none; font-weight: bold; font-size: 1.1em; }
    .cat-nav-btn.answered { background: #43a047; color: #fff; }
    .cat-nav-btn.unanswered { background: #e53935; color: #fff; }
    .cat-nav-btn.active { border: 2px solid #1976d2; }
    .cat-timer { position: fixed; bottom: 30px; right: 40px; background: #222; color: #fff; font-size: 1.5em; padding: 10px 24px; border-radius: 10px; z-index: 999; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
    @media (max-width: 768px) { .cat-header, .cat-soal-card { padding: 10px; } .cat-timer { right: 10px; bottom: 10px; font-size: 1.1em; } }
</style>
<div class="container mt-4 mb-5">
    <div class="cat-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <b>COMPUTER ASSISTED TEST SPMB</b>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <table class="cat-info-table mx-auto mx-md-0">
                    <tr><td>Batas Waktu</td><td>:</td><td><span id="timer">--:--:--</span></td></tr>
                    <tr><td>Jumlah Soal</td><td>:</td><td><?= count($soal) ?></td></tr>
                    <tr><td>Soal Dijawab</td><td>:</td><td><span id="soal-dijawab">0</span></td></tr>
                    <tr><td>Belum Dijawab</td><td>:</td><td><span id="soal-belum">0</span></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card cat-soal-card shadow">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <b>Nama Peserta:</b> <?= esc(session('nama') ?? '-') ?><br>
                    <b>Email:</b> <?= esc(session('username') ?? '-') ?><br>
                    <b>Info Tes:</b> SPMB - <?= esc(session('jurusan_pilihan') ?? '-') ?>
                </div>
                <div class="col-md-6 text-md-end mt-2 mt-md-0">
                    <button type="button" class="btn btn-danger" onclick="if(confirm('Selesaikan ujian?')){document.getElementById('form-ujian').submit();}">SELESAIKAN</button>
                </div>
            </div>
            <hr>
            <form id="form-ujian" action="<?= base_url('spmbtes/submitJawaban/'.$ujian['id']) ?>" method="post">
                <?= csrf_field() ?>
                <?php $no=1; foreach($soal as $s): ?>
                <div class="mb-4 soal-item" data-soal="<?= $no ?>" style="display:<?= $no==1?'block':'none' ?>;">
                    <div class="mb-2"><b>Soal No <?= $no ?>:</b></div>
                    <?php if (!empty($s['gambar'])): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/spmb_soal/'.$s['gambar']) ?>" alt="Gambar Soal" style="max-width:200px;max-height:200px;">
                        </div>
                    <?php endif; ?>
                    <div class="mb-2"><b><?= esc($s['pertanyaan']) ?></b></div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jawaban_<?= $s['id'] ?>" value="a" id="a<?= $s['id'] ?>">
                        <label class="form-check-label" for="a<?= $s['id'] ?>">A. <?= esc($s['pilihan_a']) ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jawaban_<?= $s['id'] ?>" value="b" id="b<?= $s['id'] ?>">
                        <label class="form-check-label" for="b<?= $s['id'] ?>">B. <?= esc($s['pilihan_b']) ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jawaban_<?= $s['id'] ?>" value="c" id="c<?= $s['id'] ?>">
                        <label class="form-check-label" for="c<?= $s['id'] ?>">C. <?= esc($s['pilihan_c']) ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jawaban_<?= $s['id'] ?>" value="d" id="d<?= $s['id'] ?>">
                        <label class="form-check-label" for="d<?= $s['id'] ?>">D. <?= esc($s['pilihan_d']) ?></label>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary btn-sm btn-next">Simpan dan Lanjutkan</button>
                        <button type="button" class="btn btn-secondary btn-sm btn-lewati">Lewatkan Soal Ini</button>
                    </div>
                </div>
                <?php $no++; endforeach; ?>
                <input type="hidden" name="last_soal" id="last_soal" value="1">
            </form>
            <div class="cat-nav-grid mt-4">
                <?php for($i=1;$i<=count($soal);$i++): ?>
                    <button type="button" class="cat-nav-btn unanswered" data-nav="<?= $i ?>"><?= $i ?></button>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <div class="cat-timer" id="cat-timer">--:--:--</div>
</div>
<script>
// Timer (misal 90 menit)
let waktu = 90*60; // 90 menit
function updateTimer() {
    let jam = Math.floor(waktu/3600);
    let menit = Math.floor((waktu%3600)/60);
    let detik = waktu%60;
    document.getElementById('timer').innerText = `${jam.toString().padStart(2,'0')}:${menit.toString().padStart(2,'0')}:${detik.toString().padStart(2,'0')}`;
    document.getElementById('cat-timer').innerText = document.getElementById('timer').innerText;
    if(waktu<=0){ document.getElementById('form-ujian').submit(); }
    waktu--; setTimeout(updateTimer,1000);
}
updateTimer();

// Navigasi soal
let totalSoal = <?= count($soal) ?>;
let jawaban = {};
let current = 1;
function updateGrid() {
    let dijawab = 0;
    for(let i=1;i<=totalSoal;i++) {
        let btn = document.querySelector('.cat-nav-btn[data-nav="'+i+'"]');
        if(jawaban[i]) { btn.classList.remove('unanswered'); btn.classList.add('answered'); dijawab++; }
        else { btn.classList.remove('answered'); btn.classList.add('unanswered'); }
        if(i==current) btn.classList.add('active'); else btn.classList.remove('active');
    }
    document.getElementById('soal-dijawab').innerText = dijawab;
    document.getElementById('soal-belum').innerText = totalSoal-dijawab;
}
function showSoal(n) {
    document.querySelectorAll('.soal-item').forEach(function(div){div.style.display='none';});
    document.querySelector('.soal-item[data-soal="'+n+'"]').style.display='block';
    current = n; updateGrid();
}
document.querySelectorAll('.cat-nav-btn').forEach(function(btn){
    btn.onclick = function(){ showSoal(parseInt(this.dataset.nav)); };
});
document.querySelectorAll('.btn-next').forEach(function(btn,idx){
    btn.onclick = function(){
        let n = idx+1;
        let radios = document.querySelectorAll('.soal-item[data-soal="'+n+'"] input[type=radio]');
        let terisi = false;
        radios.forEach(function(r){ if(r.checked) terisi=true; });
        if(terisi) { jawaban[n]=true; } else { jawaban[n]=false; }
        if(n<totalSoal) showSoal(n+1); else showSoal(1);
        updateGrid();
    };
});
document.querySelectorAll('.btn-lewati').forEach(function(btn,idx){
    btn.onclick = function(){
        let n = idx+1;
        jawaban[n]=false;
        if(n<totalSoal) showSoal(n+1); else showSoal(1);
        updateGrid();
    };
});
document.querySelectorAll('input[type=radio]').forEach(function(radio){
    radio.onchange = function(){
        let soal = parseInt(this.name.replace('jawaban_',''));
        let n = Array.from(document.querySelectorAll('.soal-item')).findIndex(div=>div.querySelector('input[name="jawaban_'+soal+'"]'))+1;
        jawaban[n]=true; updateGrid();
    };
});
updateGrid();
</script>
<?= $this->endSection() ?> 
 