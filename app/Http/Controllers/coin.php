<?php

namespace App\Http\Controllers;

use App\Blocks;
use Validator, Input, Redirect, View, Auth;
use App\Mnl;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class coin extends Controller
{

	public function index()
	{
		$data     = null;
		$coinList = $this->coinList();
		foreach ($coinList as $one) {
			if (Storage::exists('' . $one['coin'] . '.json')) {
				$data['coinList'][$one['coin']]         = json_decode(Storage::get('' . $one['coin'] . '.json'), true);
				$data['coinList'][$one['coin']]['name'] = $one['name'];
				$data['coinList'][$one['coin']]['roi']  = '';
				$data['coinList'][$one['coin']]['logo'] = $one['logo'];
			}
		}
		$data['ComingSoonCoinList'] = $this->ComingSoonCoinList();
		$data['donateCoinList']     = $this->donateCoinList();
		return view('welcome', $data);
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
		$i            = 0;
		$coin         = [];
		$coin['name'] = 'ONHOLD - InsaneCoin';
		$coin['coin'] = 'INSN';
		$coin['url']  = 'http://www.insanecoin.com/';
		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/insanecoin-insn.png';
		$coins[$i]    = $coin;
		$i++;
		foreach ($coins as $one) {
			$data[$one['coin']] = $one;
		}
		return $data;
	}

	public function donateCoinList()
	{
		$client     = new Client();
		$resCMCCORE = $client->request(
			'GET', 'https://blockchain.info/ticker'
		);
		$i          = 0;
		$ticker     = json_decode($resCMCCORE->getBody()->getContents(), true);
		// DASH COIN

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
		$coin['name']              = 'Syndicate';
		$coin['coin']              = 'SYNX';
		$coin['url']               = 'http://syndicatelabs.io/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/syndicate.png';
		$coin['donate']['bitcoin'] = '1GAo1oEAnYMUQtjxSu25gbHEhV8Z8M5ESL';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                 = $coin;
		$i++;
		$coin                      = [];
		$coin['name']              = 'Bitsend';
		$coin['coin']              = 'BSD';
		$coin['url']               = 'http://www.bitsend.info/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/bitsend.png';
		$coin['donate']['bitcoin'] = '1bWa8gb8ZUf2Q22VXz9UkmfUxtHRZbCWC';
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
		$coin['name']              = 'Renos';
		$coin['coin']              = 'RNS';
		$coin['url']               = 'https://renoscoin.com/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/renos.png';
		$coin['donate']['bitcoin'] = '1GSKz7Z7Lbj97JkksLuK2mT2KiATZsNsdn';
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
		$coin['name']              = 'sib';
		$coin['coin']              = 'CRW';
		$coin['url']               = 'http://crown.tech/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/crown.png';
		$coin['donate']['bitcoin'] = '18sSYRUGw5FFpiAExqgBWtSLojvw4KdNYR';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
//		$coins[$i]                  = $coin;
//		$i++;
		$coin                      = [];
		$coin['name']              = 'hyperstake';
		$coin['coin']              = 'hyp';
		$coin['url']               = 'http://crown.tech/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/crown.png';
		$coin['donate']['bitcoin'] = '18sSYRUGw5FFpiAExqgBWtSLojvw4KdNYR';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
//		$coins[$i]                  = $coin;
//		$i++;
		$coin                      = [];
		$coin['name']              = 'HoboNickels';
		$coin['coin']              = 'HBN';
		$coin['url']               = 'http://crown.tech/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/crown.png';
		$coin['donate']['bitcoin'] = '18sSYRUGw5FFpiAExqgBWtSLojvw4KdNYR';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
//		$coins[$i]                  = $coin;
//		$i++;
		$coin                      = [];
		$coin['name']              = 'CreditBit';
		$coin['coin']              = 'CRB';
		$coin['url']               = 'http://crown.tech/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/crown.png';
		$coin['donate']['bitcoin'] = '18sSYRUGw5FFpiAExqgBWtSLojvw4KdNYR';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
//		$coins[$i]                  = $coin;
//		$i++;
		$coin                      = [];
		$coin['name']              = 'DASH';
		$coin['coin']              = 'DASH';
		$coin['url']               = 'https://www.dash.org/';
		$coin['logo']              = '/img/dash_square_bevel_highres.png';
		$coin['donate']['bitcoin'] = '19t1VRFe5MrWCFeZFruwnPJQACdTs82ytx';
		$coin['donate']['dash']    = 'XqF2WcDgktmTKJ1j8Frn7AqkzfVWHZxykm';
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
		$i            = 0;
		$coin['name'] = 'ION';
		$coin['coin'] = 'ion';
		$coin['logo'] = '//ion.masternodes.pro/img/logo.png';
		$coins[$i]    = $coin;
		$i++;
		$coin['name'] = 'ChainCoin';
		$coin['coin'] = 'chc';
		$coin['logo'] = '//chc.masternodes.pro/img/logo.png';
		$coins[$i]    = $coin;
		$i++;
		$coin['name'] = 'PIVX';
		$coin['coin'] = 'pivx';
		$coin['logo'] = 'https://raw.githubusercontent.com/PIVX-Project/Official-PIVX-Graphics/master/digital/bottom%20tag/portrait/White/White_Port.png';
		$coins[$i]    = $coin;
		$i++;
		$coin['name'] = 'Neutron';
		$coin['coin'] = 'ntrn';
		$coin['logo'] = 'https://static.wixstatic.com/media/f2591a_f17f4b3fcbb74848b2bccf59bbeae490~mv2.png/v1/fill/w_708,h_520,al_c,lg_1/f2591a_f17f4b3fcbb74848b2bccf59bbeae490~mv2.png';
		$coins[$i]    = $coin;
		$i++;
		$coin['name'] = 'ArcticCoin';
		$coin['coin'] = 'arc';
		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/arcticcoin.png';
		$coins[$i]    = $coin;
		$i++;
		$coin['name'] = 'CRAVE';
		$coin['coin'] = 'crave';
		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/crave.png';
		$coins[$i]    = $coin;
		$i++;
		$coin['name'] = 'MonetaryUnit';
		$coin['coin'] = 'MUE';
		$coin['url']  = 'http://www.monetaryunit.org/';
		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/monetaryunit.png';
		$coins[$i]    = $coin;
		$i++;
		$coin['name'] = 'ExclusiveCoin';
		$coin['coin'] = 'EXCL';
		$coin['url']  = 'http://exclusivecoin.pw/';
		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/exclusivecoin.png';
		$coins[$i]    = $coin;
		$i++;

		return $coins;
	}

	public function callCoinAPIS()
	{
		$coinList = $this->coinList();
		foreach ($coinList as $one) {
			$this->coinApi($one['coin']);
		}
	}

	public function coinApi($name)
	{
		$client  = new Client();
		$res     = $client->request(
			'GET', 'http://' . $name . '.masternodes.pro/api/datapack'
		);
		$content = $res->getBody();
		echo '<pre>' . $content . '</pre>';
		Storage::put('' . $name . '.json', $content);
	}
}