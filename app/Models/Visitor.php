<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;


class Visitor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'address',
        'postal_code',
    ];

    public function checkIns(): HasMany
    {
        return $this->hasMany(CheckIn::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithActiveCheckIn(Builder $builder): void
    {
        $builder->with(['checkIns' => function($q) {
            $q->whereNull('checked_out_at')->whereDate('checked_in_at', now());
        }]);
    }
}
