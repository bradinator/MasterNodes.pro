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

		// DASH COIN
		$coin['coin'] = 'NTRN';
		$coin['url']  = 'http://www.neutroncoin.com';
		$coin['logo'] = 'https://static.wixstatic.com/media/f2591a_f17f4b3fcbb74848b2bccf59bbeae490~mv2.png/v1/fill/w_708,h_520,al_c,lg_1/f2591a_f17f4b3fcbb74848b2bccf59bbeae490~mv2.png';
		$coins[0]     = $coin;
		$coin['coin'] = 'INSN';
		$coin['url']  = 'http://www.insanecoin.com/';
		$coin['logo'] = 'https://files.coinmarketcap.com/static/img/coins/32x32/insanecoin-insn.png';
		$coins[1]     = $coin;
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
		$ticker     = json_decode($resCMCCORE->getBody()->getContents(), true);
		// DASH COIN
		$coin['coin']              = 'DASH';
		$coin['url']               = 'https://www.dash.org/';
		$coin['logo']              = '/img/dash_square_bevel_highres.png';
		$coin['donate']['bitcoin'] = '19t1VRFe5MrWCFeZFruwnPJQACdTs82ytx';
		$coin['donate']['dash']    = 'XqF2WcDgktmTKJ1j8Frn7AqkzfVWHZxykm';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[0]                  = $coin;
		$coin                      = [];
		$coin['coin']              = 'arcticcoin';
		$coin['url']               = 'https://arcticcoin.org/';
		$coin['logo']              = 'https://arcticcoin.org/main/images/logo.png';
		$coin['donate']['bitcoin'] = '1MMWFtENNefjTxch1j6X3MyCEQ2u9AhZSf';
		$coin['donate']['dash']    = 'APzt8HxZiqJCRsWJYSNFj8zXdNT4LYwDoH';
		$coin['current']           = (float)$this->getBalance($coin['donate']) * $ticker['USD']['15m'];
		$coin['need']              = 200;
		$coin['balance']           = $coin['need'] - $coin['current'];
		$coins[1]                  = $coin;
		foreach ($coins as $one) {
			$data[$one['coin']] = $one;
		}
		return $data;
	}

	public function coinList()
	{
		$data[0]['coin']                       = 'ion';
		$data[0]['logo']                       = '//ion.masternodes.pro/img/logo.png';
		$data[0]['donation']['bitcoin']        = '';
		$data[0]['donation'][$data[0]['coin']] = '';
		$data[1]['coin']                       = 'chc';
		$data[1]['logo']                       = '//chc.masternodes.pro/img/logo.png';
		$data[1]['donation']['bitcoin']        = '';
		$data[1]['donation'][$data[1]['coin']] = '';
		$data[2]['coin']                       = 'pivx';
		$data[2]['logo']                       = 'https://raw.githubusercontent.com/PIVX-Project/Official-PIVX-Graphics/master/digital/bottom%20tag/portrait/White/White_Port.png';
		$data[2]['donation']['bitcoin']        = '';
		$data[2]['donation'][$data[2]['coin']] = '';
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