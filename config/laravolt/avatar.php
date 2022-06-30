<?php

/*
 * Set specific configuration variables here
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    | Avatar use Intervention Image library to process image.
    | Meanwhile, Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "Imagick" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */
    'driver' => env('IMAGE_DRIVER', 'imagick'),

    // Initial generator class
    'generator' => \Laravolt\Avatar\Generator\DefaultGenerator::class,

    // Whether all characters supplied must be replaced with their closest ASCII counterparts
    'ascii' => false,

    // Image shape: circle or square
    'shape' => 'square',

    // Image width, in pixel
    'width' => 512,

    // Image height, in pixel
    'height' => 512,

    // Number of characters used as initials. If name consists of single word, the first N character will be used
    'chars' => 1,

    // font size
    'fontSize' => 256,

    // convert initial letter in uppercase
    'uppercase' => true,

    // Fonts used to render text.
    // If it contains more than a font, randomly selected one based on name supplied
    'fonts' => ['https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap'],

    // List of foreground colors to be used, randomly selected based on name supplied
    'foregrounds' => [
        '#FFFFFF',
    ],

    // List of background colors to be used, randomly selected based on name supplied
    'backgrounds' => [
        '#f44336',
        '#d4145a',
        '#9C27B0',
        '#673AB7',
        '#3F51B5',
        '#2196F3',
        '#03A9F4',
        '#00BCD4',
        '#009688',
        '#4CAF50',
        '#8BC34A',
        '#CDDC39',
        '#FFC107',
        '#FF9800',
        '#FF5722',
    ],

    'border' => [
        'size' => 0,

        // border color, available value are:
        // 'foreground' (same as foreground color)
        // 'background' (same as background color)
        // or any valid hex ('#aabbcc')
        'color' => 'background',
    ],

    // List of theme name to be used when rendering avatar
    // Possible values are:
    // 1. Theme name as string: 'colorful'
    // 2. Or array of string name: ['grayscale-light', 'grayscale-dark']
    // 3. Or wildcard "*" to use all defined themes
    'theme' => ['colorful'],

    // Predefined themes
    // Available theme attributes are:
    // shape, chars, backgrounds, foregrounds, fonts, fontSize, width, height, ascii, uppercase, and border.
    'themes' => [
        'colorful' => [
            'backgrounds' => [
                '#f44336',
                '#E91E63',
                '#9C27B0',
                '#673AB7',
                '#3F51B5',
                '#2196F3',
                '#03A9F4',
                '#00BCD4',
                '#009688',
                '#4CAF50',
                '#8BC34A',
                '#CDDC39',
                '#FFC107',
                '#FF9800',
                '#FF5722',
            ],
            'foregrounds' => ['#FFFFFF'],
        ],
    ],
];
