<?php

use Vnn\Places\Client\GuzzleAdapter;
use Vnn\Places\PlaceService;

require 'vendor/autoload.php';

if(isset($_GET['input']) && !empty($_GET['input'])) 
{
    $address = $_GET['input'];
    $service = new PlaceService(new GuzzleAdapter());
    $service->setApiKey('AIzaSyALikotQ4kOr_KpOM2wmVYiYO4O1tVD0SA');

    $results = $service->search($_GET['input']);

    $location = $results[0]['geometry']['location'];

    if(!file_exists('history/history')) {

        file_put_contents('history/history', serialize(array($address)));
    } else {

        $history = unserialize(file_get_contents('history/history'));
        $history[] = $address;
        file_put_contents('history/history', serialize($history));
    }

    echo json_encode($location);
}