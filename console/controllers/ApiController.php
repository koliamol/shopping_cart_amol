<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class ApiController extends Controller
{
    public function actionTest() {
        $url = "https://fakestoreapi.com/products";
        $data = $this->getCurl($url);
        print_r($data);
        exit;
    }

    /**
     * This function will fetch data from API.
     *
     * @author Amol Koli
     * @param $url = String,
     * @return Array
     *
     */
	public function getCurl($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		//curl_setopt($curl, CURLOPT_HTTPHEADER, array("Cookie: APIC-cookie=" . $token));
		curl_setopt($curl, CURLOPT_FAILONERROR, 1);
		$result = curl_exec($curl);     
		return json_decode($result,true);
	}
}
