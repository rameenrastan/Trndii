<?php

return [

    //enables/disables A/B testing
    'enabled' => true,
    'default' => 'none',

    //defines tests with distribution levels (segmentation)
    'tests' => [
        'Basic' => 1,
        'Token' => 1,
    ],

];
