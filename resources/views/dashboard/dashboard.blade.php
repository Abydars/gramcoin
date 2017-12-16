@extends('layouts.admin')

@section('content')
    <!-- START widgets box-->
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-primary">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                        <em class="icon-chart fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">{{ $btc_balance }}</div>
                        <div class="text-uppercase">BTC Deposit</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-warning-light">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-warning-dark pv-lg">
                        <em class="fa fa-bitcoin fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">${{ $btc_value }}</div>
                        <div class="text-uppercase">BTC Value</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-purple">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-purple-dark pv-lg">
                        <em class="icon-tag fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">{{ $user->token_balance }}</div>
                        <div class="text-uppercase">Tokens</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <!-- START widget-->
            <div class="panel widget bg-green">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-green-dark pv-lg">
                        <em class="fa fa-dollar fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">${{ $token_rate }}</div>
                        <div class="text-uppercase">Token Rate</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- START widget-->
            <div class="panel widget bg-gray">
                <div class="row row-table">
                    <div class="col-xs-4 text-center bg-gray-dark pv-lg">
                        <em class="icon-wallet fa-3x"></em>
                    </div>
                    <div class="col-xs-8 pv-lg">
                        <div class="h2 mt0">{{ $unc_balance }}</div>
                        <div class="text-uppercase">UNC</div>
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
        <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- START widget-->
            <div class="panel widget bg-gray">
                <div class="row row-table">
                    <div class="col-xs-12 pv-lg">
                        <div class="text-uppercase">Referral Link</div>
                        <div class="input-group">
                            <input type="text" readonly value="{{ route('register.referral', $user->guid) }}"
                                   class="form-control" style="height: 44px;"/>
                            <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" style="height: 44px;"><em
                                                class="fa fa-files-o"></em></button>
                                 </span>
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
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Recent Transactions</div>
                        </div>
                        <div data-height="238" data-scrollable="" class="list-group">

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Lipsum</div>
                        </div>
                        <!-- START list group-->
                        <div data-height="238" data-scrollable="" class="list-group">

                        </div>
                        <!-- END list group-->
                        <!-- START panel footer-->
                        <div class="panel-footer clearfix">

                        </div>
                        <!-- END panel-footer-->
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- START messages and activity-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Lipsum</div>
                        </div>
                        <!-- START list group-->
                        <div data-height="280" data-scrollable="" class="list-group">

                        </div>
                        <!-- END list group-->
                    </div>
                    <!-- END messages and activity-->
                </div>
            </div>
        </div>
        <!-- END dashboard main content-->
    </div>
@endsection