<?php


return [
    'tpl' => [
        'w_start'       => TEMPLATE_PATH . 'w_start.php',
        'tpl_header'    => TEMPLATE_PATH . 'header.php',
        'tpl_nav'       => TEMPLATE_PATH . 'nav.php',
        ':view'         => ':vie',
        'w_end'         => TEMPLATE_PATH . 'w_end.php',
    ],
    'H_srcs' => [
        'CSS' => [
            'norm'      => CSS . 'normlize.css',
            'fawsome'   => CSS . 'fawsome.min.css',
            'google'    => CSS . 'googleicons.css',
            'main'      => CSS . 'mainen.css'
        ],
        'JS' => [
            'modi' => JS . 'vendor/m.js'
        ]
    ],

    'F_srcs' => [
        'Jq' => JS . 'vendor/jq.js',
        'helper' => JS . 'helper.js',
        'main' => JS . 'main.js',
        'datatable' => JS . 'datatablesen.js'
    ]

];