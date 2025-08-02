<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\PaymentGateway;
use App\Repositories\PaymentGateway\PaymentGatewayInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentGatewayController extends Controller
{
    public function __construct(
        protected PaymentGatewayInterface $paymentRepo
    )
    {}

    public function index(Request $request)
    {
        return view('backend.payment-gateway.index',
            [
                'payment_gateways'=>$this->paymentRepo->all(),
                'request'=> $request
            ]
        );
    }

    public function filter(Request $request)
    {
         return view('backend.payment-gateway.index',
            [
                'payment_gateways'=>$this->paymentRepo->filter($request),
                'request'=>$request
            ]
        );
    }

    public function create()
    {
        return view('backend.payment-gateway.create');
    }

    public function store(Request $request)
    {
        if($this->paymentRepo->store($request)){
            Toastr::success(__('payment_gateway.added_msg_'),__('message.success'));
            return redirect()->route('payment-gateway.index');
        }else{
            Toastr::error(__('payment_gateway.error_msg'),__('message.error'));
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        return view('backend.payment-gateway.edit', [
            'gateway' => PaymentGateway::find($id)
        ]);
    }

    public function update($id, Request $request)
    {
        if($this->paymentRepo->update($id, $request)){
            Toastr::success(__('payment_gateway.added_msg_'),__('message.success'));
            return redirect()->route('payment-gateway.index');
        }else{
            Toastr::error(__('payment_gateway.error_msg'),__('message.error'));
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if($this->paymentRepo->destroy($id)){
            Toastr::error(__('payment_gateway.delete_msg'),__('message.success'));
            return redirect()->back();
        }else{
            Toastr::error(__('payment_gateway.error_msg'),__('message.error'));
            return redirect()->back();
        }

    }
}
