<?php
/**
 * Lib Compress
 * @package lib-compress 
 * @version 0.0.1
 */

return [
    '__name' => 'lib-compress',
    '__version' => '0.1.1',
    '__git' => 'git@github.com:getphun/lib-compress.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-compress' => ['install', 'update', 'remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibCompress\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-compress/library'
            ],
            'LibCompress\\Server' => [
            	'type' => 'file',
            	'base' => 'modules/lib-compress/server'
            ]
        ]
    ],

    'server' => [
        'lib-compress' => [
            'ImageMagick'   => 'LibCompress\\Server\\PHP::imageMagick',
            'ImageGD'       => 'LibCompress\\Server\\PHP::imageGD',
            'GD/WebP'       => 'LibCompress\\Server\\PHP::gdWebP',
            'Brotli'        => 'LibCompress\\Server\\PHP::brotli',
            'GZip'          => 'LibCompress\\Server\\PHP::gzip'
        ]
    ]
];
