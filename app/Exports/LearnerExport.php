<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LearnerExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct($name, $email, $phone, $start_date, $end_date, $country, $citizenship, $identification_number, $job_designation, $sector, $not_working, $business_nature, $business_nature_other, $zip, $gender, $dob, $race, $employment_status, $highest_academic, $current_residing) {
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
            $this->start_date = $start_date;
            $this->end_date = $end_date;
            $this->country = $country;
            $this->citizenship = $citizenship;
            $this->identification_number = $identification_number;
            $this->job_designation = $job_designation;
            $this->sector = $sector;
            $this->not_working = $not_working;
            $this->business_nature = $business_nature;
            $this->business_nature_other = $business_nature_other;
            $this->zip = $zip;
            $this->gender = $gender;
            $this->dob = $dob;
            $this->race = $race;
            $this->employment_status = $employment_status;
            $this->highest_academic = $highest_academic;
            $this->current_residing = $current_residing;
    }

    public function headings():array{
        return[
            'Name',
            'Email',
            'Phone',
            'Courses',
            'Created At',
            'Highest Academic',
            'Current Residing',
        ];
    }

    public function map($row): array{
        $employment_status = $row->employment_status;
        if($employment_status=='Working'){
            $employment_status_2 = 'Job Designation -'.$row->job_designation; 
        }elseif($employment_status=='Not Working'){
            $employment_status_2 = 'Not Working Status -'.$row->not_working; 
        }else{
            $employment_status_2 = 'Business Nature -'.$row->business_nature .' , Other:- '.$row->business_nature_other; 
        }
        $employment_status_final = $employment_status.' :- '.$employment_status_2;

        $country_name = '';
        if(isset($row->userCountry) && !empty($row->userCountry)){
            $country_name = $row->userCountry->name;
        }
        

        $fields = [
            $row->name,
            $row->email,
            $row->phone,
            $row->enrollCourse->count(),
            showDate($row->created_at),
            $row->highest_academic,
            $row->current_residing,
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
        $user = User::query();
        $user->where('role_id', 3);
        if($this->name != ''){
            $user->where('name', 'like', '%' . $this->name . '%');
        }
        if($this->email != ''){
            $user->where('email', 'like', '%' . $this->email . '%');
        }
        if($this->phone != ''){
            $user->where('phone', 'like', '%' . $this->phone . '%');
        }
        // if($this->created_at != ''){
        //     $user->where('created_at', 'like', '%' . $this->created_at . '%');
        // }
        if($this->start_date != ''){
            $user->whereDate('created_at', '>=', $this->start_date);
        }
        if($this->end_date != ''){
            $user->whereDate('created_at', '<=', $this->end_date);
        }
        if($this->highest_academic != ''){
            $user->where('highest_academic',$this->highest_academic);
        }
        if($this->current_residing != ''){
            $user->where('current_residing',$this->current_residing);
        }
        $user = $user->get();

        return $user;
    }
}
