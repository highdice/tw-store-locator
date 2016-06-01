@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <li><a href="/stores/{{ $branch_id }}/satellite">Satellites</a></li>
  <li class="active">Add</li>
</ol>

<div class="page-title-container">
  <h3>Add Satellite</h3>
  <p>Fields with <i class="glyphicon glyphicon-certificate required"></i> are required.
</div>

<div class="container top-30">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/api/v1/satellite/add') }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="panel panel-default">
            <div class="panel-body">
                <input type="hidden" name="branch_id" value="{{ $branch_id }}">

                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('satellite_code') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Satellite Code</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the satellite code here" name="satellite_code" value="{{ old('satellite_code') }}">

                            @if ($errors->has('satellite_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('satellite_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('trade_name_prefix') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Trade Name</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 no-padding">
                                <input type="text" class="form-control" placeholder="Enter the trade name here" name="trade_name_prefix" value="{{ old('trade_name_prefix') }}">

                                @if ($errors->has('trade_name_prefix'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('trade_name_prefix') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 no-padding">
                                <span class="input-divider">-</span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
                                <select class="form-control input-half" name="trade_name" value="{{ old('trade_name') }}">
                                    @if (!old('trade_name'))
                                        <option value="">Choose a company</option>
                                    @endif
                  
                                    @foreach ($trade_names as $trade_name)
                                        <option value="{{ $trade_name->id }}" {{ (old('trade_name') == $trade_name->id) ? 'selected="selected"' : '' }}>{{ $trade_name->description }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('trade_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('trade_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Satellite Name</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            <input type="text" class="form-control" placeholder="Enter the satellite name here" name="name" value="{{ old('name') }}">

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
                    
                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Upload Image</span>
                            <i class="glyphicon glyphicon-certificate input-icon"></i>
                            <input type="file" id="image" class="form-control" name="image" value="{{ old('image') }}">

                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('contact_number') ? ' has-error' : '' }}">
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
                                @if (!old('region'))
                                        <option value="">Choose a region</option>
                                @endif

                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}" {{ (old('region') == $region->id) ? 'selected="selected"' : '' }}>{{ $region->title . ' - ' . $region->description }}</option>
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

                    <div class="form-group{{ $errors->has('division') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Division</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>

                            <select class="form-control" name="division" value="{{ old('division') }}">
                                @if (!old('division'))
                                        <option value="">Choose a division</option>
                                @endif

                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}" {{ (old('division') == $division->id) ? 'selected="selected"' : '' }}>{{ $division->title }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('division'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('division') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                        <div class="col-md-12 custom-form">
                            <span>Area</span>
                            <i class="glyphicon glyphicon-certificate input-icon required"></i>
                            
                            <select class="form-control" name="area" value="{{ old('area') }}">
                                @if (!old('area'))
                                        <option value="">Choose an area</option>
                                @endif

                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ (old('area') == $area->id) ? 'selected="selected"' : '' }}>{{ $area->title }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('area'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('area') }}</strong>
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
                            <a href="{{ url('/stores/' . $branch_id . '/satellite') }}" class="btn btn-primary guest-button">
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
