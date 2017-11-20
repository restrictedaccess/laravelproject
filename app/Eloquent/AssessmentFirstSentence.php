<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class AssessmentFirstSentence extends Model
{
    protected $table = 'rrs_assessment_1st_sentence';

    protected $fillable = array(
        'evaluation_id',
        'evaluation_str',
        'first_advise',
        'gif_name',
        'is_active'
    );
}

