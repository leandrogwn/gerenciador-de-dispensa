<?php

return [
    'pdf' => array(
        'enabled' => true,
        'binary' => base_path('vendor\h4cc\wkhtmltopdf-i386\bin\wkhtmltopdf-i386'),
        'timeout' => false,
        'options' => array(
            'page-size' => 'A4',
            'margin-top' => 23,
            'margin-right' => 8,
            'margin-left' => 8,
            'margin-bottom' => 23,
            'footer-right' => 'Página [page] de [toPage]',
            'footer-center' =>'[date] [time]',
            'footer-left' => 'www.gurskiassessoria.com.br',
            'footer-font-size' => 8,
            'footer-spacing' => 2
        ),
        'env' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => '',
        'timeout' => false,
        'options' => array(),
        'env' => array(),
    ),
];
