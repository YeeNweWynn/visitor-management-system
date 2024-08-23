<?php

namespace App\Modules\Visitor;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Pagination\LengthAwarePaginator;

interface VisitorModuleInterface
{   
    public function search(array $data): ?LengthAwarePaginator;
    public function find(int $id): ?Visitor;
    public function create(User $createdBy, array $data): ?Visitor;
    public function update(Visitor $visitor, array $data): bool;
    public function delete(int $id): bool;
}