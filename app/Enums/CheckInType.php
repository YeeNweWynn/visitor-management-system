<?php

namespace App\Enums;

enum CheckInType
{
    case WALK_IN;
    case VEHICLE;

    public function Type(): string
    {
        return match($this) 
        {
            CheckInType::WALK_IN => 'walk_in',   
            CheckInType::VEHICLE => 'vehicle',   
        };
    }
}