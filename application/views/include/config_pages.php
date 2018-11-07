<?php

$pages = array(
    'home' => array(
        'id' => 'p1', // (ul > li) ID attribute
        'class' => array('red','blue'), // (ul > li) Class attribute // if you want to add a class
        'href' => "home", // base_url is the default if empty
        'icon' => 'fa fa-dashboard',
        'has_sub_menu' => FALSE,
        'sub_menu' => array()
    ),
    'page 2' => array(
        'id' => 'p2',
        'class' => array(),
        'href' => "",
        'icon' => 'fa fa-check',
        'has_sub_menu' => TRUE,
        'sub_menu' => array(
            'sub 1' => array(
                'id' => 'id1',
                'class' => array('red','orange'),
                'href' => "Sub_One"
                ),
            'sub 2' => array(
                'id' => 'id2',
                'class' => array('orange','blue'),
                'href' => "Sub_Two"
            ),
            'sub 3' => array(
                'id' => 'id3',
                'class' => array('blue','red'),
                'href' => "Sub_Three"
            )
        )
    ),
    'About' => array(
        'id' => 'p1', // (ul > li) ID attribute
        'class' => array('red','blue'), // (ul > li) Class attribute // if you want to add a class
        'href' => "About", // base_url is the default if empty
        'icon' => 'fa fa-dashboard',
        'has_sub_menu' => FALSE,
        'sub_menu' => array()
    ),
);