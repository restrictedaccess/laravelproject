<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class AssessmentSecondSentence extends Model
{
    protected $table = 'rrs_assessment_2nd_sentence';
    protected $fillable = array(
        'group_id',
        'category_id',
        'gif_name',
        'second_advise',
        'reason',
        'tips',
        'is_active'
    );
}
