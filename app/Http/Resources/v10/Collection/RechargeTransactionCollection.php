<?php

namespace App\Http\Resources\v10\Collection;

use App\Http\Resources\v10\RechargeTransactionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RechargeTransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => RechargeTransactionResource::collection($this->collection),
            'meta' => [
                'total' => $this->collection->count(),
            ],
        ];
    }
}
