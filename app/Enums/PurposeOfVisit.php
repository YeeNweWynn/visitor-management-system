<?php

namespace App\Enums;

enum PurposeOfVisit
{
    case VISITOR;
    case MEETING;
    case JOB_INTERVIEW;
    case DELIVERY;

    public function Type(): string
    {
        return match($this) 
        {
            PurposeOfVisit::VISITOR => 'visitor',  
            PurposeOfVisit::MEETING => 'meeting',   
            PurposeOfVisit::JOB_INTERVIEW => 'job_interview',   
            PurposeOfVisit::DELIVERY => 'delivery',   
        };
    }
}