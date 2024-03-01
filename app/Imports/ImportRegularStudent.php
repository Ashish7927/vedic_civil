<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportRegularStudent implements ToModel, WithStartRow, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
       return [
            'email' => 'required|unique:users,email',
            'phone_number' =>'unique:users,phone'
        ];

    }

    public function model(array $row)
    {
        $name = $row['first_name'].' '.$row['last_name'];
        $email = $row['email'];
        $created_at = date('Y-m-d h:m:s',$row['created']);
        $new_student = new User([
            'name' => $name,
            'role_id' => '3',
            'email' => strtolower($email),
            'email_verified_at' => now(),
            'is_active' => '1',
            'email_verify' => '1',
            'created_at' => $created_at,
            'updated_at' => now(),
            'notification_preference' => 'mail',
            'phone' => $row['phone_number'],
            'identification_number' => $row['nric_number'],
            'gender' => $row['gender'],
            'added_by' => '1',
            'teach_via' => '1',
            'citizenship' => 'Malaysian',
            'race' => 'Malay',
            'employment_status' => $row['employment_status'],
            'not_working' => $row['not_working_status'],
            'job_designation' => $row['working_job_designation'],
            'sector' => $row['working_industry_sector'],
            'business_nature' => $row['self_employed_activity'],
            'business_nature_other' => $row['self_employed_other_activity'],
            'highest_academic' => $row['qualification'],
            'current_residing' => $row['current_location'],
            'country_code' => '+60',
            'referral' => generateUniqueId(),
            'language_id' => Settings('language_id') ?? '19',
            'language_name' => Settings('language_name') ?? 'English',
            'language_code' => Settings('language_code') ?? 'en',
            'language_rtl' => Settings('language_rtl') ?? '0',
            'country' => Settings('country_id'),
            'import' => '1'
        ]);

        return $new_student;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
