<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Category;
use Illuminate\Database\Eloquent\Builder;


class QuestionBank extends Model
{


    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('questiondata', function (Builder $builder) {
            $builder->where('corporate_id', null);
        });
    }

    public function questionGroup()
    {
        return $this->belongsTo('Modules\Quiz\Entities\QuestionGroup', 'q_group_id')->withDefault();
    }

    public function questionLevel()
    {
        return $this->belongsTo('Modules\Quiz\Entities\QuestionLevel', 'question_level_id')->withDefault();
    }

    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    public function subCategory()
    {

        return $this->belongsTo(Category::class, 'sub_category_id', 'id')->withDefault();
    }

    public function questionMu()
    {
        return $this->hasMany('Modules\Quiz\Entities\QuestionBankMuOption', 'question_bank_id', 'id')->inRandomOrder();
    }

    public function questionMuInSerial()
    {
        return $this->hasMany('Modules\Quiz\Entities\QuestionBankMuOption', 'question_bank_id', 'id');
    }
}
