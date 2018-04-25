<?php

/**
 * To create new API calls, you have to instanciate the API controller and start adding endpoints
*/
$api = new \WPAS\Controller\WPASAPIController([ 
    'version' => '1', 
    'application_name' => 'sample_api', 
    'namespace' => 'Rigo\\Controller\\', 
    'allow-origin' => '*',
    'allow-methods' => 'GET, POST, PUT'
]);


/**
 * Then you can start adding each endpoint one by one
 * https://try-wordpreess-michelle19.c9users.io/wp-json/sample_api/v1/ use this url
*/
$api->get([ 'path' => '/courses', 'controller' => 'SampleController:getDraftCourses' ]); 
$api->get([ 'path' => '/meetups', 'controller' => 'MeetupController:getMeetups' ]); 
$api->get([ 'path' => '/events', 'controller' => 'EventController:getEvents' ]); 
$api->get([ 'path' => '/creates', 'controller' => 'CreateController:getCreates' ]); 

$api->put([ 'path' => '/events/rsvp/(?P<id>[\d]+)', 'controller' => 'EventController:registerRSVP' ]); 

// $api->put([ 'path' => '/events/rsvp/(?P<id>[\d]+)', 'controller' => 'EventController:yesRSVP' ]); 

// $api->put([ 'path' => '/events/rsvp/(?P<id>[\d]+)', 'controller' => 'EventController:noRSVP' ]); 
