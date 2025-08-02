<?php

namespace App\Repositories\PaymentGateway;

use App\Enums\PaymentType;
use App\Models\Backend\PaymentGateway;
use App\Repositories\PaymentGateway\PaymentGatewayInterface;

class PaymentGatewayRepository implements PaymentGatewayInterface
{
    public function all()
    {
        return PaymentGateway::companyWise()
        ->orderByDesc('id')
        ->paginate(10);
    }

    public function find($id)
    {
        return PaymentGateway::find($id);
    }

    public function filter($request)
    {
        return PaymentGateway::companywise()
        ->when(
            $request->filled('name'),
            fn($query)=>$query->where('name', 'like', '%'. $request->name. '%')
        )
        ->when(
            $request->filled('payment_method'),
            fn($query)=>$query->where('type', $request->payment_method == 'bank' ? PaymentType::BANK : PaymentType::MOBILE )
        )
        ->orderByDesc('id')
        ->paginate(10);
    }

    public function store($request)
    {
        try{
            PaymentGateway::create([
                ...$request->all(),
                'company_id'=>settings()->id
            ]);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public function update($id, $request)
    {
        try{
            $payment_getway= PaymentGateway::find($id);
            $payment_getway->update($request->all());
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public function destroy($id)
    {
        try{
            $payment_getway= PaymentGateway::find($id);
            $payment_getway->delete();
        }
        catch(\Exception $e){
            return false;
        }
    }
}
