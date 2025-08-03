<?php

namespace App\Http\Resources\v10;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [

            "id"                    => $this->id,
            "currency"              => settings()->currency,
            "source"                => $this->source,
            "user_id"                => $this->user_id,
            "transaction_id"         => $this->transaction_id,
            "amount"               => $this->amount,
            "online_payment_id"    => $this->online_payment_id,
            "payment_method"        => $this->payment_method,
            "payment_method_name"      => __('WalletPaymentMethod.' . $this->payment_method),
            "status"                => $this->status,
            "status_name"      => trans("WalletStatus." . $this->status),
            'created_at'            => dateFormat($this->created_at),
            'updated_at'            => $this->updated_at->format('d M Y, h:i A'),
        ];
    }

}
