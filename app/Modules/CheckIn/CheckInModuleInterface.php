<?php

namespace App\Modules\CheckIn;

use App\Models\User;
use App\Models\CheckIn;
use App\Models\Visitor;
use Illuminate\Pagination\LengthAwarePaginator;

interface CheckInModuleInterface
{
    public function search(array $data): ?LengthAwarePaginator;
    public function findActiveCheckInOf(Visitor $visitor): ?CheckIn;
    public function checkIn(User $user, Visitor $visitor,  array $data): ?CheckIn;
    public function checkOut(CheckIn $checkIn): bool;
}