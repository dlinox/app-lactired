<?php

return [

    'pdf' => [
        'enabled' => true,
        'binary' => '"' . env('SNAPPY_PDF_BINARY', 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe') . '"',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTML_IMG_BINARY', 'C:\Program Files\wkhtmltopdf\bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
];
