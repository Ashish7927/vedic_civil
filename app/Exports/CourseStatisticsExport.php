<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Modules\CourseSetting\Entities\Course;
use Maatwebsite\Excel\Events\AfterSheet;

class CourseStatisticsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings():array{
        return[
            'Course',
            'Enrolled',
            'Pass',
            'Fail'
        ];
    }

    public function map($row): array{

        $pass = "NA";
        $is_quiz = $row->courseIsQuizOrNot();
        if($is_quiz)
            $pass = $row->totalPassFailed(1, $row->id);

        $fail = "NA";
        $is_quiz = $row->courseIsQuizOrNot();
        if($is_quiz)
            $fail = $row->totalPassFailed(0, $row->id);

        $fields = [
            $row->title,
            $row->enrollUsers->count(),
            $pass,
            $fail
        ];
        return $fields;
    }

    // public function styles(Worksheet $sheet)
    // {
    //     return [
    //        1    => ['font' => ['bold' => true]],
    //     ];
    // }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getStyle('A1:C1')
                                ->getFont()
                                ->setBold(true);
   
            },
        ];
    }

    public function collection()
    {
        $query = Course::query();
        $query = $query->with('enrollUsers','enrolls','enrolls.user', 'lessons')->where('type', 1)->get();
        return $query;
    }
}
