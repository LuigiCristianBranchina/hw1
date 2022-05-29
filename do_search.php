<?php
    if (isset($_GET['cerca']) ) {
        
        $keyword = $_GET['cerca'];
        define("MAX", 15);
        $apikey = 'AIzaSyDRa7Y7UJ2ilpdnabNBrI1RL0GTwXlT1yw'; 
        $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' 
                        . $keyword . '&maxResults=' . MAX . '&key=' . $apikey;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $googleApiUrl);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        echo $response;
    }

?>