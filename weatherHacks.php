<?php
    function getWeather_forecast(){
      //API については http://weather.livedoor.com/weather_hacks/webservice
      $url = "http://weather.livedoor.com/forecast/webservice/json/v1?city=110010";
      //$json = file_get_contents($url, true);//セキュリティが厳しいと、使用できない
      $data = array();
      $conn = curl_init();
      curl_setopt($conn, CURLOPT_URL, $url);//　取得するURLを指定
      curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);// 実行結果を文字列で返す
      $result = curl_exec($conn);
      curl_close($conn);
      $json = json_decode($result, true);
      return $json;
    }
    function getWeather_jma($url){
      $data = array();
      $conn = curl_init();
      curl_setopt($conn, CURLOPT_URL, $url);//　取得するURLを指定
      curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);// 実行結果を文字列で返す
      return curl_exec($conn);
    }
    /* 以降、データの取得例
    // Pubric
    $title = $json['title'];
    $description = $json['description']['text'];
    $publicTime = $json['publicTime'];
 
    // Location
    $city = $json['location']['city'];
    $area = $json['location']['area'];
    $prefecture = $json['location']['prefecture'];
    $link = $json['link'];

    // forecasts
    $date = $json['forecasts'][0]['date'];
    $telop = $json['forecasts'][0]['telop'];
    $weatherImg = $json['forecasts'][0]['image']['url'];
    $maxTmp = $json['forecasts'][0]['temperture']['max']["celsius"];
    $minTmp = $json['forecasts'][0]['temperture']['min']["celsius"];
    */
  ?>