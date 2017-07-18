@include('layout.header')
<style>
    .popover-title {
        color: white;
        background-color: black;
        font-size: 15px;
    }
</style>
<body>
@include('layout.sidebar')
<div class="container-fluid">
    @include('layout.logo')
    <div class="row middle">
        <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
        <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
        </div>
        <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    </div>
    <div class="row" style="margin-top: 50px;">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="text-align: center;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <a href="https://www.vultr.com/?ref=6877914"><img src="https://www.vultr.com/media/banner_1.png" width="728" height="90"></a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <br><br><br>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <div class="alert alert-info">Want your Coin Listed here? Email us: <a href="mailto:addme@masternodes.pro">addme@masternodes.pro</a></div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <table width="100%">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Coin</td>
                        <td>Total Master Nodes</td>
                        <td>Coins Locked in MasterNodes</td>
                        <td>Current USD Price</td>
                        <td>Required Coin's</td>
                        <td>What's a Node Worth</td>
                        <td>Daily Income</td>
                        <td>Weekly Income</td>
                        <td>Monthly Income</td>
                        <td>Yearly Income</td>
                        <td>Last Updated</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($coinList as $key => $one)
                        <tr>
                            <td><a href="https://{!! strtoupper($key) !!}.masternodes.pro" target="_blank"><img src="{!! $one['logo'] !!}" width="50vw"></a></td>
                            <td><a href="https://{!! strtoupper($key) !!}.masternodes.pro" target="_blank">{!! strtoupper($key) !!}</a></td>
                            <td>{!! $one['totalMasterNodes'] !!}</td>
                            <td>{!! number_format($one['totalMasterNodes'] * $one['masterNodeCoinsRequired'],'0','',',') !!}</td>
                            <td>${!! number_format($one['currentUSDPrice'],2,'.','') !!}</td>
                            <td>{!! $one['masterNodeCoinsRequired'] !!} {!! strtoupper($key) !!}</td>
                            <td>${!! $one['masterNodeWorth'] !!}</td>
                            <td>${!! $one['income']['daily'] !!}</td>
                            <td>${!! $one['income']['weekly'] !!}</td>
                            <td>${!! $one['income']['monthly'] !!}</td>
                            <td>${!! $one['income']['yearly'] !!}</td>
                            <td>{!! $one['lastUpdated'] !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <br><br><br>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <div class="alert alert-info">Coming Soon.</div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <table width="100%">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Coin</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ComingSoonCoinList as $key => $one)
                        <tr>
                            <td><a href="{!! $one['url'] !!}" target="_blank"><img src="{!! $one['logo'] !!}" width="50vw"></a></td>
                            <td><a href="{!! $one['url'] !!}" target="_blank">{!! strtoupper($key) !!}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <br><br><br>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <div class="alert alert-info">Help Fund Masternode Detail Site for 1 Year.</div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <table width="100%">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Coin</td>
                        <td>Required</td>
                        <td>Balance</td>
                        <td>Need</td>
                        <td>Donation Address</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($donateCoinList as $key => $one)
                        <tr>
                            <td><a href="{!! $one['url'] !!}" target="_blank"><img src="{!! $one['logo'] !!}" width="50vw"></a></td>
                            <td><a href="{!! $one['url'] !!}" target="_blank">{!! strtoupper($key) !!}</a></td>
                            <td>${!! number_format($one['need'],'2','.',',') !!}</td>
                            <td>${!! number_format($one['current'],'2','.',',') !!}</td>
                            <td>${!! number_format($one['balance'],'2','.',',') !!}</td>
                            <td>
                                @foreach ($one['donate'] as $donateKey => $donateOne)
                                    {!! strtoupper($donateKey) !!}:
                                    <a href="{!! strtoupper($donateKey) !!}:{!! $donateOne !!}"
                                       target="_blank"
                                       data-toggle="popover"
                                       data-trigger="hover"
                                       title="{!! strtoupper($donateKey) !!} address"
                                       data-html="true"
                                       data-content="<img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={!! $donateOne !!}' width='150'>"
                                    >
                                        {!! $donateOne !!}
                                    </a>
                                    <Br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <br><br><br>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                <script data-cfasync=false src="//s.ato.mx/p.js#id=2194065&size=728x90"></script>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
    </div>
    @include('layout.footer')
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    </div>
</div>
@include('layout.analytics')
<script>
    $('[data-toggle="popover"]').popover()
</script>
</body>
</html>
