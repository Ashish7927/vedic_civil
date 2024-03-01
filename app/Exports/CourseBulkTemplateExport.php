<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Modules\CourseSetting\Entities\Course;
use Maatwebsite\Excel\Events\AfterSheet;

class CourseBulkTemplateExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings():array{
        return[
            'title',
            'course_type',
            'trainer',
            'requirements',
            'course_description',
            'meta_description',
            'outcomes',
            'category',
            'category_ids',
            'level',
            'language',
            'duration',
            'complete_order',
            'is_free',
            'price',
            'is_discount',
            'discount_price',
            'discount_start_date',
            'discount_end_date',
            'show_overview_media',
            'mode_of_delivery',
            'course_meta_keyword',
            'chapter_name',
            'lesson_name',
            'lesson_description',
            'lesson_host',
            'lesson_duration',
            'lesson_is_lock',
            'lesson_url',
            'is_subscription',
            'thumbnail_image',
        ];
    }

    public function map($row): array{

        return [
            'Test1234',
            '4',
            'asia corporate',
            'test course description requirements',
            'Course Description',
            'course meta description',
            'course test outcomes',
            '1',
            '1',
            '1',
            '19',
            '44',
            '0',
            '0',
            '120',
            '1',
            '20',
            '05-10-2022',
            '26-10-2022',
            '0',
            '1',
            'course meta keyword',
            'Chapter Name,Chapter Name 1,Chapter Name2',
            'lesson name;lesson name copy,lesson name 1;lesson name 1 copy,lesson name 2;lesson name 2 copy',
            'lesson description;lesson description copy,lesson description 1;lesson description 1 copy,lesson description 2;lesson description 2 copy',
            'Vimeo;Vimeo,Vimeo;Vimeo,Vimeo;Vimeo',
            '40;45,50;55,60;65',
            '1;1,1;1,1;1',
            '',
            '0',
            '',
        ];
    }

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
        $query = $query->with('enrollUsers','enrolls','enrolls.user', 'lessons')->where('type', 1)->limit(1)->get();
        return $query;
    }


}
