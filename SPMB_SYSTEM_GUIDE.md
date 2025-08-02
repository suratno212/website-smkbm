# SISTEM SPMB (Sistem Penerimaan Murid Baru) - SMK Bhakti Mulya

## Overview
Sistem SPMB adalah modul untuk pendaftaran calon siswa baru secara online. Sistem ini memungkinkan calon siswa untuk mendaftar melalui formulir web dan data akan disimpan ke database.

## Fitur Utama
1. **Formulir Pendaftaran Online** - Calon siswa dapat mengisi formulir pendaftaran
2. **Validasi Data** - Validasi otomatis untuk semua field yang diperlukan
3. **Generate No Pendaftaran** - Nomor pendaftaran otomatis (format: SPMB2025XXXX)
4. **Pembuatan Akun Otomatis** - Akun user dibuat otomatis untuk calon siswa
5. **Cek Status Pendaftaran** - Calon siswa dapat mengecek status pendaftaran
6. **Manajemen Admin** - Admin dapat mengelola data pendaftar

## Struktur Database

### Tabel `spmb`
```sql
CREATE TABLE spmb (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_pendaftaran VARCHAR(20) UNIQUE,
    nama_lengkap VARCHAR(255),
    jenis_kelamin ENUM('Laki-laki', 'Perempuan'),
    tempat_lahir VARCHAR(255),
    tanggal_lahir DATE,
    agama_id INT,
    alamat TEXT,
    asal_sekolah VARCHAR(255),
    nama_ortu VARCHAR(255),
    no_hp_ortu VARCHAR(20),
    email VARCHAR(255),
    no_hp VARCHAR(20),
    jurusan_pilihan VARCHAR(100),
    nis VARCHAR(20) UNIQUE,
    status_pendaftaran ENUM('Menunggu', 'Diterima', 'Ditolak', 'Diterima Bersyarat'),
    catatan TEXT,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (agama_id) REFERENCES agama(id)
);
```

## File-file Penting

### Controller
- `app/Controllers/Spmb.php` - Controller utama untuk SPMB
- `app/Controllers/Admin/Spmb.php` - Controller admin untuk manajemen SPMB

### Model
- `app/Models/SpmbModel.php` - Model untuk operasi database SPMB

### Views
- `app/Views/spmb/daftar.php` - Formulir pendaftaran
- `app/Views/spmb/sukses.php` - Halaman sukses pendaftaran
- `app/Views/spmb/cek_status.php` - Form cek status
- `app/Views/spmb/status.php` - Halaman status pendaftaran
- `app/Views/admin/spmb/index.php` - Dashboard admin SPMB

### Routes
```php
// Routes untuk SPMB
$routes->get('spmb', 'Spmb::index');
$routes->get('spmb/daftar', 'Spmb::daftar');
$routes->post('spmb/daftar', 'Spmb::daftar');
$routes->get('spmb/sukses', 'Spmb::sukses');
$routes->get('spmb/cek-status', 'Spmb::cekStatus');
$routes->post('spmb/cek-status', 'Spmb::cekStatusPost');
```

## Alur Pendaftaran

### 1. Calon Siswa
1. Mengakses halaman pendaftaran: `http://localhost:8080/spmb/daftar`
2. Mengisi formulir dengan data lengkap
3. Submit formulir
4. Sistem validasi data
5. Generate nomor pendaftaran
6. Simpan ke database
7. Buat akun user otomatis
8. Redirect ke halaman sukses

### 2. Admin
1. Login ke sistem admin
2. Akses menu SPMB
3. Lihat daftar pendaftar
4. Review data pendaftar
5. Update status (Diterima/Ditolak/Diterima Bersyarat)
6. Jadikan siswa (untuk yang diterima)

## Validasi Form

### Field yang Diperlukan
- `nama_lengkap` - Minimal 3 karakter
- `jenis_kelamin` - Laki-laki atau Perempuan
- `tempat_lahir` - Wajib diisi
- `tanggal_lahir` - Format tanggal valid
- `agama_id` - ID agama yang valid
- `alamat` - Wajib diisi
- `asal_sekolah` - Wajib diisi
- `nama_ortu` - Wajib diisi
- `no_hp_ortu` - Numerik
- `email` - Format email valid dan unik
- `no_hp` - Numerik
- `kd_jurusan` - Jurusan yang valid
- `nis` - Unik

## Generate No Pendaftaran

Format: `SPMB` + `TAHUN` + `4 DIGIT URUTAN`

Contoh:
- SPMB20250001
- SPMB20250002
- dst.

## Status Pendaftaran

1. **Menunggu** - Status default saat pendaftaran
2. **Diterima** - Pendaftar diterima sebagai siswa
3. **Ditolak** - Pendaftar ditolak
4. **Diterima Bersyarat** - Diterima dengan syarat tertentu

## Pembuatan Akun Otomatis

Saat pendaftaran berhasil, sistem otomatis membuat akun user dengan:
- Username: Email pendaftar
- Password: Tanggal lahir (format YYYY-MM-DD)
- Role: calon_siswa
- Nama: Nama lengkap pendaftar

## Troubleshooting

### Masalah Umum

1. **Form tidak tersubmit**
   - Periksa CSRF token
   - Periksa validasi JavaScript
   - Periksa log error

2. **Data tidak masuk database**
   - Periksa koneksi database
   - Periksa validasi form
   - Periksa unique constraint (email, NIS)

3. **Dropdown kosong**
   - Periksa data agama dan jurusan
   - Periksa query di controller

4. **Error validasi**
   - Periksa format data yang dimasukkan
   - Periksa rule validasi di controller

### Debug Tips

1. **Cek Log**
   ```bash
   tail -f writable/logs/log-YYYY-MM-DD.log
   ```

2. **Test Database**
   ```bash
   php spark db:table spmb
   ```

3. **Test Form Submission**
   ```bash
   php test_spmb_form_submission.php
   ```

## Testing

### Manual Testing
1. Buka browser: `http://localhost:8080/spmb/daftar`
2. Isi formulir dengan data test
3. Submit formulir
4. Verifikasi redirect ke halaman sukses
5. Cek database untuk data baru
6. Cek akun user baru

### Automated Testing
Jalankan script test:
```bash
php test_spmb_simple.php
php test_spmb_form_submission.php
```

## Keamanan

1. **CSRF Protection** - Semua form menggunakan CSRF token
2. **Input Validation** - Validasi server-side untuk semua input
3. **SQL Injection Protection** - Menggunakan prepared statements
4. **XSS Protection** - Output escaping di views

## Performance

1. **Database Indexing** - Index pada field yang sering dicari
2. **Caching** - Cache data agama dan jurusan
3. **Validation** - Client-side validation untuk UX yang lebih baik

## Maintenance

### Backup Database
```bash
mysqldump -u root -p siakad_smk_bm spmb > backup_spmb.sql
```

### Cleanup Data
```bash
# Hapus data test
DELETE FROM spmb WHERE email LIKE '%test%';
```

### Update Status Batch
```sql
UPDATE spmb SET status_pendaftaran = 'Diterima' WHERE created_at < '2025-01-01';
```

## Support

Jika ada masalah dengan sistem SPMB:
1. Cek log error
2. Jalankan script test
3. Periksa koneksi database
4. Verifikasi data master (agama, jurusan)
5. Hubungi administrator sistem 