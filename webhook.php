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
                    //天気情報取得
                    $fourcast = getWeather_jma();
                    $date =  phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("th.weather:eq(0)")->text();
                    $img = phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("th.weather:eq(0)")->find("img");
                    //echo phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.area:eq(0)")->text();
                    //echo phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.area:eq(0)")->find("img");
                    //echo phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.rain:eq(0)")->text();
                    //echo phpQuery::newDocument($fourcast)->find("#base")->find("#main")->find("div")->find("#forecasttablefont")->find("td.temp:eq(0)")->text();
                    //$date = $fourcast['forecasts'][0]["date"];
                    //$telop = $fourcast['forecasts'][0]["telop"];
                    //$max = $fourcast['forecasts'][0]["temperature"]["max"]["celsius"];
                    //$min = $fourcast['forecasts'][0]["temperature"]["min"]["celsius"];

                    //$text = $date." 埼玉の天気"."\n予報： ".$text."\n"."最高気温：".$max."\n"."最低気温：".$min;
                    $text = $date." 埼玉の天気"."\n予報： ";
                    
                    $client->replyMessage([
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
                                'type' => 'text',
                                'text' => $text
                            ],
                            [
                                'type' => 'image',
                                'originalContentUrl' => $img,
                                'previewImageUrl' => $img
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
