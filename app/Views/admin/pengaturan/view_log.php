<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/pengaturan') ?>">Pengaturan</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/pengaturan/logs') ?>">Log Sistem</a></li>
                        <li class="breadcrumb-item active">View Log</li>
                    </ol>
                </div>
                <h4 class="page-title">View Log: <?= $filename ?></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Isi Log File</h4>
                        <div>
                            <button class="btn btn-secondary btn-sm" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <a href="<?= base_url('admin/pengaturan/logs') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nama File:</strong> <?= $filename ?><br>
                                <strong>Ukuran:</strong> <?= number_format(strlen($content) / 1024, 2) ?> KB
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard()">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                                <button class="btn btn-sm btn-outline-info" onclick="toggleWrap()">
                                    <i class="fas fa-text-width"></i> Toggle Wrap
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="log-content">
                        <pre id="logContent" class="bg-dark text-light p-3 rounded" style="max-height: 600px; overflow-y: auto; white-space: pre-wrap; font-family: 'Courier New', monospace; font-size: 12px;"><?= htmlspecialchars($content) ?></pre>
                    </div>

                    <?php if (empty($content)) : ?>
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">File log kosong</h5>
                            <p class="text-muted">Tidak ada konten dalam file log ini</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Log -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Statistik Log</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-primary"><?= substr_count($content, 'ERROR') ?></h3>
                                <p class="text-muted">Error</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-warning"><?= substr_count($content, 'WARNING') ?></h3>
                                <p class="text-muted">Warning</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-info"><?= substr_count($content, 'INFO') ?></h3>
                                <p class="text-muted">Info</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-success"><?= substr_count($content, 'DEBUG') ?></h3>
                                <p class="text-muted">Debug</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .page-title-box, .card-header, .btn {
        display: none !important;
    }
    .log-content {
        max-height: none !important;
    }
}

.log-content pre {
    background-color: #1e1e1e !important;
    color: #d4d4d4 !important;
    border: 1px solid #333;
}

.log-content pre::-webkit-scrollbar {
    width: 8px;
}

.log-content pre::-webkit-scrollbar-track {
    background: #2d2d2d;
}

.log-content pre::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 4px;
}

.log-content pre::-webkit-scrollbar-thumb:hover {
    background: #777;
}
</style>

<script>
function copyToClipboard() {
    const logContent = document.getElementById('logContent').textContent;
    navigator.clipboard.writeText(logContent).then(function() {
        // Show success message
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}

function toggleWrap() {
    const pre = document.getElementById('logContent');
    if (pre.style.whiteSpace === 'pre') {
        pre.style.whiteSpace = 'pre-wrap';
        event.target.innerHTML = '<i class="fas fa-text-width"></i> No Wrap';
    } else {
        pre.style.whiteSpace = 'pre';
        event.target.innerHTML = '<i class="fas fa-text-width"></i> Toggle Wrap';
    }
}

// Syntax highlighting for log levels
document.addEventListener('DOMContentLoaded', function() {
    const pre = document.getElementById('logContent');
    let content = pre.innerHTML;
    
    // Highlight ERROR
    content = content.replace(/(ERROR)/g, '<span style="color: #ff6b6b; font-weight: bold;">$1</span>');
    
    // Highlight WARNING
    content = content.replace(/(WARNING)/g, '<span style="color: #ffd93d; font-weight: bold;">$1</span>');
    
    // Highlight INFO
    content = content.replace(/(INFO)/g, '<span style="color: #6bcf7f; font-weight: bold;">$1</span>');
    
    // Highlight DEBUG
    content = content.replace(/(DEBUG)/g, '<span style="color: #4ecdc4; font-weight: bold;">$1</span>');
    
    pre.innerHTML = content;
});
</script>
<?= $this->endSection() ?> 