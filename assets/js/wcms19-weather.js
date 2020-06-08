(function($) {
    $(document).ready(function(){
        // fire some async request
        console.log("Firing away request");

        $.post(
            
            my_ajax_obj.ajax_url, // URL
            {
                // Call our PHP function that fetches weather data
                action: 'get_current_weather'
            },
            function(response) {
                console.log("GOT RESPONSE", response);
            }
        )
        // deal with the response
    });
})(jQuery);