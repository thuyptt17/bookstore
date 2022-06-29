<?php

namespace App\Exports;

use App\Models\ReportStock;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $month;
    protected $year;
    function __construct($month,$year) {
            $this->month = $month;
            $this->year = $year;
    }

    public function collection()
    {
        return ReportStock::all();
    }
    public function headings(): array
    {
        return [
            '#',
            'Mã sách',
            'Tên sách',
            'Năm phát hành',
            'Tồn đầu',
            'Phát sinh',
            'Tồn cuối'
        ];
    }
}
