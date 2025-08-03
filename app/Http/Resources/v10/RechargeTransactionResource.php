<?php

namespace App\Http\Resources\v10;

use Illuminate\Http\Resources\Json\JsonResource;

class RechargeTransactionResource extends JsonResource
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
            "user_id"               => $this->user_id,
            "transaction_id"        => $this->transaction_id,
            "amount"                => $this->amount,
            "payment_method"        => $this->payment_method,
            "online_payment_id"    => $this->online_payment_id,
            "payment_method_name"      => __('WalletPaymentMethod.' . $this->payment_method),
            "status_name"           => trans("WalletStatus." . $this->status),
            "status"                => $this->status,
            'created_at'            => dateFormat($this->created_at),
            'updated_at'            => $this->updated_at->format('d M Y, h:i A'),
        ];
    }

}
