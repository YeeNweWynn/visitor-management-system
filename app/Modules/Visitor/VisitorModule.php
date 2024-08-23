<?php

namespace App\Modules\Visitor;

use App\Models\User;
use App\Models\Visitor;
use App\Modules\CheckIn\CheckInModuleInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class VisitorModule implements VisitorModuleInterface
{
    public function __construct(
        protected Visitor $visitor,
        protected CheckInModuleInterface $checkInModule

    ) {}

    public function search(array $data): ?LengthAwarePaginator 
    {
        $limit = $data['limit'] ?? 5;
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $phone = $data['phone_number'] ?? null;

        $query = $this->visitor
                ->with('user')
                ->withActiveCheckIn();

        if ($name) {
            $query->where('name', 'like', "%$name%");
        }

        if ($email) {
            $query->where('email', $email);
        }

        if ($phone) {
            $query->where('phone_number', $phone);
        }

        return $query->paginate($limit)->withQueryString();
        
    }

    public function find(int $id): ?Visitor 
    {
        return $this->visitor->find($id);
    }

    public function create(User $createdBy, array $data): ?Visitor
    {
        $visitor = $this->visitor->create([
            'user_id' => $createdBy->id,
            'name' =>  $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'postal_code' => $data['postal_code'],
        ]);

        return $visitor;
    }

    public function update(Visitor $visitor, array $data): bool
    {
        $visitor->fill($data);
        return $visitor->save();
    }

    public function delete(int $id): bool
    {
        return $this->visitor->destroy($id);
    }

    public function checkout(Visitor $visitor): bool
    {
        $activeCheckIn = $this->checkInModule->findActiveCheckInOf($visitor);
        if ($activeCheckIn) {
            $this->checkInModule->checkOut($activeCheckIn);
            return true;
        }
        return false;
    }
}
