@extends('backend.partials.master')
@section('title')
    {{ __('payment-gateway.title') }} {{ __('levels.add') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('levels.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('payment-gateway.index') }}" class="breadcrumb-link">{{ __('payment-gateway.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ __('levels.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- basic form -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="pageheader-title">{{ __('payment-gateway.create_payment_gateway') }}</h2>
                    <form action="{{route('payment-gateway.store')}}"  method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group" id="name">
                                    <label for="name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="name" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_name') }}" autocomplete="off" class="form-control" value="{{old('name')}}" require>
                                    @error('name')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="type">{{ __('levels.type') }}</label> <span class="text-danger" id="typeRequired"> @error('type') * @enderror</span>
                                    <select id="type" name="type" class="form-control @error('type') is-invalid @enderror">
                                        <option selected disabled>{{ __('menus.select') }} {{ __('levels.type') }}</option>
                                        @foreach(\config('payment-gateway.gateway-type') as $key => $value)
                                            <option value="{{ $value }}" {{ (old('type') == $value) ? 'selected' : '' }}>{{ __('PaymentType.'.$value)}}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row " >
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <button type="submit" class="btn btn-space btn-primary">{{ __('levels.save') }}</button>
                                <a href="{{ route('payment-gateway.index') }}" class="btn btn-space btn-secondary">{{ __('levels.cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
</div>
@endsection()


