<?php

namespace App\Http\Controllers;

use App\Blocks;
use Validator, Input, Redirect, View, Auth;
use App\Mnl;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class coin extends Controller
{
	public static $sort = 'roi';

	public function index()
	{
		$data     = null;
		$type     = isset($_GET['sort']) ? $_GET['sort'] : 'roi';
		$view     = isset($_GET['view']) ? $_GET['view'] : 'grid';
		$sort     = 'roi';
		$coinList = $this->coinList();
		foreach ($coinList as $one) {
			if (Storage::exists('' . strtolower($one['coin']) . '.json')) {
				$coinData                                             = json_decode(Storage::get('' . strtolower($one['coin']) . '.json'), true);
				$data['coinList'][$one['coin']]                       = $coinData;
				$CMC                                                  = json_decode(Storage::get('' . strtolower($one['coin']) . '-CMC.json'), true);
				$data['coinList'][$one['coin']]['cmc']                = $CMC;
				$data['coinList'][$one['coin']]['market_cap']         = $CMC['market_cap_usd'];
				$data['coinList'][$one['coin']]['coin_supply']        = $CMC['available_supply'];
				$data['coinList'][$one['coin']]['percent_change_24h'] = $CMC['percent_change_24h'];
				$data['coinList'][$one['coin']]['coinLocked']         = $coinData['totalMasterNodes'] * $coinData['masterNodeCoinsRequired'];
				$data['coinList'][$one['coin']]['dailyRev']           = $coinData['income']['daily'];
				$data['coinList'][$one['coin']]['weeklyRev']          = $coinData['income']['weekly'];
				$data['coinList'][$one['coin']]['monthlyRev']         = $coinData['income']['monthly'];
				$data['coinList'][$one['coin']]['yearlyRev']          = $coinData['income']['yearly'];
				$data['coinList'][$one['coin']]['coin']               = $one['coin'];
				$data['coinList'][$one['coin']]['name']               = $one['name'];
				$data['coinList'][$one['coin']]['roi']                = $coinData['income']['yearly'] / number_format($coinData['currentUSDPrice'] * $coinData['masterNodeCoinsRequired'], 2, '.', '') * 100;
				$data['coinList'][$one['coin']]['logo']               = $one['logo'];
				if (isset($one['ads'])) {
					$data['coinList'][$one['coin']]['ads'] = $one['ads'];
					$data['coinList'][$one['coin']]['url'] = $one['url'];
				}
			}
		}
		if ($type === 'roi') $sort = 'roi';
		if ($type === 'marketCap') $sort = 'market_cap';
		if ($type === 'coinSupply') $sort = 'coin_supply';
		if ($type === 'totalMasterNodes') $sort = 'totalMasterNodes';
		if ($type === 'coinsLocked') $sort = 'coinLocked';
		if ($type === 'dailyRev') $sort = 'dailyRev';
		if ($type === 'weeklyRev') $sort = 'weeklyRev';
		if ($type === 'monthlyRev') $sort = 'monthlyRev';
		if ($type === 'yearlyRev') $sort = 'yearlyRev';
		usort(
			$data['coinList'], function ($a, $b) use ($sort) {
			return $a[$sort] < $b[$sort];
		}
		);
		$data['clselect']           = $type;
		$data['clview']             = $view;
		$data['ComingSoonCoinList'] = $this->ComingSoonCoinList();
		$data['donateCoinList']     = $this->donateCoinList();
		usort(
			$data['donateCoinList'], function ($a, $b) {
			return $a['balance'] > $b['balance'];
		}
		);
		return view('welcome', $data);
	}

	public function active()
	{
		$data     = null;
		$coinList = $this->coinList();
		foreach ($coinList as $one) {
			if (Storage::exists('' . strtolower($one['coin']) . '.json')) {
				$coinData                               = json_decode(Storage::get('' . strtolower($one['coin']) . '.json'), true);
				$data['coinList'][$one['coin']]         = $coinData;
				$data['coinList'][$one['coin']]['cmc']  = json_decode(Storage::get('' . strtolower($one['coin']) . '-CMC.json'), true);
				$data['coinList'][$one['coin']]['coin'] = $one['coin'];
				$data['coinList'][$one['coin']]['name'] = $one['name'];
				$data['coinList'][$one['coin']]['roi']  = $coinData['income']['yearly'] / number_format($coinData['currentUSDPrice'] * $coinData['masterNodeCoinsRequired'], 2, '.', '') * 100;
				$data['coinList'][$one['coin']]['logo'] = $one['logo'];
			}
		}
		usort(
			$data['coinList'], function ($a, $b) {
			return $a['roi'] < $b['roi'];
		}
		);
		return view('active', $data);
	}

	public function activeCoin($coin)
	{
		$data     = null;
		$coinList = $this->coinList();
		foreach ($coinList as $one) {
			if (Storage::exists('' . $one['coin'] . '.json')) {
				$coinData                               = json_decode(Storage::get('' . strtolower($one['coin']) . '.json'), true);
				$data['coinList'][$one['coin']]         = $coinData;
				$data['coinList'][$one['coin']]['coin'] = $one['coin'];
				$data['coinList'][$one['coin']]['name'] = $one['name'];
				$data['coinList'][$one['coin']]['roi']  = $coinData['income']['yearly'] / number_format($coinData['currentUSDPrice'] * $coinData['masterNodeCoinsRequired'], 2, '.', '') * 100;
				$data['coinList'][$one['coin']]['logo'] = $one['logo'];
			}
		}
		$data     = null;
		$coinList = $this->coinList();
		foreach ($coinList as $value) {
			if (strtolower($value['coin']) === strtolower($coin) || strtolower($value['name']) === strtolower($coin)) {
				$one                 = json_decode(Storage::get('' . strtolower($value['coin']) . '.json'), true);
				$one['coin']         = $value['coin'];
				$one['name']         = $value['name'];
				$one['roi']          = ($one['income']['yearly'] / number_format($one['currentUSDPrice'] * $one['masterNodeCoinsRequired'], 2, '.', '')) * 100;
				$one['logo']         = $value['logo'];
				$data['coinList'][0] = $one;
			}
		}
		return view('active', $data);
	}

	public function soon()
	{
		$data = null;

		$data['ComingSoonCoinList'] = $this->ComingSoonCoinList();
		return view('soon', $data);
	}

	public function soonCoin($coin)
	{
		$data     = null;
		$coinList = $this->ComingSoonCoinList();
		foreach ($coinList as $value) {
			if (strtolower($value['coin']) === strtolower($coin)) {
				$data['ComingSoonCoinList'][0] = $value;
			}
			if (strtolower($value['name']) === strtolower($coin)) {
				$data['ComingSoonCoinList'][0] = $value;
			}
		}
		return view('soon', $data);
	}

	public function donate()
	{
		$data                   = null;
		$data['donateCoinList'] = $this->donateCoinList();
		usort(
			$data['donateCoinList'], function ($a, $b) {
			return $a['balance'] > $b['balance'];
		}
		);
		return view('donate', $data);
	}

	public function donateCoin($coin)
	{
		$data     = null;
		$coinList = $this->donateCoinList();
		foreach ($coinList as $value) {
			if (strtolower($value['coin']) === strtolower($coin)) {
				$data['donateCoinList'][0] = $value;
			}
			if (strtolower($value['name']) === strtolower($coin)) {
				$data['donateCoinList'][0] = $value;
			}
		}
		return view('donate', $data);
	}

	public function getBalance($donate)
	{
		$client = new Client();
		$total  = 0;
		foreach ($donate as $key => $value) {
			if ($key === 'bitcoin') {
				$res        = $client->request(
					'GET', 'https://blockchain.info/q/getreceivedbyaddress/' . $value
				);
				$contentCMC = (float)$res->getBody()->getContents();
				$total      = $total + ($contentCMC / 100000000);
			} elseif ($key === 'arcticcoin') {
			} else {
				$url       = 'http://chainz.cryptoid.info/' . $key . '/api.dws?q=ticker.btc';
				$res       = $client->request(
					'GET', $url
				);
				$tickerBTC = (float)$res->getBody()->getContents();
				$url       = 'http://chainz.cryptoid.info/' . $key . '/api.dws?q=getreceivedbyaddress&a=' . $value;
				$res       = $client->request(
					'GET', $url
				);
				$cointotal = (float)$res->getBody()->getContents();
				$coin2btc  = number_format($cointotal * $tickerBTC, '8', '.', '');
				$total     = $total + $coin2btc;
			}
		}
		return $total;
	}

	public function ComingSoonCoinList()
	{
		$i             = 0;
		$coin          = [];
		$coin['name']  = 'Braincoin';
		$coin['coin']  = 'BRAIN';
		$coin['url']   = 'https://cryptocointalk.com/topic/46137-braincoin-info-powpossoon';
		$coin['logo']  = 'https://files.coinmarketcap.com/static/img/coins/32x32/braincoin.png';
		$coin['notes'] = 'Spinning up Servers';
		$coins[$i]     = $coin;
		$i++;
		$coin          = [];
		$coin['name']  = 'InsaneCoin';
		$coin['coin']  = 'INSN';
		$coin['notes'] = 'ONHOLD Per request from CoinDev';
		$coin['url']   = 'http://www.insanecoin.com/';
		$coin['logo']  = 'https://files.coinmarketcap.com/static/img/coins/32x32/insanecoin-insn.png';
		$coins[$i]     = $coin;
		$i++;
		$coin          = [];
		$coin['name']  = 'Wagerr';
		$coin['coin']  = 'wgr';
		$coin['notes'] = 'ONHOLD Per request from CoinDev';
		$coin['url']   = 'http://www.wagerr.com/';
		$coin['logo']  = '/img/wager.png';
		$coins[$i]     = $coin;
		$i++;
		foreach ($coins as $one) {
			$data[$one['coin']] = $one;
		}
		return $data;
	}

	public function donateCoinList()
	{
		$client                    = new Client();
		$resCMCCORE                = $client->request(
			'GET', 'https://blockchain.info/ticker'
		);
		$i                         = 0;
		$ticker                    = json_decode($resCMCCORE->getBody()->getContents(), true);
		$coin                      = [];
		$coin['name']              = 'SIBCoin';
		$coin['coin']              = 'SIB';
		$coin['url']               = 'http://sibcoin.org/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/sibcoin.png';
		$coin['donate']['bitcoin'] = '17hJgRmBgx9tVoDW7nC42LYS7MY1D1Jva1';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		$coin                      = [];
		$coin['name']              = 'Crown';
		$coin['coin']              = 'CRW';
		$coin['url']               = 'http://crown.tech/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/crown.png';
		$coin['donate']['bitcoin'] = '18sSYRUGw5FFpiAExqgBWtSLojvw4KdNYR';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		$coin                      = [];
		$coin['name']              = 'TransferCoin';
		$coin['coin']              = 'TX';
		$coin['url']               = 'http://txproject.io/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/transfercoin.png';
		$coin['donate']['bitcoin'] = '147jcyRuHY1HLZgfPdJngmA6CToHuuMBgG';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		$coin                      = [];
		$coin['name']              = '8Bit';
		$coin['coin']              = '8bit';
		$coin['url']               = 'http://www.8-bit.ga/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/8bit.png';
		$coin['donate']['bitcoin'] = '17oi1eAEak2PgADLUKKUDvPrvynxXsSgXE';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		$coin                      = [];
		$coin['name']              = 'Coinonat';
		$coin['coin']              = 'cxt';
		$coin['url']               = 'http://www.coinonat.org/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/coinonat.png';
		$coin['donate']['bitcoin'] = '1G5CU8gwJjnbmXGEfER7DGmwgD92HUTE8';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		$coin                      = [];
		$coin['name']              = 'TerraCoin';
		$coin['coin']              = 'trc';
		$coin['url']               = 'http://www.terracoin.info/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/terracoin.png';
		$coin['donate']['bitcoin'] = '1CPn3XRkb63Tzm2s7Pjiw29PpKujzWpEZP';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		$coin                      = [];
		$coin['name']              = 'DAS';
		$coin['coin']              = 'DAS';
		$coin['url']               = 'https://bitcointalk.org/index.php?topic=1988059';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/das.png';
		$coin['donate']['bitcoin'] = '1ACMA6FPH8QuJ9JWbvUyWinFXUMHrL87wf';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		$coin                      = [];
		$coin['name']              = 'Flaxscript';
		$coin['coin']              = 'flax';
		$coin['url']               = 'http://flaxscript.org/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/flaxscript.png';
		$coin['donate']['bitcoin'] = '1MbgeUWehUo1Woatk95byPc177p7SwKkvu';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		foreach ($coins as $one) {
			$data[$one['coin']] = $one;
		}
		return $data;
	}

	public function coinList()
	{
		$i               = 0;
		$coin            = [];
		$coin['name']    = 'ION';
		$coin['coin']    = 'ion';
		$coin['tagable'] = true;
		$coin['logo']    = '//ion.masternodes.pro/img/logo.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'Renos';
		$coin['coin']    = 'RNS';
		$coin['tagable'] = false;
		$ads['start']    = '07/27/2017';
		$ads['end']      = '08/28/2017';
		$ads['cost']     = '5000RNS';
		$ads['location'] = 'top';
		$ads['type']     = 'list';
		$coin['ads']     = $ads;
		$coin['url']     = 'https://renoscoin.com/?track=MNP';
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/renos.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'ChainCoin';
		$coin['coin']    = 'chc';
		$coin['tagable'] = false;
		$coin['logo']    = '//chc.masternodes.pro/img/logo.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'PIVX';
		$coin['coin']    = 'pivx';
		$coin['tagable'] = false;
		$coin['logo']    = 'https://raw.githubusercontent.com/PIVX-Project/Official-PIVX-Graphics/master/digital/bottom%20tag/portrait/White/White_Port.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'Neutron';
		$coin['coin']    = 'ntrn';
		$coin['tagable'] = false;
		$coin['logo']    = 'https://static.wixstatic.com/media/f2591a_f17f4b3fcbb74848b2bccf59bbeae490~mv2.png/v1/fill/w_708,h_520,al_c,lg_1/f2591a_f17f4b3fcbb74848b2bccf59bbeae490~mv2.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'ArcticCoin';
		$coin['coin']    = 'arc';
		$coin['tagable'] = false;
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/arcticcoin.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'CRAVE';
		$coin['coin']    = 'crave';
		$coin['tagable'] = false;
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/crave.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'MonetaryUnit';
		$coin['coin']    = 'MUE';
		$coin['tagable'] = false;
		$coin['url']     = 'http://www.monetaryunit.org/';
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/monetaryunit.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'ExclusiveCoin';
		$coin['coin']    = 'EXCL';
		$coin['tagable'] = false;
		$coin['url']     = 'http://exclusivecoin.pw/';
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/exclusivecoin.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'DASH';
		$coin['coin']    = 'DASH';
		$coin['tagable'] = false;
		$coin['url']     = 'https://www.dash.org/';
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/dash.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'Syndicate';
		$coin['coin']    = 'SYNX';
		$coin['tagable'] = false;
		$coin['url']     = 'http://syndicatelabs.io/';
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/syndicate.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'Eternity';
		$coin['coin']    = 'ent';
		$coin['tagable'] = false;
		$coin['url']     = 'http://ent.eternity-group.org/';
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/eternity.png';
		$coins[$i]       = $coin;
		$i++;
		$coin            = [];
		$coin['name']    = 'Bitsend';
		$coin['coin']    = 'bsd';
		$coin['tagable'] = false;
		$coin['url']     = 'http://www.bitsend.info/';
		$coin['logo']    = 'https://files.coinmarketcap.com/static/img/coins/32x32/bitsend.png';
		$coins[$i]       = $coin;
		$i++;

		return $coins;
	}

	public function callCoinAPIS()
	{
		$this->CallCoinMarketCap();
		$coinList = $this->coinList();
		foreach ($coinList as $one) {
			$this->coinApi($one['coin']);
		}
	}

	public function coinApi($name)
	{
		$client  = new Client();
		$res     = $client->request(
			'GET', 'http://' . strtolower($name) . '.masternodes.pro/api/datapack'
		);
		$content = $res->getBody();
		echo '<pre>' . $content . '</pre>';
		Storage::put('' . strtolower($name) . '.json', $content);
	}

	public function GetPrice($coin)
	{
		return Storage::get('' . strtolower($coin) . '-CMC.json');
	}

	public function CallCoinMarketCap()
	{
		$client     = new Client();
		$resCMCCORE = $client->request(
			'GET', 'https://api.coinmarketcap.com/v1/ticker/'
		);
		$contentCMC = $resCMCCORE->getBody();
		$CORE       = json_decode($contentCMC, true);
		$resCMCCORE = $client->request(
			'GET', 'https://api.coinmarketcap.com/v1/ticker/?convert=GBP'
		);
		$contentCMC = $resCMCCORE->getBody();
		$GBP        = json_decode($contentCMC, true);
		$resCMCCORE = $client->request(
			'GET', 'https://api.coinmarketcap.com/v1/ticker/?convert=AUD'
		);
		$contentCMC = $resCMCCORE->getBody();
		$AUD        = json_decode($contentCMC, true);
		$resCMCCORE = $client->request(
			'GET', 'https://api.coinmarketcap.com/v1/ticker/?convert=CAD'
		);
		$contentCMC = $resCMCCORE->getBody();
		$CAD        = json_decode($contentCMC, true);
		$resCMCCORE = $client->request(
			'GET', 'https://api.coinmarketcap.com/v1/ticker/?convert=CNY'
		);
		$contentCMC = $resCMCCORE->getBody();
		$CNY        = json_decode($contentCMC, true);
		$resCMCCORE = $client->request(
			'GET', 'https://api.coinmarketcap.com/v1/ticker/?convert=RUB'
		);
		$contentCMC = $resCMCCORE->getBody();
		$RUB        = json_decode($contentCMC, true);

		$coinList           = $this->coinList();
		$ComingSoonCoinList = $this->ComingSoonCoinList();
		$NewCore            = [];
		foreach ($CORE as $key => $coin) {
			foreach ($GBP as $ALTcoin) {
				if ($ALTcoin['symbol'] === $coin['symbol']) {
					$coin['price_gbp'] = $ALTcoin['price_gbp'];
				}
			}
			foreach ($AUD as $ALTcoin) {
				if ($ALTcoin['symbol'] === $coin['symbol']) {
					$coin['price_aud'] = $ALTcoin['price_aud'];
				}
			}
			foreach ($CAD as $ALTcoin) {
				if ($ALTcoin['symbol'] === $coin['symbol']) {
					$coin['price_cad'] = $ALTcoin['price_cad'];
				}
			}
			foreach ($CNY as $ALTcoin) {
				if ($ALTcoin['symbol'] === $coin['symbol']) {
					$coin['price_cny'] = $ALTcoin['price_cny'];
				}
			}
			foreach ($RUB as $ALTcoin) {
				if ($ALTcoin['symbol'] === $coin['symbol']) {
					$coin['price_rub'] = $ALTcoin['price_rub'];
				}
			}
			foreach ($coinList as $one) {
				if (strtoupper($coin['name']) === strtoupper($one['name'])) {
					$NewCore[] = $coin;
					Storage::put('' . strtolower($one['coin']) . '-CMC.json', json_encode($coin));
				}
			}
			foreach ($ComingSoonCoinList as $one) {
				if (strtoupper($coin['name']) === strtoupper($one['name'])) {
					$NewCore[] = $coin;
					Storage::put('' . strtolower($one['coin']) . '-CMC.json', json_encode($coin));
				}
			}
		}
		$Data = $NewCore;
		return "<pre>" . json_encode($Data, JSON_PRETTY_PRINT) . "</pre>";
	}


}