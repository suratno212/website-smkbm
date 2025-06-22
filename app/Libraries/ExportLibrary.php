<?php

namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use TCPDF;

class ExportLibrary
{
    public function exportExcel($data, $headers, $title, $filename = 'export.xlsx', $options = [])
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:' . $this->getColumnLetter(count($headers)) . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1a237e');
        $sheet->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');

        // Subtitle jika ada
        if (isset($options['subtitle'])) {
            $sheet->setCellValue('A2', $options['subtitle']);
            $sheet->mergeCells('A2:' . $this->getColumnLetter(count($headers)) . '2');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getFont()->setItalic(true);
        }

        // Header tabel
        $col = 'A';
        $row = isset($options['subtitle']) ? 4 : 3;
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('f0f0f0');
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $col++;
        }

        // Data
        $row++;
        $no = 1;
        foreach ($data as $item) {
            $col = 'A';
            foreach ($headers as $key => $header) {
                $value = '';
                if ($key === 0) {
                    $value = $no++;
                } else {
                    $value = $item[$key] ?? '';
                }
                
                $sheet->setCellValue($col . $row, $value);
                $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                
                // Align center for numbers and dates
                if (is_numeric($value) || strtotime($value)) {
                    $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                
                $col++;
            }
            $row++;
        }

        // Auto size columns
        foreach (range('A', $this->getColumnLetter(count($headers))) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Add filters
        $sheet->setAutoFilter('A' . (isset($options['subtitle']) ? 4 : 3) . ':' . $this->getColumnLetter(count($headers)) . ($row - 1));

        // Create writer
        $writer = new Xlsx($spreadsheet);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Save to output
        $writer->save('php://output');
        exit;
    }

    public function exportPDF($data, $headers, $title, $filename = 'export.pdf', $options = [])
    {
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('SIAKAD SMK Bhakti Mulya');
        $pdf->SetAuthor('SIAKAD System');
        $pdf->SetTitle($title);

        // Set margins
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 25);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 10);

        // Title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        
        // Subtitle
        if (isset($options['subtitle'])) {
            $pdf->SetFont('helvetica', 'I', 12);
            $pdf->Cell(0, 8, $options['subtitle'], 0, 1, 'C');
        }
        
        $pdf->Ln(5);

        // Table header
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetFillColor(26, 35, 126); // Primary color
        $pdf->SetTextColor(255, 255, 255);
        
        $widths = $this->calculateColumnWidths($headers, $data);
        
        foreach ($headers as $i => $header) {
            $pdf->Cell($widths[$i], 7, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();

        // Table data
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(248, 249, 250);
        
        $no = 1;
        $fill = false;
        foreach ($data as $item) {
            $col = 0;
            foreach ($headers as $key => $header) {
                $value = '';
                if ($key === 0) {
                    $value = $no++;
                } else {
                    $value = $item[$key] ?? '';
                }
                
                $pdf->Cell($widths[$col], 6, $value, 1, 0, 'C', $fill);
                $col++;
            }
            $pdf->Ln();
            $fill = !$fill; // Alternate row colors
        }

        // Output PDF
        $pdf->Output($filename, 'D');
        exit;
    }

    // Helper method untuk mendapatkan huruf kolom
    private function getColumnLetter($columnNumber)
    {
        $letter = '';
        while ($columnNumber > 0) {
            $columnNumber--;
            $letter = chr(65 + ($columnNumber % 26)) . $letter;
            $columnNumber = intval($columnNumber / 26);
        }
        return $letter;
    }

    // Helper method untuk menghitung lebar kolom
    private function calculateColumnWidths($headers, $data)
    {
        $totalWidth = 277; // A4 landscape width minus margins
        $numColumns = count($headers);
        $baseWidth = $totalWidth / $numColumns;
        
        $widths = [];
        foreach ($headers as $i => $header) {
            // Adjust width based on content
            $maxLength = strlen($header);
            foreach ($data as $row) {
                $value = $row[array_keys($headers)[$i]] ?? '';
                $maxLength = max($maxLength, strlen($value));
            }
            
            // Calculate proportional width
            $width = min(max($baseWidth * 0.8, $maxLength * 2), $baseWidth * 1.5);
            $widths[] = $width;
        }
        
        return $widths;
    }

    // Export data siswa
    public function exportSiswa($data, $filename = 'data_siswa.xlsx')
    {
        $headers = [
            'No',
            'NIS',
            'Nama',
            'Tanggal Lahir',
            'Kelas',
            'Jurusan',
            'Alamat',
            'No. HP'
        ];
        
        $title = 'DATA SISWA SMK BHAKTI MULYA BNS';
        $subtitle = 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1);
        
        return $this->exportExcel($data, $headers, $title, $filename, ['subtitle' => $subtitle]);
    }

    // Export data guru
    public function exportGuru($data, $filename = 'data_guru.xlsx')
    {
        $headers = [
            'No',
            'Nama',
            'Tanggal Lahir',
            'Mata Pelajaran',
            'Alamat',
            'No. HP'
        ];
        
        $title = 'DATA GURU SMK BHAKTI MULYA BNS';
        $subtitle = 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1);
        
        return $this->exportExcel($data, $headers, $title, $filename, ['subtitle' => $subtitle]);
    }

    // Export jadwal pelajaran
    public function exportJadwal($data, $filename = 'jadwal_pelajaran.xlsx')
    {
        $headers = [
            'No',
            'Hari',
            'Jam',
            'Kelas',
            'Mata Pelajaran',
            'Guru',
            'Ruangan'
        ];
        
        $title = 'JADWAL PELAJARAN SMK BHAKTI MULYA BNS';
        $subtitle = 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1);
        
        return $this->exportExcel($data, $headers, $title, $filename, ['subtitle' => $subtitle]);
    }

    // Export absensi
    public function exportAbsensi($data, $filename = 'rekap_absensi.xlsx')
    {
        $headers = [
            'No',
            'NIS',
            'Nama',
            'Kelas',
            'Tanggal',
            'Status',
            'Keterangan'
        ];
        
        $title = 'REKAP ABSENSI SISWA SMK BHAKTI MULYA BNS';
        $subtitle = 'Periode: ' . date('d/m/Y');
        
        return $this->exportExcel($data, $headers, $title, $filename, ['subtitle' => $subtitle]);
    }

    // Export nilai
    public function exportNilai($data, $filename = 'data_nilai.xlsx')
    {
        $headers = [
            'No',
            'NIS',
            'Nama',
            'Kelas',
            'Mata Pelajaran',
            'UTS',
            'UAS',
            'Tugas',
            'Nilai Akhir'
        ];
        
        $title = 'DATA NILAI SISWA SMK BHAKTI MULYA BNS';
        $subtitle = 'Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1);
        
        return $this->exportExcel($data, $headers, $title, $filename, ['subtitle' => $subtitle]);
    }
} 