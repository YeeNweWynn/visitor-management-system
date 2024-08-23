<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;


class CheckIn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'visitor_id',
        'checked_in_at',
        'checked_out_at',
        'type',
        'vehicle_number',
        'purpose_of_visit',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
            'checked_out_at' => 'datetime',
        ];
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithVisitorEmail(Builder $query, ?string $email): void 
    {
      if ($email) {
            $query->with(['visitor' => function($q) use($email){
                $q->where('email', $email);
            }]);
        }
    }

    public function scopeWithVisitorPhone(Builder $query, ?string $phone): void 
    {
        if ($phone) {
            $query->with(['visitor' => function($q) use($phone){
                $q->where('phone_number', $phone);
            }]);
        }
    }

    public function scopeWithCheckedIn(Builder $query, ?string $checkedInAt, ?string $checkedOutAt, bool $isActiveOnly = false): void 
    {
        match (true) {
            is_null($checkedInAt) && !is_null($checkedOutAt) => $query->whereDate('checked_out_at', $checkedOutAt),
            !is_null($checkedInAt) && is_null($checkedOutAt) && $isActiveOnly => $query->whereDate('checked_in_at', $checkedInAt)->whereNull('checked_out_at'),
            !is_null($checkedInAt) && is_null($checkedOutAt) && !$isActiveOnly => $query->whereDate('checked_in_at', $checkedInAt),
            !is_null($checkedInAt) && !is_null($checkedOutAt) => $query->whereDate('checked_in_at', $checkedInAt)->whereDate('checked_out_at', $checkedOutAt),
            true => $query,
        };
    }
    
    public function scopeWithType(Builder $query, ?string $type): void 
    {
        if ($type) {
            $query->where('type', $type);
        }
    }

    public function scopeWithVehicleNumber(Builder $query, ?string $vehicleNumber): void 
    {
        if ($vehicleNumber) {
            $query->where('vehicle_number', $vehicleNumber);
        }
    }
}
