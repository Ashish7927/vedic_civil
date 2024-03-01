<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Builder;

class QuestionGroup extends Model
{
    protected $fillable = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('questiongroupdata', function (Builder $builder) {
            $builder->where('corporate_id', null);
        });
    }
}
