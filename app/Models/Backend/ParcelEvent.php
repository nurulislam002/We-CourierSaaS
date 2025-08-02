<?php

namespace App\Models\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ParcelEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 
        'cancel_parcel_id'
    ];

    public static function boot()
    {
        parent::boot(); 
        static::creating(function($model)
        {
            $model->company_id = settings()->id; 
        }); 
    }


    public function deliveryMan(){
        return $this->belongsTo(DeliveryMan::class,'delivery_man_id','id')->with(['user']);
    }
    public function pickupman(){
        return $this->belongsTo(DeliveryMan::class,'pickup_man_id','id')->with(['user']);
    }
    public function transferDeliveryman(){
        return $this->belongsTo(DeliveryMan::class,'transfer_delivery_man_id','id');
    }
    public function hub(){
        return $this->belongsTo(Hub::class,'hub_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function parcel(){
        return $this->belongsTo(Parcel::class,'parcel_id','id');
    }


    public function scopeCompanywise($query)
    {
        return $query->where('company_id', settings()->id);
    }

}
