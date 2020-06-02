<?php
/**
    *   Plugin Name:    My Star Wars Widget
    *   Plugin URI:     https://someurl.se
    *   Description:    This plugin fetch data from SWAPI.
    *   Version:        0.1
    *   Author:         Fredrik Larsson
    *   Author URI:     https://www.data-lord.se
    *   License:        WTFPL
    *   License URI:    http://www.wtfpl.net/
    *   Text Domain:    swapiwidget
    *   Domain Path:    /languages      
**/

require("class.StarWarsWidget.php");

function wsw_widgets_init() {
	register_widget('StarWarsWidget');
}
add_action('widgets_init', 'wsw_widgets_init');