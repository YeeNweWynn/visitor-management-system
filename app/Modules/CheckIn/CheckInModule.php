<?php

namespace App\Modules\CheckIn;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CheckIn;
use App\Models\Visitor;
use App\Modules\CheckIn\CheckInModuleInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CheckInModule implements CheckInModuleInterface
{
    public function __construct(
        protected CheckIn $checkIn,
    ) {}

    public function search(array $data): ?LengthAwarePaginator
    {
        $limit = $data['limit'] ?? 5;
        $email = $data['email'] ?? null;
        $phone = $data['phone_number'] ?? null;
        $checkedInAt = $data['checked_in_at'] ?? null;
        $checkedOutAt = $data['checked_out_at'] ?? null;
        $type = $data['type'] ?? null;
        $vehicleNumber = $data['vehicle_number'] ?? null;
        $isActiveOnly = ($data['status'] ?? 'all') === 'active';

        $query = $this->checkIn
                    ->with('user')
                    ->with('visitor')
                    ->withVisitorEmail($email)
                    ->withVisitorPhone($phone)
                    ->withCheckedIn($checkedInAt, $checkedOutAt, $isActiveOnly)
                    ->withType($type)
                    ->withVehicleNumber($vehicleNumber);
        
        //dd($query->get());
        return $query->orderby('checked_in_at', 'desc')->paginate($limit);
    }

    public function findActiveCheckInOf(Visitor $visitor): ?CheckIn
    {
        return $this->checkIn
            ->where('visitor_id', $visitor->id)
            ->whereNull('checked_out_at')
            ->first();
    }

    public function checkIn(User $user, Visitor $visitor, array $data): ?CheckIn
    {
        //dd($data);
        $checkIn = $this->checkIn->create([
            'user_id' => $user->id,
            'visitor_id' => $visitor->id,
            'checked_in_at' => now(),
            'type' => $data['type'],
            'vehicle_number' => $data['vehicle_number'],
            'purpose_of_visit' => $data['purpose_of_visit'],
        ]);

        //dump($checkIn);
        return $checkIn;
    }


    public function checkOut(CheckIn $checkIn): bool
    {
        $checkIn->checked_out_at = now();
        return $checkIn->save();
    }

}
