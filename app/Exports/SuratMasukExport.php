<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class SuratMasukExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    WithStyles,
    ShouldAutoSize
{
    protected $data;
    protected $no = 0;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Input',
            'Surat Dari',
            'Tanggal Surat',
            'Nomor Surat',
            'Isi Informasi',
            'Klasifikasi',
            'Keterangan'
        ];
    }

    public function map($row): array
{
    return [
        ++$this->no,

        \Carbon\Carbon::parse($row->tanggal)
            ->translatedFormat('j F Y'),

        $row->surat_dari,

        \Carbon\Carbon::parse($row->tanggal_surat)
            ->translatedFormat('j F Y'),

        $row->nomor_surat,
        $row->isi_informasi,
        $row->klasifikasi_kode,
        $row->keterangan ?? '-'
    ];
}

    public function styles(Worksheet $sheet)
{
    $lastRow = $sheet->getHighestRow();

    /*
    ==========================
    INSERT BARIS UNTUK KOP
    ==========================
    */
    $sheet->insertNewRowBefore(1, 8);

    /*
    ==========================
    LOGO KIRI ATAS
    ==========================
    */
    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setName('Logo');
    $drawing->setPath(public_path('logo.png')); // pastikan file ada
    $drawing->setHeight(70);
    $drawing->setCoordinates('A1');
    $drawing->setWorksheet($sheet);

    /*
    ==========================
    KOP INSTANSI
    ==========================
    */

    $sheet->mergeCells('A1:H1');
    $sheet->setCellValue('A1', 'PEMERINTAH DAERAH');

    $sheet->mergeCells('A2:H2');
    $sheet->setCellValue('A2', 'BAGIAN ADMINISTRASI PEMBANGUNAN');

    $sheet->mergeCells('A3:H3');
    $sheet->setCellValue('A3', 'Gd. Moch Ikhsan Lt 5');

    $sheet->mergeCells('A5:H5');
    $sheet->setCellValue('A5', 'LAPORAN SURAT MASUK');

    $sheet->mergeCells('A6:H6');
    $sheet->setCellValue('A6', 'Dicetak pada: '.now()->format('d F Y '));

    $sheet->getStyle('A1:A6')->getFont()->setBold(true);
    $sheet->getStyle('A1:A6')->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Garis tebal bawah kop
    $sheet->getStyle('A4:H4')->getBorders()->getBottom()
    ->setBorderStyle(Border::BORDER_MEDIUM);
    /*
    ==========================
    JARAK ANTARA KOP DAN TABEL
    ==========================
    */
    // Header tabel sekarang ada di baris 9
    $headerRow = 9;

    /*
    ==========================
    HEADER TABEL WARNA JELAS
    ==========================
    */

    $sheet->getStyle("A{$headerRow}:H{$headerRow}")
        ->getFont()->setBold(true);

    $sheet->getStyle("A{$headerRow}:H{$headerRow}")
        ->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('BFBFBF'); // warna abu lebih tegas

    $sheet->getStyle("A{$headerRow}:H{$headerRow}")
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    /*
    ==========================
    BORDER TABEL
    ==========================
    */

    $sheet->getStyle("A{$headerRow}:H".($lastRow+8))
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);

    /*
    ==========================
    NOMOR URUT RATA TENGAH
    ==========================
    */

    $sheet->getStyle("A".($headerRow+1).":A".($lastRow+8))
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    /*
    ==========================
    TOTAL DATA
    ==========================
    */

    $totalRow = $lastRow + 10;

    $sheet->mergeCells("A{$totalRow}:H{$totalRow}");
    $sheet->setCellValue("A{$totalRow}", "Total Surat Masuk: ".$this->no);

    $sheet->getStyle("A{$totalRow}")
        ->getFont()
        ->setBold(true);

    return [];
}
}
