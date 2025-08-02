<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'type',
        'company_id'
    ];

    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }

    public function scopeCompanyWise($query)
    {
        $query->where('company_id', settings()->id);
    }
}
