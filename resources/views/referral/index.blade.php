@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-pink-custom text-white pv-lg">
                        <em class="fa fa-share fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">{{ $referral_count }}</div>
                        <div class="text-uppercase">Referrals</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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