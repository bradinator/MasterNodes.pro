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
			$data['coinList'][$one['coin']] = json_decode(Storage::get('' . $one['coin'] . '.json'), true);
			$data['coinList'][$one['coin']]['logo'] = $one['logo'];
		}
		return view('welcome', $data);
	}

	public function coinList()
	{
		$data[0]['coin'] = 'ion';
		$data[0]['logo'] = '//ion.masternodes.pro/img/logo.png';
		$data[1]['coin'] = 'chc';
		$data[1]['logo'] = '//chc.masternodes.pro/img/logo.png';
		$data[2]['coin'] = 'pivx';
		$data[2]['logo'] = 'https://raw.githubusercontent.com/PIVX-Project/Official-PIVX-Graphics/master/digital/bottom%20tag/portrait/White/White_Port.png';
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