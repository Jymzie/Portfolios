<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;


class ExportSummary extends StringValueBinder implements FromCollection, WithHeadings, ShouldAutoSize,
//  WithColumnWidths, 
WithStyles, 
WithCustomValueBinder
{

    protected $data;

    // Constructor to receive the data
    public function __construct($data)
    {
        $this->data = $data;
       
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    //ANCHOR HEADER
    public function headings(): array
    {
        return [
            
            'Indication' => 'Indication',
            'Request' => 'REQUEST',
            'ConstructionCode' => 'CDNO',
            'NameCode' => 'NameCode',
            'WindowType' => 'WindowType',
            'Product' => 'MAT_NAME',
            'Exist' => 'Exist',
           
        ];
    }

//     public function map($row): array
// {
//     return [
//         'ProductionScheduledDate' => $row['ProductionScheduledDate'],
//         'ProductionOrder' => $row['ProductionOrder'],
//         'Line' => $row['Line'],
//         'Request' => $row['REQUEST'],
//         'CDNO' => $row['CDNO'],
//         'Product' => $row['MAT_NAME'],
//         'Qty' => $row['MAT_ELE_VALUE'],
//         'WindowType' => 'WindowType',
//         'Exist' => 'Exist',
//         'WallPanel' => 'WallPanel',
//         'Style' => 'Style',
//         'WindowColor' => 'WindowColor',
//         'WindowColor(2F)' => 'WindowColor(2F)',
//         'Alarm' => 'Alarm',
//         'Alarm(2F)' => 'Alarm(2F)',
//         'MOGOL COLOR' => 'MOGOL COLOR',
//         'MOGOL COLOR(2F)' => 'MOGOL COLOR(2F)',
//         'LR' => 'LR',
//         'LR(2F)' => 'LR(2F)',
//         'GLASS' => 'GLASS',
//         'GLASS(2F)' => 'GLASS(2F)',
//         'FILM' => 'FILM',
//         'FILM(2F)' => 'FILM(2F)',
//         'LATTICE' => 'LATTICE',
//         'LATTICE(2F)' => 'LATTICE(2F)',
//         'SCREEN' => 'SCREEN',
//         'SCREEN(2F)' => 'SCREEN(2F)',
//         'BANKIN/ROOF TILE' => 'BANKIN/ROOF TILE'
//     ];
// }

    // public function bindValue(Cell $cell, $value)
    // {
       
    //         $cell->setValueExplicit($value, DataType::TYPE_STRING);

    //         return true;
       

    //     // else return default behavior
    //     return parent::bindValue($cell, $value);
    // }

    //ANCHOR COLUMN WIDTH
    // public function columnWidths(): array
    // {
    //     return [
    //         'A' => 15,  
    //         'B' => 20,  
    //         'C' => 15,  
    //         'D' => 25,
    //         'E' => 10,   
    //         'F' => 20,   
    //         'G' => 10,      
    //         'H' => 20,  
    //     ];
    // }

    //ANCHOR COLUMN HEIGHT
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function(AfterSheet $event) {
    //             // Set height for specific rows
    //             $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(40);
                
    //             // Or set heights for multiple rows
    //             $event->sheet->getDelegate()->getRowDimension('3')->setRowHeight(25);
    //             $event->sheet->getDelegate()->getRowDimension('4')->setRowHeight(30);
    //         },
    //     ];
    // }

    //ANCHOR STYLES
    public function styles(Worksheet $sheet)
    {
        // $count = DB::connection('Sample')->select("SELECT COUNT(UserID) AS Total FROM users")[0]->Total+1;
        return [
          
            
            // Style specific columns
            'A:G' => ['alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                
            ]],
       

            // Style header row
            1 =>  ['alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            
            ]],

            // Style specific columns
            // 'A2:A'.$count => ['font' => [
            //     'color' => ['argb' => 'FF0000FF'] // Black text
            // ]],
            
            // Style specific cells
            // 'A1:G'.$count => ['fill' => [
            //     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            //     'startColor' => ['argb' => 'FFD9D9D9']
            // ],
            // 'borders' => [
            //     'allBorders' => [
            //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //         'color' => ['argb' => 'FF000000']
            // ]]]
        ];
    }

    //ANCHOR DATA
    public function collection()
    {
        return collect($this->data)->map(function ($row){
            return [
                'Indication' => '-',
                'REQUEST' => $row['REQUEST'],
                'CDNO' => $row['CDNO'],  
                'NameCode' => $row['NameCode'],
                'MAT_NAME' => $row['MAT_NAME'],
                'WINDOWTYPE' => $row['WINDOWTYPE'],
                'Exist' => $row['Exist'] ,
      
            ];
        });
    }
}
