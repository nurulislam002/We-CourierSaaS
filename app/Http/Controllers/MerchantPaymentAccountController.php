<?php

namespace App\Http\Controllers;

use App\Http\Requests\Merchantpayment\StoreBankRequest;
use App\Http\Requests\Merchantpayment\StoreMobileRequest;
use Illuminate\Http\Request;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\MerchantPayment\PaymentInterface;
use App\Repositories\PaymentGateway\PaymentGatewayInterface;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
class MerchantPaymentAccountController extends Controller
{
    protected $repo;
    protected $payRepo;
    public function __construct(MerchantInterface $repo,PaymentInterface $payRepo, protected PaymentGatewayInterface $paymentRepo)
    {
        $this->repo    = $repo;
        $this->payRepo = $payRepo;
    }
    public function index($id){
        $singleMerchant = $this->repo->get($id);
        $payments       = $this->payRepo->get($id);

        return view('backend.merchant.payment.index',compact('singleMerchant','payments'));
    }
    public function paymentAdd($id){
        $singleMerchant = $this->repo->get($id);
        $merchant_id    = $id;
        $payment_gateways = $this->paymentRepo->all();
        return view('backend.merchant.payment.add_payment',compact('singleMerchant','merchant_id','payment_gateways'));
    }
    public function paymentEdit($mid,$id){
        $singleMerchant = $this->repo->get($mid);
        $paymentInfo    = $this->payRepo->edit($id);
        $merchant_id    = $mid;
        return view('backend.merchant.payment.edit_payment',compact('singleMerchant','merchant_id','paymentInfo'));
    }

    public function paymentChange(Request $request){
        $payment_method = $request->payment_method;
        $merchant_id    = $this->repo->get($request->merchant_id)->id;
        $editid         = $request->editid;
        $payment_gateways = $this->paymentRepo->filter($request);

        if($request->payment_method == 'bank'){
            return view('backend.merchant.payment.bank',compact('payment_method','merchant_id' ,'editid', 'payment_gateways'));
        }elseif($request->payment_method == 'mobile'){
            return view('backend.merchant.payment.mobile',compact('payment_method','merchant_id','editid', 'payment_gateways'));
        }elseif($request->payment_method == 'cash'){
            return view('backend.merchant.payment.cash',compact('payment_method','merchant_id','editid'));
        }
    }

    // bank payment information store
    public function bankStore(StoreBankRequest $request){
        if($this->payRepo->bankstore($request)){
            if($request->editid !==null){
                Toastr::success(__('merchant.payment_update_msg'),__('message.success'));
            }else{
                Toastr::success(__('merchant.payment_added_msg'),__('message.success'));
            }
            return redirect()->route('merchant.paymentaccount.index',$request->merchant_id);
        }else{
            Toastr::error(__('merchant.payment_error_msg'),__('message.error'));
            return Redirect::back()->withInput();
        }
    }



    //mobile payment information store
    public function mobileStore(StoreMobileRequest $request){
        if($this->payRepo->mobilestore($request)){
            if($request->editid !==null){
                Toastr::success(__('merchant.payment_update_msg'),__('message.success'));
            }else{
                Toastr::success(__('merchant.payment_added_msg'),__('message.success'));
            }
            return redirect()->route('merchant.paymentaccount.index',$request->merchant_id);
        }else{
            Toastr::error(__('merchant.payment_error_msg'),__('message.error'));
            return Redirect::back()->withInput();
        }
    }


    //update

    public function bankUpdate(StoreBankRequest $request){
        if($this->payRepo->bankupdate($request)){
            Toastr::success(__('merchant.payment_update_msg'),__('message.success'));
            return redirect()->route('merchant.paymentaccount.index',$request->merchant_id);
        }else{
            Toastr::error(__('merchant.payment_error_msg'),__('message.error'));
            return Redirect::back()->withInput();
        }
    }
    public function mobileUpdate(StoreMobileRequest $request){
        if($this->payRepo->mobileupdate($request)){
            Toastr::success(__('merchant.payment_update_msg'),__('message.success'));
            return redirect()->route('merchant.paymentaccount.index',$request->merchant_id);
        }else{
            Toastr::error(__('merchant.payment_error_msg'),__('message.error'));
            return Redirect::back()->withInput();
        }
    }
    public function destroy($id){
        $this->payRepo->delete($id);
        Toastr::success(__('merchant.payment_account_delete_msg'),__('message.success'));
        return back();
    }
}
