(function($) {
    $(document).ready(function(){
        $('.widget_weatherwidget').each(function(i, widget) {
            var current_weather = $(widget).find('.current-weather'),
                widget_city = $(current_weather).data('city'),
                widget_country = $(current_weather).data('country');

            $.post(
                wcms19_weather_settings.ajax_url, // URL
                {
                    action: 'get_current_weather',
                    city: widget_city,
                    country: widget_country,
                }, // Data to send to server
                function(data) {
                    var output = "";
                    console.log("Got response", data);
                    console.log(data.conditions);
                    
                    
                    output += '<div class="conditions">';
                    data.conditions.forEach(function(condition) {    // foreach($data->conditions as $condition)
                            output += '<img src="http://openweathermap.org/img/w/'+condition.icon+'.png" alt="'+condition.main+'" title="'+condition.description+'">';
                    });

                    output += '<strong>Temparature:</strong> ' + data.temparature + '&deg; C<br>';
                    output += '<strong>Humidity:</strong> ' + data.humidity + '%<br>'; 
                    $(current_weather).html(output);
                }
            );
        });
    });

})(jQuery);

// function ww_get_current_weather(widget_id, widget_city, widget_country) {
//     // fire some async request
//     console.log("Firing away request for widget " + widget_id + " with city: " + widget_city + " and country: " + widget_country);

//     var url = wcms19_weather_settings.ajax_url,
//         payload = {
//             action: 'get_current_weather',
//             city: widget_city,
//             country: widget_country,
//         };

//     jQuery.post(
//         url,
//         payload,
//         function(data) {
//             console.log("GOT RESPONSE for widget " + widget_id + "yaaaayyy!!" , data);
//             var output = "";
//             output += '<strong>Temparature:</strong> ' + data.temparature + '&deg; C<br>';
//             output += '<strong>Humidity:</strong> ' + data.humidity + '%<br>'; 
//             jQuery('#' + widget_id + ' .current-weather').html(output);
//         }
//     );
//     // deal with the response
// }