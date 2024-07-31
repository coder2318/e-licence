<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  int $id
 * @property  int $user_id
 * @property  int $status
 * @property  string $name
 * @property  string $status_text
 * @property  string $reason_rejected
 */
class Application extends Model
{
    use HasFactory, SoftDeletes;

    const NEW = 0; // yangi yaratilganda
    const AT_MODERATOR = 1; // moderatorda
    const AT_COUNCIL = 2; // kengash tekshiruvida
    const AT_MINISTRY = 3; // vazirlik xodimida
    const SUCCESS = 5; // success
    const CANCEL_BY_MODERATOR = 6; // moderator tomonidan cancel qilingan
    const CANCEL_BY_COUNCIL = 7; // kengash tomonidan cancel qilingan
    const CANCEL_BY_MINISTRY = 8; // vazirlik xodimi tomonidan cancel qilingan


    protected $fillable =
        [
            'id',
            'user_id',
            'status',
            'reason_rejected',
            'name',
            'address',
            'tin',
            'phone',
            'bank_requisite',
            'brand_name',
            'mxik',
            'contract_details',
            'manufactured_countries',
            'official_documents',
            'at_least_country_documents',
            'retail_documents',
            'rent_building_documents',
            'distributor_documents',
            'website_documents',
        ];

    protected $appends = ['status_text'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->user_id = User::getAuthUser()->getAuthIdentifier();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function action(): HasMany
    {
        return $this->hasMany(Action::class, 'application_id', 'id');
    }

        public function history(): HasMany
    {
        return $this->hasMany(ApplicationHistory::class, 'application_id', 'id');
    }

    public function scopeSuccess($query): void
    {
        $query->where('status', Application::SUCCESS);
    }

    public function scopeNew($query): void
    {
        $query->where('status', Application::NEW);
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            self::NEW => 'new',
            self::AT_MODERATOR => 'at_moderator',
            self::AT_COUNCIL => 'at_council',
            self::AT_MINISTRY => 'at_ministry',
            self::SUCCESS => 'success',
            self::CANCEL_BY_MODERATOR => 'cancel_by_moderator',
            self::CANCEL_BY_COUNCIL => 'cancel_by_council',
            self::CANCEL_BY_MINISTRY => 'cancel_by_ministry',
            default => 'error',
        };
    }

    public function isNew(): bool
    {
        return $this->status == Application::NEW;
    }


}
