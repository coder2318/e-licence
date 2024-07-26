<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

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
}
