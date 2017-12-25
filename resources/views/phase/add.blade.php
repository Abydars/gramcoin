@extends('layouts.admin')

@section('top')
    <a href="{{ route('phase.index') }}" class="btn btn-danger">Cancel</a>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @if(!empty($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif
            @if(!empty($success))
                <div class="alert alert-success">
                    {{ $success }}
                </div>
            @endif
            {!! Form::open(['route' => ['phase.add'], 'id' => 'new-phase-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => 'form-horizontal']) !!}
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        {!! Form::text('title', false, ['id' => 'input-title','class' => 'form-control', 'required']) !!}
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Launch Date/Time</label>
                    <div class="col-sm-4">
                        <div class="datetimepicker input-group date mb-lg">
                            {!! Form::text('launch_time', false, ['id' => 'input-launch-time','class' => 'form-control', 'required']) !!}
                            <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                 </span>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Number of Tokens</label>
                    <div class="col-sm-10">
                        {!! Form::number('tokens', false, ['id' => 'input-tokens','class' => 'form-control', 'required']) !!}
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Per User Limit</label>
                    <div class="col-sm-10">
                        {!! Form::number('user_limit', false, ['id' => 'input-user-limit','class' => 'form-control', 'required']) !!}
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Token Rate</label>
                    <div class="col-sm-10">
                        <div class="input-group mb-lg">
                            <span class="input-group-addon">
                                    <span class="fa fa-dollar"></span>
                                 </span>
                            {!! Form::number('token_rate', false, ['id' => 'input-token-rate','class' => 'form-control', 'required', 'step' => 'any']) !!}
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Active/Inactive</label>
                    <div class="col-sm-10">
                        {!! Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive', 'completed' => 'Completed'], 'active', ['id' => 'input-status','class' => 'form-control', 'required']) !!}
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </fieldset>
            {!! Form::close() !!}
        </div>
    </div>
    </div>
@endsection