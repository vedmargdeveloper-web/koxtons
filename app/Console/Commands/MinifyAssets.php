<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MatthiasMullie\Minify;

class MinifyAssets extends Command
{
    protected $signature = 'minify:assets';
    protected $description = 'Minify CSS and JS assets';

    public function handle()
    {
        // Ensure build folders exist
        if (!file_exists(public_path('build/css'))) {
            mkdir(public_path('build/css'), 0777, true);
        }
        if (!file_exists(public_path('build/js'))) {
            mkdir(public_path('build/js'), 0777, true);
        }

        // CSS files
        $cssFiles = [
            base_path('assets/css/design.min.css'),
            base_path('assets/css/responsive.min.css'),
            base_path('assets/catalog/view/javascript/bootstrap/css/bootstrap.min.css'),
            base_path('assets/catalog/view/javascript/font-awesome/css/font-awesome.min.css'),
            base_path('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/mahardhi-font.css'),
            base_path('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/animate.min.css'),
            base_path('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/owl.carousel.min.css'),
            base_path('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/owl.theme.default.min.css'),
            base_path('assets/catalog/view/javascript/jquery/magnific/magnific-popup.css'),
            base_path('assets/catalog/my.css'),
            base_path('assets/catalog/koxton.css'),
            base_path('assets/catalog/view/theme/mahardhi/stylesheet/stylesheet.css'),
            base_path('assets/catalog/view/javascript/jquery/swiper/css/swiper.min.css'),
            base_path('assets/catalog/view/javascript/jquery/swiper/css/mycart.css'),
            base_path('assets/catalog/view/theme/mahardhi/stylesheet/mahardhi/jquery-ui.min.css'),
   
          
        ];

        // JS files
        $jsFiles = [
            base_path('assets/catalog/view/javascript/jquery/jquery-2.1.1.min.js'),
            base_path('assets/catalog/view/javascript/bootstrap/js/bootstrap.min.js'),
            base_path('assets/catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js'),
            base_path('assets/catalog/view/javascript/mahardhi/owl.carousel.min.js'),
            base_path('assets/catalog/view/javascript/mahardhi/jquery.elevateZoom.min.js'),  
            base_path('assets/catalog/view/javascript/jquery/swiper/js/swiper.jquery.js'),
            base_path('assets/catalog/view/javascript/mahardhi/tabs.js'),
            base_path('assets/catalog/view/javascript/mahardhi/countdown.js'),
            base_path('assets/catalog/view/javascript/mahardhi/jquery.cookie.js'),
            base_path('assets/catalog/view/javascript/common.js'),
            base_path('assets/catalog/view/javascript/mahardhi/jquery-ui.min.js'),
            base_path('assets/catalog/view/javascript/mahardhi/custom.js'),
            base_path('assets/js/plugins/owl.carousel.min.js'),
            base_path('assets/js/plugins/plugins-all.js'),
            base_path('assets/js/main.min.js'),
            base_path('assets/js/template.js'),
            base_path('assets/koxtonsmart/assets/js/bootstrap.min.js'),
            base_path('assets/koxtonsmart/assets/js/jquery-plugin-collection.js'),
            base_path('assets/koxtonsmart/assets/js/script.js'),


        ];

        // Minify CSS
        $cssMinifier = new Minify\CSS();
        foreach ($cssFiles as $file) {
            if (file_exists($file)) {
                $cssMinifier->add($file);
            } else {
                $this->warn("CSS file not found: {$file}");
            }
        }
        $cssMinifier->minify(public_path('build/css/app.min.css'));
        $this->info('CSS minified!');

        // Minify JS
        $jsMinifier = new Minify\JS();
        foreach ($jsFiles as $file) {
            if (file_exists($file)) {
                $jsMinifier->add($file);
            } else {
                $this->warn("JS file not found: {$file}");
            }
        }
        $jsMinifier->minify(public_path('build/js/app.min.js'));
        $this->info('JS minified!');
    }
}
