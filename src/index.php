<?php

global $HERE_APP_ID, $HERE_APP_CODE;
global $HERE_URLS;

$HERE_URLS = [
  "geocoder" => "https://geocoder.api.here.com/6.2/geocode.json?app_id={HERE_APP_ID}&app_code={HERE_APP_CODE}&searchtext=Berlin",
  "routing" => "https://route.api.here.com/routing/7.2/calculateroute.json?app_id={HERE_APP_ID}&app_code={HERE_APP_CODE}&waypoint0=52.5160%2C13.3779&waypoint1=52.5206%2C13.3862&mode=fastest%3Btruck%3Btraffic%3Aenabled",
  "maptile" => "https://1.base.maps.api.here.com/maptile/2.1/maptile/newest/normal.day/11/525/761/256/png8?app_id={HERE_APP_ID}&app_code={HERE_APP_CODE}",
  "traffictile" => "https://1.traffic.maps.api.here.com/maptile/2.1/traffictile/newest/normal.day/15/16358/10898/256/png8?app_id={HERE_APP_ID}&app_code={HERE_APP_CODE}",
  "places" => "https://places.demo.api.here.com/places/v1/suggest?app_id={HERE_APP_ID}&app_code={HERE_APP_CODE}&at=52.5159%2C13.3777&q=berlin",
];

function run() {
  get_and_set_env_variables();
 
  $result = "";
  foreach (get_here_metrics() as $metric) {
    $result .= $metric.PHP_EOL;
  }
  
  header("Content-Type: text/plain; version=0.0.4");
  echo $result;
}

// let's go
run();
exit;


function get_and_set_env_variables() {
  global $HERE_APP_ID, $HERE_APP_CODE, $HERE_URLS;

  if($app_id = getenv('HERE_APP_ID')) {
    $HERE_APP_ID = $app_id;
  }

  if($app_code = getenv('HERE_APP_CODE')) {
    $HERE_APP_CODE = $app_code;
  }

  foreach ($HERE_URLS as &$url) {
    $url = str_replace("{HERE_APP_ID}", $HERE_APP_ID, $url);
    $url = str_replace("{HERE_APP_CODE}", $HERE_APP_CODE, $url);
  }
}

function get_here_metrics() {
  global $HERE_URLS;

  $metrics = [];
  
  foreach ($HERE_URLS as $key => $url) {
    $status = 0;
    $result = file_get_contents($url);
    if($result && strpos($http_response_header[0], "200") != -1){
      $status = 1;
    }
    
    $metrics[] = "here_api_".$key."_status_check ".$status;
  }

  return $metrics;
}