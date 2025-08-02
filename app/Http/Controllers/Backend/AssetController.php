<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreRequest;
use App\Models\Backend\Accident;
use App\Models\Backend\Asset;
use App\Models\Backend\AssetAssign;
use App\Models\Backend\Fuel;
use App\Models\Backend\Maintenance;
use App\Repositories\Asset\AssetInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AssetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repo;

    public function __construct(AssetInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        $assets = $this->repo->all();
        return view('backend.asset.index',compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assetcategorys = $this->repo->assetcategorys();
        $hubs           = $this->repo->hubs();
        return view('backend.asset.create',compact('assetcategorys','hubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if($this->repo->store($request)){
            Toastr::success('Asset successfully added.',__('message.success'));
            return redirect()->route('asset.index');
        }else{
            Toastr::error('Something went wrong.',__('message.error'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assets             = $this->repo->get($id);
        $assetcategorys     = $this->repo->assetcategorys();
        $hubs               = $this->repo->hubs();
        return view('backend.asset.edit',compact('assetcategorys','hubs','assets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request)
    {
        if($this->repo->update($request)){
            Toastr::success('Asset successfully Update.',__('message.success'));
            return redirect()->route('asset.index');
        }else{
            Toastr::error('Something went wrong.',__('message.success'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repo->delete($id);
        Toastr::success('Asset successfully deleted.',__('message.success'));
        return back();
    }

    public function reports(Request $request){
        $data =[];
        $data['request'] = $request;
        $data['assets'] = Asset::orderBy('id','desc')->get();

        if($request->asset_id && !empty($request->asset_id)):
            $start_date = Carbon::parse($request->from_date)->startOfDay()->toDateTimeString();
            $end_date   = Carbon::parse($request->to_date)->endOfDay()->toDateTimeString();
            $data['asset']            = Asset::find($request->asset_id);
            $data['fuels']            = Fuel::where('asset_id',$request->asset_id)->whereBetween('created_at',[$start_date,$end_date])->orderBy('id','desc')->get();
            $data['accidents']        = Accident::where('asset_id',$request->asset_id)->whereBetween('date_of_accident',[$start_date,$end_date])->orderBy('id','desc')->get();
            if($request->from_date  && $request->to_date):
                $data['maintenances']     = Maintenance::where('asset_id',$request->asset_id)->whereDate('start_date','>=' ,$start_date)->whereDate('end_date','<=',$end_date)->orderBy('id','desc')->get();
            else:
                $data['maintenances']     = Maintenance::where('asset_id',$request->asset_id)->orderBy('id','desc')->get();
            endif;
            if($request->from_date  && $request->to_date):
                $data['assigned_drivers'] = AssetAssign::where('asset_id',$request->asset_id)->whereDate('from_date','>=',$start_date)->whereDate('to_date','<=',$end_date)->orderBy('id','desc')->get();
            else:
                $data['assigned_drivers'] = AssetAssign::where('asset_id',$request->asset_id)->orderBy('id','desc')->get();
            endif;
        endif;

        return view('backend.asset.reports',$data);
    }
}
