<?php 
/* 
* Functions for communicating with the Open Weather Map API
*/

function owm_get_current_weather($city, $country) {
    // 1. Get current weather from OWM
    $response = wp_remote_get("http://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&units=metric&appid=9565a0e98f4a0f0c39f1a3f2c98bf8cb");
    // 2. Make sure it's a valid response
    if (is_wp_error($response)) {
        return false;
    }
    // 3. Parse response and pick out the data we need
    $data = json_decode(wp_remote_retrieve_body($response));
    
    // 4. Return chosen data to caller
    $current_weather = [];
    $current_weather['temparature'] = $data->main->temp;
    $current_weather['humidity'] = $data->main->humidity;
    $current_weather['city'] = $data->name;
    $current_weather['country'] = $data->sys->country;
    $current_weather['conditions'] = $data->weather;
    
    return $current_weather;
}