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
        <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 text-center">
        </div>
        <div class="col-lg-1 hidden-md hidden-sm hidden-xs"></div>
    </div>
    <div class="row" style="margin-top: 50px;">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 text-center" >
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="row">
                    <div class="span4"></div>
                    <div class="span4"><a href="https://www.vultr.com/?ref=6877914"><span style="font-size: 16px">Best VPS Hosting for Masternodes</span><br><img src="https://www.vultr.com/media/banner_1.png" class="img-responsive center-block"></a></div>
                    <div class="span4"></div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
                <br><br><br>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="alert alert-info">Want your Coin Listed here? Email us:
                    <a href="mailto:addme@masternodes.pro">addme@masternodes.pro</a> or join us on
                    <a href="https://join.slack.com/t/masternodespro/shared_invite/MjEzNDg5NjM2NjI3LTE1MDAyNjE2ODgtZTQ0Y2M5ZDk5OQ"><i class="fa fa-slack" aria-hidden="true"></i>SLACK</a>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                @foreach ($coinList as $key => $one)
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 align-left" style="margin-top: 20px;">
                        <div class="coinbox-inner">
                            <div>
                                <div style="float:right;width:67%;border: 0px solid #000;text-align:center;padding:5px 0px;line-height:30px;">
                                    <div>
                                        <span style="font-size: 18px;">
                                            <a href="https://{!! strtoupper($one['coin']) !!}.masternodes.pro" target="_blank" style="text-decoration: none; color: rgb(66, 139, 202);">{!! $one['name'] !!} ({!! strtoupper($one['coin']) !!})</a>
                                        </span>
                                    </div>
                                    <div>
                                        <span style="font-size: 16px;">${!! number_format($one['currentUSDPrice'],2,'.','') !!} USD</span>
                                    </div>
                                </div>
                                <div style="text-align:center;padding:5px 0px;width:33%;"><a href="https://{!! strtoupper($one['coin']) !!}.masternodes.pro" target="_blank"><img src="{!! $one['logo'] !!}" width="50vw"></a></div>
                            </div>
                            <div class="coin-supply">
                                Coin Supply: {!! $one['coin_supply'] !!}
                            </div>
                            <div class="coin-box-row text-center">
                                <div class="col-md-6" > Total Master Nodes <br><br> <span>{!! $one['totalMasterNodes'] !!}</span></div>
                                <div class="col-md-6" > Coins Locked <br><br> <spa >{!! number_format($one['totalMasterNodes'] * $one['masterNodeCoinsRequired'],'0','',',') !!} ({!! number_format(((($one['totalMasterNodes'] * $one['masterNodeCoinsRequired']) /  $one['coin_supply'] ) * 100),'2','.',',') !!}%)<Br></span></div>
                            </div>
                            <div class="coin-box-row text-center">
                                <div class="col-md-4" > Required Coin's <br><br> <span>{!! $one['masterNodeCoinsRequired'] !!}</span></div>
                                <div class="col-md-4" > Node Worth <br><br> <span>${!! number_format($one['currentUSDPrice'] * $one['masterNodeCoinsRequired'],2,'.','') !!}</span></div>
                                <div class="col-md-4">   ROI % <br><br> <span >{!!  number_format($one['roi'],2,'.','') !!}%</span>
                                </div>
                            </div>
                            <div class="coin-box-row text-center">
                                <div class="col-md-3" > Daily <br><br> <span >${!! number_format($one['income']['daily'],2,'.','') !!}</span></div>
                                <div class="col-md-3" > Weekly <br><br> <span >${!! number_format($one['income']['weekly'],2,'.','') !!}</span></div>
                                <div class="col-md-3" > Monthly <br><br> <span >${!! number_format($one['income']['monthly'],2,'.','') !!}</span></div>
                                <div class="col-md-3" > Yearly <br><br> <span >${!! number_format($one['income']['yearly'],2,'.','') !!}</span></div>
                            </div>
                            <div style="border-top: 1px solid #E4E6EB;text-align:center;clear:both;font-size:10px;font-style:italic;padding:5px 0;">
                                Last Updated <br>{!! $one['lastUpdated'] !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <br><br><br>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <script data-cfasync=false src="//s.ato.mx/p.js#id=2194065&size=728x90"></script>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center" >
            <div class="col-lg-12 col-md-12 col-sm-9 col-xs-9 text-center">
                <a class="twitter-timeline" href="https://twitter.com/MasterNodesPro">Tweets by MasterNodesPro</a>
                <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
        </div>
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
