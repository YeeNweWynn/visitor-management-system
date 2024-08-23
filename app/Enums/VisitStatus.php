<?php

namespace App\Enums;

enum VisitStatus
{
    case ALL;
    case ACTIVE;

    public function Type(): string
    {
        return match($this) 
        {
            VisitStatus::ALL => 'all',   
            VisitStatus::ACTIVE => 'active',   
        };
    }
}