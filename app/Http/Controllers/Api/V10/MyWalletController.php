<?php

namespace App\Http\Controllers\Api\V10;

use App\Enums\PayoutSetup;
use App\Enums\Wallet\WalletPaymentMethod;
use App\Enums\Wallet\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Resources\v10\Collection\RechargeTransactionCollection;
use App\Http\Resources\v10\Collection\WalletCollection;
use App\Models\Backend\Wallet;
use App\Repositories\Wallet\WalletInterface;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\OnlinePaymentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MyWalletController extends Controller
{
    use OnlinePaymentTrait,ApiReturnFormatTrait;
    protected $repo;
    public function __construct(WalletInterface $repo)
    {
        $this->repo   = $repo;
    }
    public function index(Request $request){

        $wallets                  = $this->repo->get($request);
        $recharge_transactions    = $this->repo->rechargesList($request);
        $data['walletBalance']    = (string) Auth::user()->merchant->wallet_balance;
        $data['totalRecharge']    = (string) number_format(Wallet::where(['user_id'=> Auth::user()->id,'type'=>WalletType::INCOME])->sum('amount'),2);
        $data['totalDeduction']   = (string) number_format(Wallet::where(['user_id'=> Auth::user()->id,'type'=>WalletType::EXPENSE])->sum('amount'),2);
        return $this->responseWithSuccess(__('My Wallet'), ['rechargeTransactions'=>new RechargeTransactionCollection($recharge_transactions),'wallets'=>new WalletCollection($wallets),'walletAmount'=>$data], 200);
    }


    public function rechargeAdd(Request $request){

         $validator = Validator::make($request->all(),[
            'amount'   => ['required','numeric','gt:0']
         ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('My Wallet'), ['message' => $validator->errors()->first()], 422);
        }

         if($request->payment_method == PayoutSetup::PAYMOB):
            $request['wallet_payment_method']   = WalletPaymentMethod::PAYMOB;
         endif;

        if($wallet = $this->repo->store($request)):

            if($wallet && $request->payment_method == PayoutSetup::PAYMOB):

                //online payment

                $requestData  = new Request();
                $requestData['name']            =  @auth()->user()->merchant->business_name;
                $requestData['email']           =  @auth()->user()->email;
                $requestData['phone']           =  @auth()->user()->mobile;
                $requestData['wallet_id']       =  @$wallet->id;
                $requestData['source']          =  'wallet';
                $requestData['merchant_id']     =  @auth()->user()->merchant->id;
                $requestData['amount']          =  $request->amount ?? 0;
                $requestData['payment_method']  =  $request->payment_method;
                $requestData['payment_request_type'] = 'api';

                $goToPayment = $this->onlinePayment($requestData);
                if ($goToPayment):
                    return $this->responseWithSuccess(__('My Wallet Added Successfully'), [
                        'onlinePayment'  =>  true,
                        'walletData'  =>  $goToPayment
                    ], 200);
                //end online payment
                endif;
            endif;
            return $this->responseWithSuccess(__('My Wallet Added Successfully '),  [
                'onlinePayment'  =>  false,
                'walletData'  =>  ''
            ], 200);

        endif;
        return $this->responseWithError(__('My Wallet'), ['message' => __('message.error')], 500);
    }

}
