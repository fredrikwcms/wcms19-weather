<?php
/**
    *   Plugin Name:    My Weather Widget
    *   Plugin URI:     https://someurl.se
    *   Description:    This plugin fetch weather data from OpenWeatherMap.
    *   Version:        0.1
    *   Author:         Fredrik Larsson
    *   Author URI:     https://www.data-lord.se
    *   License:        WTFPL
    *   License URI:    http://www.wtfpl.net/
    *   Text Domain:    weatherwidget
    *   Domain Path:    /languages      
**/
require("inc/openweathermap.php");
require("inc/class.WeatherWidget.php");

function ww_widgets_init() {
	register_widget('WeatherWidget');
}
add_action('widgets_init', 'ww_widgets_init');

function ww_enqueue_styles() {
    wp_enqueue_style('wcms19-weather', plugin_dir_url(__FILE__) . 'assets/css/wcms19-weather.css');

    wp_enqueue_script('wcms19-weather', plugin_dir_url(__FILE__) . 'assets/js/wcms19-weather.js', ['jquery'], false, true);
    wp_localize_script('wcms19-weather', 'wcms19_weather_settings', [
        'ajax_url'  => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'ww_enqueue_styles');

/* 
* Respond to AJAX request for 'get_current_weather'
*/

function ww_ajax_get_current_weather() {
    $current_weather = owm_get_current_weather($_POST['city'], $_POST['country']);
    // Send the data our PHP code gets from OWM API
    wp_send_json($current_weather);
}
// Expose data to logged in users
add_action('wp_ajax_get_current_weather', 'ww_ajax_get_current_weather');
// Expose data to all users
add_action('wp_ajax_nopriv_get_current_weather', 'ww_ajax_get_current_weather');