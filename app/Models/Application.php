<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function scopeSuccess($query): void
    {
        $query->where('status', Application::SUCCESS);
    }

    public function scopeNew($query): void
    {
        $query->where('status', Application::NEW);
    }



}
