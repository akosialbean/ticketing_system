<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportReportController extends Controller implements FromCollection, WithHeadings
{
    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    public function collection()
    {
        return collect($this->reports);
    }

    public function headings(): array
    {
        return [
            'Ticket ID',
            'Category Code',
            'Title',
            'Description',
            'Created By',
            'Department Code',
            'Created At',
            'Resolved Date',
            'Closed Date',
            'Resolver',
            'Status',
            'TAT Acknowledge to Resolve',
            'TAT Resolve to Close',
        ];
    }
}
