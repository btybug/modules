<?php

return [

    /**
     * Assets Configuration
     */
    'assets' => [
        /**
         * Header Assets
         */
        'header' => [
            // JS

            // CSS
            'fontawesome' => ['https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css'],
            'headercss' => [
                'bootstrap',
                URL(config('paths.templates_path') . '/TPL_PATH/css/style.css')
            ],
        ],
        /**
         * Footer Assets
         */
        'footer' => []
    ]

];
