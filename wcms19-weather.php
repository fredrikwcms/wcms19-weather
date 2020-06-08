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