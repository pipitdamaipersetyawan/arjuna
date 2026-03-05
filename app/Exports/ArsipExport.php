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

class ArsipExport implements
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
    =====================
    HEADER KOLOM
    =====================
    */
    public function headings(): array
    {
        return [
            'No',
            'Jenis',
            'Tanggal',
            'Nomor Surat',
            'Pengirim',
            'Isi'
        ];
    }

    /*
    =====================
    DATA ROW
    =====================
    */
    public function map($row): array
    {
        return [

            ++$this->no,

            $row->jenis ?? '-',

            Carbon::parse($row->tanggal_surat)
                ->translatedFormat('d F Y'),

            $row->nomor_surat ?? '-',

            $row->pengirim ?? '-',

            $row->isi ?? '-'
        ];
    }

    /*
    =====================
    STYLE EXCEL
    =====================
    */
    public function styles(Worksheet $sheet)
    {

        $lastRow = $sheet->getHighestRow();

        $sheet->insertNewRowBefore(1, 8);

        /*
        =====================
        LOGO
        =====================
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
        =====================
        KOP INSTANSI
        =====================
        */

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'PEMERINTAH DAERAH');

        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'BAGIAN ADMINISTRASI PEMBANGUNAN');

        $sheet->mergeCells('A3:F3');
        $sheet->setCellValue('A3', 'Gd. Moch Ikhsan Lt 5');

        $sheet->mergeCells('A5:F5');
        $sheet->setCellValue('A5', 'LAPORAN ARSIP INAKTIF');

        $sheet->mergeCells('A6:F6');
        $sheet->setCellValue(
            'A6',
            'Dicetak pada: '.now()->translatedFormat('d F Y')
        );

        $sheet->getStyle('A1:F6')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:A6')
            ->getFont()
            ->setBold(true);

        /*
        =====================
        GARIS KOP
        =====================
        */

        $sheet->getStyle('A4:F4')
            ->getBorders()
            ->getBottom()
            ->setBorderStyle(Border::BORDER_MEDIUM);

        /*
        =====================
        HEADER TABLE
        =====================
        */

        $headerRow = 9;

        $sheet->getStyle("A{$headerRow}:F{$headerRow}")
            ->getFont()->setBold(true);

        $sheet->getStyle("A{$headerRow}:F{$headerRow}")
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('BFBFBF');

        $sheet->getStyle("A{$headerRow}:F{$headerRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        /*
        =====================
        BORDER TABLE
        =====================
        */

        $sheet->getStyle("A{$headerRow}:F".($lastRow+8))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        /*
        =====================
        NOMOR CENTER
        =====================
        */

        $sheet->getStyle("A".($headerRow+1).":A".($lastRow+8))
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        /*
        =====================
        TOTAL DATA
        =====================
        */

        $totalRow = $lastRow + 10;

        $sheet->mergeCells("A{$totalRow}:F{$totalRow}");
        $sheet->setCellValue(
            "A{$totalRow}",
            "Total Arsip: ".$this->no
        );

        $sheet->getStyle("A{$totalRow}")
            ->getFont()
            ->setBold(true);

        return [];
    }

}
