@extends('backend.partials.master')
@section('title')
    {{ __('payment-gateway.title') }} {{ __('levels.list') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('levels.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('payment-gateway.index')}}" class="breadcrumb-link">{{ __('payment-gateway.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ __('levels.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- data table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('payment-gateway.filter')}}"  method="GET">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12 col-xl-3 col-lg-4 col-md-6" >
                                <label for="name">{{ __('levels.name') }}</label>
                                <input type="text" id="name" name="name" placeholder="{{ __('placeholder.Enter_name') }}"  class="form-control" value="{{old('name', $request->name)}}">
                                @error('name')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-xl-3 col-lg-4 col-md-6 pt-1">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 d-flex justify-content pl-0">
                                    <button type="submit" class="btn btn-space btn-primary"><i class="fa fa-filter"></i> {{ __('levels.filter') }}</button>
                                    <a href="{{ route('payment-gateway.index') }}" class="btn btn-space btn-secondary"><i class="fa fa-eraser"></i> {{ __('levels.clear') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="row pl-4 pr-4 pt-4">
                    <div class="col-6">
                        <p class="h3">{{ __('payment-gateway.title') }}</p>
                    </div>
                    <div class="col-6">
                        <a href="{{route('payment-gateway.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ __('levels.add') }}"><i class="fa fa-plus"></i></a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('levels.id') }}</th>
                                    <th>{{ __('levels.name') }}</th>
                                    <th>{{ __('levels.type') }}</th>
                                    <th>{{ __('levels.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($payment_gateways as $gateway)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <div>{{ $gateway->name }}</div>
                                    </td>
                                    <td >
                                        <div>{{ __('PaymentType.'.$gateway->type)}}</div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <button tabindex="-1" data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"><span class="sr-only">Toggle Dropdown</span></button>
                                            <div class="dropdown-menu">
                                                <a href="{{route('payment-gateway.edit',$gateway->id)}}" class="dropdown-item"><i class="fas fa-edit" aria-hidden="true"></i> {{ __('levels.edit') }}</a>
                                                <form id="delete" value="Test" action="{{route('payment-gateway.destroy',$gateway->id)}}" method="POST" data-title="{{ __('delete.payment-gateway') }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="dropdown-item"><i class="fa fa-trash" aria-hidden="true"></i> {{ __('levels.delete') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-12">
                    <div class="table-responsive">
                        <span>{{ $payment_gateways->links() }}</span>
                        <p class="p-2 small">
                            {!! __('Showing') !!}
                            <span class="font-medium">{{ $payment_gateways->firstItem() }}</span>
                            {!! __('to') !!}
                            <span class="font-medium">{{ $payment_gateways->lastItem() }}</span>
                            {!! __('of') !!}
                            <span class="font-medium">{{ $payment_gateways->total() }}</span>
                            {!! __('results') !!}
                        </p>
                    </div>
                </div>

            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper-->
@endsection()


