<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;

class QuizTestDetails extends Model
{
    protected $guarded = ['id'];

    public function options()
    {
        return $this->belongsTo(QuestionBankMuOption::class, 'ans_id');
    }
}
