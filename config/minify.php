<?php

return [

    'css' => [
        'app' => [
            'inputs' => [
                // your current CSS files
                'public/assets/css/design.min.css',
                'public/assets/css/responsive.min.css',
                'public/assets/catalog/view/javascript/bootstrap/css/bootstrap.min.css',
                'public/assets/catalog/view/javascript/font-awesome/css/font-awesome.min.css',
                'public/assets/catalog/my.css',
                'public/assets/catalog/koxton.css',
                'public/assets/catalog/view/theme/mahardhi/stylesheet/stylesheet.css',
                'public/assets/catalog/view/javascript/jquery/swiper/css/swiper.min.css',
                'public/assets/catalog/view/javascript/jquery/swiper/css/mycart.css',
                'public/assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/mahardhi-font.css',
                'public/assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/animate.min.css',
                'public/assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/owl.carousel.min.css',
                'public/assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/owl.theme.default.min.css',
                'public/assets/catalog/view/javascript/jquery/magnific/magnific-popup.css',
                'public/assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/jquery-ui.min.css',
            ],
            'output' => 'public/build/css/app.min.css',
        ],
    ],

    'js' => [
        'app' => [
            'inputs' => [
                // your current JS files
                'public/assets/catalog/view/javascript/jquery/jquery-2.1.1.min.js',
                'public/assets/catalog/view/javascript/bootstrap/js/bootstrap.min.js',
                'public/assets/catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js',
                'public/assets/catalog/view/javascript/mahardhi/owl.carousel.min.js',
                'public/assets/catalog/view/javascript/mahardhi/jquery.elevateZoom.min.js',
                'public/assets/catalog/view/javascript/jquery/swiper/js/swiper.jquery.js',
                'public/assets/catalog/view/javascript/mahardhi/tabs.js',
                'public/assets/catalog/view/javascript/mahardhi/countdown.js',
                'public/assets/catalog/view/javascript/mahardhi/jquery.cookie.js',
                'public/assets/catalog/view/javascript/common.js',
                'public/assets/catalog/view/javascript/mahardhi/jquery-ui.min.js',
                'public/assets/catalog/view/javascript/mahardhi/custom.js',
                'public/assets/js/plugins/owl.carousel.min.js',
                'public/assets/js/plugins/plugins-all.js',
                'public/assets/js/main.min.js',
                'public/assets/js/template.js',
                'public/assets/koxtonsmart/assets/js/bootstrap.min.js',
                'public/assets/koxtonsmart/assets/js/jquery-plugin-collection.js',
                'public/assets/koxtonsmart/assets/js/script.js',
            ],
            'output' => 'public/build/js/app.min.js',
        ],
    ],

    // Manifest for versioning
    'manifest' => 'public/minify-manifest.json',
];
