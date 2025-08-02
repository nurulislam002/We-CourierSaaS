<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['key','value', 'company_id'];

    public function scopeCompanywise($query){
        return $query->where('company_id',settings()->id);
    }

}
