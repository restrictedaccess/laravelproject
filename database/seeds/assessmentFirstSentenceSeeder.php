<?php

use Illuminate\Database\Seeder;
use App\Eloquent\AssessmentFirstSentence;

class assessmentFirstSentenceSeeder extends Seeder
{
    protected $assessmentFirstSentence;

    public function __construct(AssessmentFirstSentence $assessmentFirstSentence)
    {
        $this->assessmentFirstSentence = $assessmentFirstSentence;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rrs_assessment_1st_sentence')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            '1' => array(
                'evaluation_id' => '10',
                'evaluation_str' => 'Excellent',
                'first_advise' => '<b>Keep it up!</b> Continue',
                'gif_name' => 'excellent',
                'is_active' => '1',
            ),
            '2' => array(
                'evaluation_id' => '20',
                'evaluation_str' => 'Good',
                'first_advise' => '<b>You\'re doing great!</b> Now try',
                'gif_name' => 'good',
                'is_active' => '1',
            ),
            '3' => array(
                'evaluation_id' => '30',
                'evaluation_str' => 'Average',
                'first_advise' => '<b>You\'re on the right track.</b> Try',
                'gif_name' => 'average',
                'is_active' => '1',
            ),
            '4' => array(
                'evaluation_id' => '40',
                'evaluation_str' => 'Fair',
                'first_advise' => '<b>You can do better.</b> Try',
                'gif_name' => 'fair',
                'is_active' => '1',
            ),
            '5' => array(
                'evaluation_id' => '50',
                'evaluation_str' => 'Poor',
                'first_advise' => 'For your health, it\'s best to be',
                'gif_name' => 'poor',
                'is_active' => '1',
            ),
        );
        $this->assessmentFirstSentence->insert($data);
    }
}
