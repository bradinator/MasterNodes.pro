<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 align-left" style="margin-top: 20px;border:2px solid #E4E6EB;border-radius: 10px;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;min-width:285px;">
    <div class="row">
        <div class="col-sm-4" style="text-align:center;float:left;font-size:12px;padding:12px 0;line-height:1.25em;">
            <div class="row">
                <div style="float:right;width:67%;border: 0px solid #000;text-align:center;padding:5px 0px;line-height:30px;">
                    <div>
                    <span style="font-size: 18px;  font-weight: bold">
                        <a href="https://{!! strtoupper($one['coin']) !!}.masternodes.pro" target="_blank" style="text-decoration: none; color: rgb(66, 139, 202);">{!! $one['name'] !!} ({!! strtoupper($one['coin']) !!})</a>
                    </span>
                    </div>
                    <div>
                        <span style="font-size: 16px; font-weight: bold;color: #78FEAB">${!! number_format($one['currentUSDPrice'],2,'.','') !!} USD</span>
                        <span style="font-size: 16px; font-weight: bold;color: @if($one['cmc']['percent_change_24h'] > 0) #009933 @else #D44836 @endif">({!! number_format($one['cmc']['percent_change_24h'],2,'.','') !!}%)</span>
                    </div>
                </div>
                <div style="text-align:center;padding:5px 0px;width:33%;"><a href="https://{!! strtoupper($one['coin']) !!}.masternodes.pro" target="_blank"><img src="{!! $one['logo'] !!}" width="50vw"></a></div>
            </div>
            <div class="row" style=" font-weight: bold;color: #4B4BBC">Sponsored Coin</div>
        </div>
        <div class="col-sm-6" style="text-align:center;float:left;font-size:12px;padding:12px 0;border-left:1px solid #E4E6EB;border-right:1px solid #E4E6EB;line-height:1.25em;">
            <div style="text-align:center;clear:both;font-size:15px;font-style:italic;padding:5px 0; font-weight: bold">
                <a href="{!! $one['url'] !!}" target="_blank" style="text-decoration: none; color: rgb(66, 139, 202);">{!! $one['name'] !!} Website</a>
            </div>
            <div style="border-top: 1px solid #E4E6EB;text-align:center;clear:both;font-size:10px;font-style:italic;padding:5px 0; font-weight: bold">
                Coin Supply: <span style="color: #1D82AD">{!! $one['coin_supply'] !!}</span>
            </div>
            <div style="border-top: 1px solid #E4E6EB;text-align:center;clear:both;font-size:10px;font-style:italic;padding:5px 0; font-weight: bold">
                Market Cap: <span style="color: #78FEAB">${!! number_format($one['cmc']['market_cap_usd'],2,'.',',') !!} USD</span>
            </div>
            <div style="border-top: 1px solid #E4E6EB;text-align:center;clear:both;font-size:10px;font-style:italic;padding:5px 0; font-weight: bold">
                Last Updated: <span style="color: #4B4BBC">{!! $one['lastUpdated'] !!}</span>
            </div>
        </div>
        <div class="col-sm-2" style="text-align:center;float:left;font-size:12px;padding:12px 0;line-height:1.25em;">
            <div style="text-align:center;clear:both;font-size:14px;font-style:italic;padding:5px 0; font-weight: bold">
                ROI % <Br><br><span style="font-size: 25px; color: #FCB043">{!!  number_format($one['roi'],2,'.','') !!}%</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3" style="border-top: 1px solid #E4E6EB; text-align:center;float:left;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em; font-weight: bold">
            Total Master Nodes <br><span style="font-size: 17px; color: #FF8B41">{!! $one['totalMasterNodes'] !!}</span>
        </div>
        <div class="col-sm-3" style="border-top: 1px solid #E4E6EB;text-align:center;float:left;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em; font-weight: bold">
            Coins Locked <br><span style="font-size: 14px; color: #78FEAB">{!! number_format($one['totalMasterNodes'] * $one['masterNodeCoinsRequired'],'0','',',') !!} ({!! number_format(((($one['totalMasterNodes'] * $one['masterNodeCoinsRequired']) /  $one['coin_supply'] ) * 100),'2','.',',') !!}%)<Br></span>
        </div>
        <div class="col-sm-3" style="border-top: 1px solid #E4E6EB;text-align:center;float:left;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em; font-weight: bold">
            Required Coin's <br><span style="font-size: 17px; color: #1D82AD">{!! $one['masterNodeCoinsRequired'] !!}</span>
        </div>
        <div class="col-sm-3" style="border-top: 1px solid #E4E6EB;text-align:center;float:left;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em; font-weight: bold">
            Node Worth <br><span style="font-size: 14px; color: #78FEAB">${!! number_format($one['currentUSDPrice'] * $one['masterNodeCoinsRequired'],2,'.','') !!}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3" style="border-top: 1px solid #E4E6EB; text-align:center;float:left;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em; font-weight: bold">
            Daily <br><span style="font-size: 17px;color: #78FEAB">${!! number_format($one['income']['daily'],2,'.','') !!}</span>
        </div>
        <div class="col-sm-3" style="border-top: 1px solid #E4E6EB;text-align:center;float:left;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em; font-weight: bold">
            Weekly <br><span style="font-size: 14px; color: #78FEAB">${!! number_format($one['income']['weekly'],2,'.','') !!}</span>
        </div>
        <div class="col-sm-3" style="border-top: 1px solid #E4E6EB;text-align:center;float:left;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em; font-weight: bold">
            Monthly <br><span style="font-size: 14px; color: #78FEAB">${!! number_format($one['income']['monthly'],2,'.','') !!}</span>
        </div>
        <div class="col-sm-3" style="border-top: 1px solid #E4E6EB;text-align:center;float:left;font-size:12px;padding:12px 0;border-right:1px solid #E4E6EB;line-height:1.25em; font-weight: bold">
            Yearly <br><span style="font-size: 14px; color: #78FEAB">${!! number_format($one['income']['yearly'],2,'.','') !!}</span>
        </div>
    </div>
</div>