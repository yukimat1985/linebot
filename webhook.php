<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');
require_once('./weatherHacks.php');
require_once('./phpQuery-onefile.php');

$channelAccessToken = 'JIQtnC9LfeWRyRrtZbxAnYFqr6Px5iri1aBgxsroj5Q9l5UKHlaq5wkE4I6AWLW20ohg6as1DNI5R2MqifUKJ/GaA+qVqXXJK5ckGu73rUV0p9QvL6Qa54L7e8ALC+3Iue06VXO1eUHpEFX7z8tR/AdB04t89/1O/w1cDnyilFU=';
$channelSecret = '256da576e92f872af619cda5f60a5019';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    //$fourcast = "ss";
                    /*
                    switch($message['text']){
                        case '札幌':
                            $fourcast = getWeather_jma('https://www.jma.go.jp/jp/yoho/306.html');
                            break;
                        case '東京':
                            $fourcast = getWeather_jma('https://www.jma.go.jp/jp/yoho/319.html');
                            break;
                        case '大阪':
                            $fourcast = getWeather_jma('https://www.jma.go.jp/jp/yoho/331.html');
                            break;
                        case '名古屋':
                            $fourcast = getWeather_jma('https://www.jma.go.jp/jp/yoho/329.html');
                            break;
                        case '福岡':
                            $fourcast = getWeather_jma('https://www.jma.go.jp/jp/yoho/346.html');
                            break;
                        case '沖縄':
                            $fourcast = getWeather_jma('https://www.jma.go.jp/jp/yoho/353.html');
                            break;
                    }*/
                    //if($fourcast !== ""){
                        $fourcast = getWeather_jma('https://www.jma.go.jp/jp/yoho/319.html');
                        $today_date = phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("th.weather:eq(0)")->text();
                        $today_img = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("th.weather:eq(0)")->find("img")->attr("title");
                        $today_rain = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.rain:eq(0)")->text();
                        $today_temp = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.temp:eq(0)")->text();
                        $today_text = $date." の天気"."\n予報： ".$today_img."\n降水確率: ".$today_rain."\n気温: ".$today_temp;

                        $tomorrow_date = phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("th.weather:eq(1)")->text();
                        $tomorrow_img = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("th.weather:eq(1)")->find("img")->attr("title");
                        $tomorrow_rain = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.rain:eq(1)")->text();
                        $tomorrow_temp = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.temp:eq(1)")->text();
                        $tomorrow_text = $tomorrow_date." の天気"."\n予報： ".$tomorrow_img."\n降水確率: ".$tomorrow_rain."\n気温: ".$tomorrow_temp;

                        $day_after_tomorrow_date = phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("th.weather:eq(2)")->text();
                        $day_after_tomorrow_img = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("th.weather:eq(2)")->find("img")->attr("title");
                        $day_after_tomorrow_rain = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.rain:eq(2)")->text();
                        $day_after_tomorrow_temp = phpQuery::newDocument($html)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.temp:eq(2)")->text();
                        $day_after_tomorrow_text = $day_after_tomorrow_date." の天気"."\n予報： ".$day_after_tomorrow_img."\n降水確率: ".$day_after_tomorrow_rain."\n気温: ".$day_after_tomorrow_temp;
                    //}else{
                    //    $today_text = 'それはアカーーーン';
                    //}
                    $client->replyMessage([
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
                                'type' => 'text',
                                'text' => $today_text
                            ],
                            [
                                'type' => 'text',
                                'text' => $tomorrow_text
                            ],
                            [
                                'type' => 'text',
                                'text' => $day_after_tomorrow_text
                            ]
                        ]
                    ]);
                    break;
                default:
                    error_log('Unsupported message type: ' . $message['type']);
                    break;
            }
            break;
        default:
            error_log('Unsupported event type: ' . $event['type']);
            break;
    }
};

