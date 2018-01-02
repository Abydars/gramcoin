@extends('layouts.admin')

@push('styles')
<style>
    #top-layout {
        width: 50%;
    }

    @media screen and (max-width: 800px) {
        #top-layout {
            width: 100%;
        }
    }
</style>
@endpush

@section('top')
    <div class="text-right">
        <div class="inline br pr-lg">
            <div class="text-uppercase">1 BTC = ${{ number_format( $btc_value, 2 ) }}</div>
        </div>
        <div class="inline">
            <div class="text-uppercase">1 GRM = ${{ $token_rate }}</div>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('content')
    <!-- START widgets box-->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- START widget-->
            <div class="panel widget bg-gray">
                <div class="row row-table">
                    <div class="col-xs-12 pv-lg">
                        <div class="text-uppercase">Referral Link</div>
                        <div class="input-group">
                            <input id="address-input" type="text" readonly
                                   value="{{ route('register.referral', $user->guid) }}"
                                   class="form-control" style="height: 44px;"/>
                            <span class="input-group-btn">
                                    <button type="button" data-copy-text="#address-input" class="btn btn-default"
                                            style="height: 44px;"><em
                                                class="fa fa-files-o"></em></button>
                                 </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-orange-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
                        <em class="fa fa-bitcoin fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h3 mt0 mb0">{{ $btc_balance }}</div>
                        <div class="h6 mt0 mb-sm text-dark text-bold">{{ $unc_balance }}</div>
                        <div class="text-uppercase">BTC Deposit</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-purple-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
                        <img src="{{ asset('/img/currency-light.png') }}"/>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">{{ number_format(0, 2) }}</div>
                        <div class="text-uppercase">GRM Wallet</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-red-custom text-white">
                <div class="row row-table">
                    <div class="col-xs-4 text-center pv-lg">
                        <em class="fa fa-dollar fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">${{ number_format(0, 2 ) }}</div>
                        <div class="text-uppercase">USD Wallet</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- START date widget-->
            <div class="panel widget">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-green pv-lg">
                        <!-- See formats: https://docs.angularjs.org/api/ng/filter/date-->
                        <div data-now="" data-format="MMMM" class="text-sm">January</div>
                        <br>
                        <div data-now="" data-format="D" class="h2 mt0">00</div>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div data-now="" data-format="dddd" class="text-uppercase">Thursday</div>
                        <br>
                        <div data-now="" data-format="h:mm" class="h2 mt0">00:00</div>
                        <div data-now="" data-format="a" class="text-muted text-sm">pm</div>
                    </div>
                </div>
            </div>
            <!-- END date widget    -->
        </div>
    </div>
    <div class="row text-center mb-xl mt-sm">
        <div class="col-lg-3">
            <div class="bg-gray">
                <a href="#" class="btn bg-gray text-bold text-md pv-lg ph-xl">Lending</a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="bg-gray">
                <a href="#" class="btn bg-gray text-bold text-md pv-lg ph-xl">Reinvest</a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="bg-gray">
                <a href="#" class="btn bg-gray text-bold text-md pv-lg ph-xl">Convert USD</a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="bg-gray">
                <a href="#" class="btn bg-gray text-bold text-md pv-lg ph-xl">Exchange</a>
            </div>
        </div>
    </div>
    <div class="row mb-xl">
        <div class="col-lg-2 col-md-6 col-sm-12 mb-sm">
            <div class="panel widget mb0">
                <div class="panel-body bg-purple-custom text-center">
                    <p class="text-sm">Today Earning</p>
                    <div class="text-md">$300</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 mb-sm">
            <div class="panel widget mb0">
                <div class="panel-body bg-purple-custom text-center">
                    <p class="text-sm">Total Earned</p>
                    <div class="text-md">$300</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 mb-sm">
            <div class="panel widget mb0">
                <div class="panel-body bg-gradient text-center">
                    <p class="text-sm">Total Active Investment</p>
                    <div class="text-md">$300</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 mb-sm">
            <div class="panel widget mb0">
                <div class="panel-body bg-orange-custom text-center">
                    <p class="text-sm">Total Investment</p>
                    <div class="text-md">$300</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 mb-sm">
            <div class="panel widget mb0">
                <div class="panel-body bg-orange-custom text-center">
                    <p class="text-sm">Total Capital Released</p>
                    <div class="text-md">$300</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Last 6 days credited interest</div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <p class="text-md">1.8%</p>
                            <div class="progress progress-striped progress-xs">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width: 100%">
                                </div>
                            </div>
                            <p class="p0">Completed</p>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <p class="text-md">1.8%</p>
                            <div class="progress progress-striped progress-xs">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="50"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width: 50%">
                                </div>
                            </div>
                            <p class="p0">Pending</p>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <p class="text-md">0%</p>
                            <div class="progress progress-striped progress-xs">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width: 0%">
                                </div>
                            </div>
                            <p class="p0">Pending</p>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <p class="text-md">0%</p>
                            <div class="progress progress-striped progress-xs">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width: 0%">
                                </div>
                            </div>
                            <p class="p0">Pending</p>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <p class="text-md">0%</p>
                            <div class="progress progress-striped progress-xs">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width: 0%">
                                </div>
                            </div>
                            <p class="p0">Pending</p>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <p class="text-md">0%</p>
                            <div class="progress progress-striped progress-xs">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width: 0%">
                                </div>
                            </div>
                            <p class="p0">Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- START dashboard main content-->
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Lending History</div>
                        </div>
                        <div class="panel-body">
                            <table class="table table table-striped table-hover table-bordered table-bordered-force"
                                   id="lending-table">
                                <thead>
                                <tr>
                                    <th style="text-align: left;">Date/Time</th>
                                    <th style="text-align: left;">Lending Package</th>
                                    <th style="text-align: left;">Amount</th>
                                    <th style="text-align: left;">Releasing Date</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END dashboard main content-->
    </div>
@endsection

@push('scripts')
<script>
    jQuery(function ($) {

    });
</script>
@endpush