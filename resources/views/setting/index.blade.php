@extends('layouts.admin')

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
            {!! Form::open(['id' => 'new-phase-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => 'form-horizontal']) !!}
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Referral Percentages</label>
                    <div class="col-sm-10">
                        {!! Form::text(\App\Setting::REFERRAL_PERCENTS, $referral_percents, ['id' => 'input-referral-percents','class' => 'form-control', 'required']) !!}
                        <small>Increase or decrease bonus levels by editing number of percentages defined in this
                            field<br/>Enter referral bonus percentages (comma separated), ex. 50,40,30<br/>50 = First
                            Level<br/>40
                            = Second Level<br/>30 = Third Level
                        </small>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Transaction Fee</label>
                    <div class="col-sm-10">
                        <div class="input-group mb-lg">
                            <span class="input-group-addon">
                                    <span class="fa fa-bitcoin"></span>
                                 </span>
                            {!! Form::number(\App\Setting::TRANSACTION_FEE, $transaction_fee, ['id' => 'input-transaction-fee','class' => 'form-control', 'required', 'step' => 'any']) !!}
                        </div>
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