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
			$data['coinList'][$one['coin']]             = json_decode(Storage::get('' . $one['coin'] . '.json'), true);
			$data['coinList'][$one['coin']]['name']     = $one['name'];
			$data['coinList'][$one['coin']]['roi']      = '';
			$data['coinList'][$one['coin']]['logo']     = $one['logo'];
			$data['coinList'][$one['coin']]['donation'] = $one['donation'];
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
		$coin['name'] = 'CRAVE';
		$coin['coin'] = 'CRAVE';
		$coin['url']  = 'https://www.craveproject.com/';
		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/crave.png';
		$coins[0]     = $coin;
		$coin['name'] = 'InsaneCoin';
		$coin['coin'] = 'INSN';
		$coin['url']  = 'http://www.insanecoin.com/';
		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/insanecoin-insn.png';
		$coins[1]     = $coin;
//		$coin['name'] = 'ExclusiveCoin';
//		$coin['coin'] = 'EXCL';
//		$coin['url']  = 'http://exclusivecoin.pw/';
//		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/exclusivecoin.png';
//		$coins[2]     = $coin;
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
		$coin['name']              = 'ExclusiveCoin';
		$coin['coin']              = 'EXCL';
		$coin['url']               = 'http://exclusivecoin.pw/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/exclusivecoin.png';
		$coin['donate']['bitcoin'] = '1BBtbPQWt7eY8ZTAZKdUhTianxn8suJaNz';
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
		$coin['name']              = 'MonetaryUnit';
		$coin['coin']              = 'MUE';
		$coin['url']               = 'http://www.monetaryunit.org/';
		$coin['logo']              = 'https://files.coinmarketcap.com/static/img/coins/32x32/monetaryunit.png';
		$coin['donate']['bitcoin'] = '1HAT6Q67AvoyeofkSNhwqmRu4uezhr1vq1';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[$i]                  = $coin;
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
		$coins[$i]                  = $coin;
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
		$coins[$i]                  = $coin;
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
		$data[0]['name']                       = 'ION';
		$data[0]['coin']                       = 'ion';
		$data[0]['logo']                       = '//ion.masternodes.pro/img/logo.png';
		$data[0]['donation']['bitcoin']        = '';
		$data[0]['donation'][$data[0]['coin']] = '';
		$data[1]['name']                       = 'ChainCoin';
		$data[1]['coin']                       = 'chc';
		$data[1]['logo']                       = '//chc.masternodes.pro/img/logo.png';
		$data[1]['donation']['bitcoin']        = '';
		$data[1]['donation'][$data[1]['coin']] = '';
		$data[2]['name']                       = 'PIVX';
		$data[2]['coin']                       = 'pivx';
		$data[2]['logo']                       = 'https://raw.githubusercontent.com/PIVX-Project/Official-PIVX-Graphics/master/digital/bottom%20tag/portrait/White/White_Port.png';
		$data[2]['donation']['bitcoin']        = '';
		$data[2]['donation'][$data[2]['coin']] = '';
		$data[3]['name']                       = 'Neutron';
		$data[3]['coin']                       = 'ntrn';
		$data[3]['logo']                       = 'https://static.wixstatic.com/media/f2591a_f17f4b3fcbb74848b2bccf59bbeae490~mv2.png/v1/fill/w_708,h_520,al_c,lg_1/f2591a_f17f4b3fcbb74848b2bccf59bbeae490~mv2.png';
		$data[3]['donation']['bitcoin']        = '';
		$data[3]['donation'][$data[2]['coin']] = '';
		$data[4]['name']                       = 'ArcticCoin';
		$data[4]['coin']                       = 'arc';
		$data[4]['logo']                       = 'https://files.coinmarketcap.com/static/img/coins/32x32/arcticcoin.png';
		$data[4]['donation']['bitcoin']        = '';
		$data[4]['donation'][$data[2]['coin']] = '';
		return $data;
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