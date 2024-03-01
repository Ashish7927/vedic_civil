<?php

namespace App\Exports;

use App\Models\User;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use DB;

class InterestExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct($from_date, $to_date) {
            $this->from_date = $from_date;
            $this->to_date = $to_date;
    }

    public function headings():array{
        return[
            'Full Name',
            'Email Address',
            'Phone',
            'Company Name',
            'Company Registration No',
            'Location',
            'Industry',
            'No of Employees',
            'HRD Corp',
            'Created at',
            'Status'
        ];
    }

    public function map($row): array{
        $status = 'Pending';
       if($row->status==1){
        $status = 'Completed';
       }
        $fields = [
            $row->full_name,
            $row->email_address,
            $row->phone_number,
            $row->company_name,
            $row->company_registration_no,
            $row->location,
            $row->industry,
            $row->no_of_employees,
            $row->hrd_corp,
            $row->created_at,
            $status,
           
        ];
        return $fields;
    }

    public function styles(Worksheet $sheet)
    {
        return [
           1    => ['font' => ['bold' => true]],
        ];
    }

    public function collection()
    {
        $query = DB::table('booked_demo');

        if($this->from_date != ''){
            $query->where('created_at', '>=', $this->from_date);
        }
        if($this->to_date != ''){
            $query->where('created_at', '<=', $this->to_date);
        }
       
        $query->select('booked_demo.*');
        $query = $query->get();

        return $query;
    }
}
