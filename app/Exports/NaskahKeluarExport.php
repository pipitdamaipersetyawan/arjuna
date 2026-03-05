<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class NaskahKeluarExport implements
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

    /*
    =========================
    HEADER KOLOM
    =========================
    */

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nomor Surat',
            'Pengirim',
            'Tujuan',
            'Jenis',
            'Sifat',
            'Klasifikasi',
            'Hal'
        ];
    }

    /*
    =========================
    DATA BARIS
    =========================
    */

    public function map($row): array
    {

        $tujuan = '-';

        if ($row->tujuan && $row->tujuan->count()) {

            $tujuan = $row->tujuan
                ->pluck('nama')
                ->implode(', ');
        }

        if ($row->tujuan_manual) {

            $tujuan = $tujuan === '-'
                ? $row->tujuan_manual
                : $tujuan . ', ' . $row->tujuan_manual;
        }

        return [

            ++$this->no,

            Carbon::parse($row->tanggal_surat)
                ->translatedFormat('d F Y'),

            $row->nomor_naskah ?? '-',

            $row->pengirim ?? '-',

            $tujuan,

            $row->jenis_naskah ?? '-',

            $row->sifat_naskah ?? '-',

            $row->klasifikasi_kode ?? '-',

            $row->hal ?? '-'

        ];
    }

    /*
    =========================
    STYLE EXCEL
    =========================
    */

    public function styles(Worksheet $sheet)
    {

        $lastRow = $sheet->getHighestRow();

        /*
        =========================
        TAMBAH SPACE UNTUK KOP
        =========================
        */

        $sheet->insertNewRowBefore(1, 8);

        /*
        =========================
        LOGO
        =========================
        */

        if (file_exists(public_path('logo.png'))) {

            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setPath(public_path('logo.png'));
            $drawing->setHeight(70);
            $drawing->setCoordinates('A1');
            $drawing->setWorksheet($sheet);
        }

        /*
        =========================
        KOP INSTANSI
        =========================
        */

        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'PEMERINTAH KOTA SEMARANG');

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'BAGIAN ADMINISTRASI PEMBANGUNAN');

        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', 'Gedung Moch Ikhsan Lt 5');

        $sheet->mergeCells('A5:I5');
        $sheet->setCellValue('A5', 'LAPORAN NASKAH KELUAR');

        $sheet->mergeCells('A6:I6');
        $sheet->setCellValue(
            'A6',
            'Dicetak pada: ' . now()->translatedFormat('d F Y H:i')
        );

        $sheet->getStyle('A1:I6')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:I6')
            ->getFont()
            ->setBold(true);

        /*
        =========================
        GARIS PEMBATAS KOP
        =========================
        */

        $sheet->getStyle('A4:I4')
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(Border::BORDER_MEDIUM);

        /*
        =========================
        HEADER TABLE
        =========================
        */

        $headerRow = 9;

        $sheet->getStyle("A{$headerRow}:I{$headerRow}")
            ->getFont()
            ->setBold(true);

        $sheet->getStyle("A{$headerRow}:I{$headerRow}")
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('BFBFBF');

        $sheet->getStyle("A{$headerRow}:I{$headerRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        /*
        =========================
        BORDER TABLE
        =========================
        */

        $sheet->getStyle("A{$headerRow}:I" . ($lastRow + 8))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        /*
        =========================
        NOMOR RATA TENGAH
        =========================
        */

        $sheet->getStyle("A" . ($headerRow + 1) . ":A" . ($lastRow + 8))
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        /*
        =========================
        TOTAL DATA
        =========================
        */

        $totalRow = $lastRow + 10;

        $sheet->mergeCells("A{$totalRow}:I{$totalRow}");

        $sheet->setCellValue(
            "A{$totalRow}",
            "Total Naskah Keluar: " . $this->no
        );

        $sheet->getStyle("A{$totalRow}")
            ->getFont()
            ->setBold(true);

        return [];
    }

}
