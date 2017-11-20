<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PegaraConstant extends Facade {

    const SCO_BMI_CATEGORY_ID = 101;
    const SCO_PAF_CATEGORY_ID = 102;
    const SCO_MTL_CATEGORY_ID = 103;
    const SCO_SAF_CATEGORY_ID = 104;
    const SCO_DIET_FISH_CATEGORY_ID = 201;
    const SCO_DIET_VEG_CATEGORY_ID = 202;
    const SCO_DIET_MEAT_CATEGORY_ID = 203;
    const SCO_DIET_FRUIT_CATEGORY_ID = 204;
    const SCO_DIET_CHICKEN_CATEGORY_ID = 205;
    const SCO_DIET_NUTS_CATEGORY_ID = 206;
    const SCO_DIET_WHOLE_GRAIN_CATEGORY_ID = 207;
    const SCO_DIET_SUGAR_CATEGORY_ID = 208;
    const SCO_DIET_ARTIFICIALS_CATEGORY_ID = 209;
    const SCO_DIET_OLIVE_CATEGORY_ID = 210;
    const SCO_SMOKE_NOW_CATEGORY_ID = 301;
    const SCO_DAF_CATEGORY_ID = 302;
    const SCO_SF_CATEGORY_ID = 303;
    const SCO_GOOD_SLEEP_CATEGORY_ID = 304;
    const SCO_ATRIAL_CONTROL_CATEGORY_ID = 401;
    const SCO_CAD_CONTROL_CATEGORY_ID = 402;
    const SCO_DEPRESSION_CONTROL_CATEGORY_ID = 403;
    const SCO_DIABETES_CONTROL_CATEGORY_ID = 404;
    const SCO_HEART_ATTACK_CONTROL_CATEGORY_ID = 405;
    const SCO_HYPERTENSION_CONTROL_CATEGORY_ID = 406;
    const SCO_HYPERLIPIDEMIA_CONTROL_CATEGORY_ID = 407;
    const SCO_APNEA_CONTROL_CATEGORY_ID = 408;
    const SCO_STROKE_CONTROL_CATEGORY_ID = 409;
    const SCO_ASF_CATEGORY_ID = 501;
    const SCO_EDU_CATEGORY_ID = 502;
    const SCO_SMOKE_EVER_CATEGORY_ID = 503;
    const SURVEY_TOKEN_LENGTH = 20 ;
    const SURVEY_MAIL_SUBJECT ="Thank you from brainsalvation";
    //top
    const TOP_PAGE_TITLE = "brainsalvation - lifestyle changes to reduce Alzheimer's risk";
    const TOP_PAGE_DESCRIPTION = "Measure the effects your lifestyle has on your brain health with our innovative system. We'll give you lifestyle tips to help you reduce your risk of dementia and Alzheimer's disease.";
    //reference
    const REFERENCE_PAGE_TITLE = "brainsalvation - reference materials";
    const REFERENCE_PAGE_DESCRIPTION = "The Risk Reduction Score incorporates findings from recent, peer-reviewed medical research, and was developed under the supervision of Medical Care Corporation,  which specializes in researching cognitive impairment diseases like Alzheimer's.";
    //terms of service
    const TERMS_PAGE_TITLE = "brainsalvation - terms of service";
    const TERMS_PAGE_DESCRIPTION = "";
    //privacy policy
    const PRIVACY_PAGE_TITLE = "brainsalvation - privacy policy";
    const PRIVACY_PAGE_DESCRIPTION = "";
    
    //Risk Reduction Score
    const RRS_PAGE_TITLE = "brainsalvation - Risk Reduction Score";
    const RRS_PAGE_DESCRIPTION = "";

    //survey
    const SURVEY_PAGE_TITLE = "brainsalvation - Risk Reduction Score";
    const SURVEY_PAGE_DESCRIPTION = "";

    //error
    const ERROR_PAGE_TITLE = "brainsalvation - Error Page";
    const ERROR_PAGE_DESCRIPTION = "";
    
    const HAS_DISEASE_HEADER = "Find lifestyle tips below. Please remember they are only suggestions, not a medical diagnosis. Consult a doctor about medical conditions. ";
    const NO_DISEASE_HEADER = "Brain performance decreases over time. Below, you will learn what you are doing well to maintain brain health, and places where you can improve.";
    const HAS_DISEASE_FOOTER = "Notice: For your better health management, we recommend that you consult your doctor about disease risk and treatment. We do not offer medical advice or diagnoses or engage in the practice of medicine. ";
    const NO_DISEASE_FOOTER = "Notice: For your better health management, we recommend that you consult your doctor about disease risk and treatment. We do not offer medical advice or diagnoses or engage in the practice of medicine.
	 ";
    


    protected static function getFacadeAccessor() {
        return 'PegaraConstant';
    }

}
