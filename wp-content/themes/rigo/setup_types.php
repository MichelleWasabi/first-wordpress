<?php

/**
 * To create new Post Types, you have to instanciate the PostTypesManager
*/
$typeManager = new \WPAS\Types\PostTypesManager([ 'namespace' => 'Rigo\\Types\\' ]);

/**
 * Then, start adding your types one by one.
*/
$typeManager->newType([
    'type' => 'course',
    'class' => 'Course'
    ])->register();
    
    $typeManager->newType([
    'type' => 'meetup',
    'class' => 'Meetup',
    'options'=> array(
        'supports' => array(
            'title', 'editor', 'thumbnail'
            )
        )
    ])->register();
    
// $typeManager->newType([
//     'type' => 'meetup',
//     'class' => 'Meetup',
//     'options'=> array(
//         'labels' => array(
//             'name' => 'Meetup',
//             'add_new' => 'Add New Meetup')
//             )
//     ])->register();
    
$typeManager->newType([
    'type' => 'event', 
    'class' => 'Event',
    'options'=> array(
        'supports' => array(
            'title', 'editor', 'thumbnail'
            )
        )
    ])->register();
    
$typeManager->newType([
    'type' => 'create', 
    'class' => 'Create'
    ])->register();

