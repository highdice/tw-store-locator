@extends('layouts.app')

@section('content')
<div class="container">
    <h3><i class="glyphicon glyphicon-plus header-icon"></i> Add New Branch</h3>
    <p class="sub-header">Fields with <i class="glyphicon glyphicon-certificate required"></i> are required.
    <hr />

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/api/v1/stores/add') }}">
        {!! csrf_field() !!}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Store Code</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the code here" name="code" value="{{ old('code') }}">

                            @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('branch_code') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Branch Code</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the branch code here" name="branch_code" value="{{ old('branch_code') }}">

                            @if ($errors->has('branch_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('branch_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('trade_name') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Trade Name</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the trade name here" name="trade_name" value="{{ old('trade_name') }}">

                            @if ($errors->has('trade_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('trade_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Branch Name</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the branch name here" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('size') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Size (sqm)</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter size in square meters here" name="size" value="{{ old('size') }}">

                            @if ($errors->has('size'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('size') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('division') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Division</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter division number here" name="division" value="{{ old('division') }}">

                            @if ($errors->has('division'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('division') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('date_opened') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Date Opened</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" id="date_opened" class="form-control" placeholder="Enter the date of opening here" name="date_opened" value="{{ old('date_opened') }}">

                            @if ($errors->has('date_opened'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_opened') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('date_opened') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Contact Number/s</span>
                            <i class="glyphicon glyphicon-certificate input-icon"></i>
                            <input type="text" id="contact_number" class="form-control" placeholder="Enter the contact number here" name="contact_number" value="{{ old('contact_number') }}">

                            @if ($errors->has('contact_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Address</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the address here" name="address" value="{{ old('address') }}">

                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Zip Code</span>
                            <i class="glyphicon glyphicon-certificate input-icon"></i>
                            <input type="text" class="form-control" placeholder="Enter the zip code here" name="zip_code" value="{{ old('zip_code') }}">

                            @if ($errors->has('zip_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('zip_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Region</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            
                            <select class="form-control" name="region" value="{{ old('region') }}">
                                <option value="">Choose a region</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->title . ' - ' . $region->description }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('region'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('region') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('island_group') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Island Group</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="radio" class="first-radio" id="island_group-1" name="island_group" checked="checked" value="1"><label for="island_group-1">Luzon</label>
                            <input type="radio" id="island_group-2" name="island_group" value="2"><label for="island_group-2">Visayas</label>
                            <input type="radio" id="island_group-3" name="island_group" value="3"><label for="island_group-3">Mindanao</label>

                            @if ($errors->has('island_group'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('island_group') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Longitude</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the longitude here" name="longitude" value="{{ old('longitude') }}">

                            @if ($errors->has('longitude'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('longitude') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Latitude</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the latitude here" name="latitude" value="{{ old('latitude') }}">

                            @if ($errors->has('latitude'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('latitude') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <br />
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary guest-button">
                                <i class="fa fa-btn fa-check"></i>Submit
                            </button>
                            <a href="{{ url('/stores') }}" class="btn btn-primary guest-button">
                                <i class="fa fa-btn fa-arrow-left"></i>Back
                            </a>
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </form>
</div>
@endsection
