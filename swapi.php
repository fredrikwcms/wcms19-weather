<?php 
/* 
* Functions for communicating with the Star Wars API
*/

function swapi_get_url($url)    {
    $response = wp_remote_get($url);
    if(is_wp_error($response)) {
        return false;
    }

    return json_decode(wp_remote_retrieve_body($response));
}

function swapi_get($endpoint, $id = null, $expiry = 3600) {
    $transient_key = "swapi_get_$endpoint";
    if ($id)    {
        $transient_key .= "_{$id}";
    }

    $items = get_transient($transient_key);
    if(!$items) {
        if ($id)    {
            $items = swapi_get_url('https://swapi.dev/api/{$endpoint}/{$id}');
        }   else {
            $items = [];
            $url = "https://swapi.dev/api/{$endpoint}";
            while ($url)    {
                $data = swapi_get_url($url);
                if (!$data) {
                    return false;
                }
                $items = array_merge($items, $data->results);

                $url = $data->next; 
            }
        }

        // Save transient
        set_transient($transient_key, $items, $expiry);
    }
    // return items
    return $items;
}

function swapi_get_films() {
    return swapi_get('films');
}

function swapi_get_characters() {
    return swapi_get('people');
}

function swapi_get_character($id) {
    return swapi_get('people', $id);
}

// function swapi_get_films() {
//     // do we have films cached?
//     $films = get_transient('swapi_get_films');
//     if($films) {
//         // if yes, return the cached films
//         echo "We has cached films!";
//         return $films;
//     } else {
//         // otherwise retrieve the films from SWAPI

//         $result = wp_remote_get('https://swapi.dev/api/films/');
//         if(wp_remote_retrieve_response_code($result) === 200) {
//             $data = json_decode(wp_remote_retrieve_body($result));
//             $films = $data->results;
//             set_transient('swapi_get_films', $films, 60*60);

//             return $films;
//         } else {
//             return false;
//         }
//     }

// }

// function swapi_get_character($character_id) {
//     // do we have character cached?
//     $character = get_transient('swapi_get_character_' . $character_id);
//     if($character) {
//         // if yes, return the cached character
//         return $character;
//     } else {
//         // otherwise retrieve the character from SWAPI

//         $result = wp_remote_get('https://swapi.dev/api/people/' . $character_id);
//         if(wp_remote_retrieve_response_code($result) === 200) {
//             $character = json_decode(wp_remote_retrieve_body($result));
            
//             set_transient('swapi_get_character_' . $character_id, $character, 60*60);

//             return $character;
//         } else {
//             return false;
//         }
//     }

// }

// function swapi_get_characters() {
//     // do we have characters cached?
//     $characters = get_transient('swapi_get_characters');
//     if($characters) {
//         // if yes, return the cached characters
//         return $characters;
//     } else {

//         $next = null;
//         while ($next !== null) {

//         }
//         // otherwise retrieve the characters from SWAPI

//         $result = wp_remote_get('https://swapi.dev/api/people/');
//         if(wp_remote_retrieve_response_code($result) === 200) {
//             $data = json_decode(wp_remote_retrieve_body($result));
//             $characters = $data->results;
//             set_transient('swapi_get_characters', $characters, 60*60);

//             return $characters;
//         } else {
//             return false;
//         }
//     }

// }



