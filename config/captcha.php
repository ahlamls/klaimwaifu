<?php
return [
    'default'   => [
        'length'    => 6,
        'width'     => 150,
        'height'    => 36,
        'quality'   => 90,
        'math'      => true,  //Enable Math Captcha
        'expire'    => 60,    //Stateless/API captcha expiration
        'contrast' => 20,
        'sensitive' => true,
        'invert' => true,
        'lines' => 2,
        'angle' => 5,
        'sharpen' => 10,
        'blur' => 2,
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
    ],
    // ...
];
?>