@extends('layouts.admin')

@section('content')
    <div class="panel panel-default" id="referrals-panel">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row row-table">
                @if(!empty($referrals))
                    {!! Referral::renderReferralList($referrals) !!}
                @else
                    <h5 class="mt0 text-danger">You've not referred to anyone</h5>
                    <h3>Refer and Earn {{ $percentages[count($percentages) - 1] }}-{{ $percentages[0] }}% of
                        bonuses</h3>
                    <div class="input-group">
                        <input id="link-input" type="text" readonly
                               value="{{ route('register.referral', $user->guid) }}"
                               class="form-control" style="height: 44px;"/>
                        <span class="input-group-btn">
                                    <button type="button" data-copy-text="#link-input" class="btn btn-default"
                                            style="height: 44px;"><em
                                                class="fa fa-files-o"></em></button>
                                 </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection