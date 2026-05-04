<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timeout:
    |
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */

    'pdf' => [
        'enabled' => true,
        'binary'  => env('WKHTML_PDF_BINARY', '/usr/local/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true,
            'encoding' => 'UTF-8',
            'page-size' => 'A4',
            'orientation' => 'portrait',
            'lowquality' => true,
            'margin-top' => 20,
            'margin-bottom' => 10,
            // 'footer-left' => 'SIMOJA UKT 2 - Dibuat pada ' . \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') . ' [time]',
            'footer-left' => 'SIMOJA UKT 2',
            'footer-right' => 'Halaman [page] / [topage]',
            'footer-font-size' => 7,
            // 'footer-spacing' => 10,
            'quiet' => true,
            'load-error-handling' => 'ignore',
            'load-media-error-handling' => 'ignore',
            'dpi' => 96,
        ],
        'env'     => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTML_IMG_BINARY', '/usr/local/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
