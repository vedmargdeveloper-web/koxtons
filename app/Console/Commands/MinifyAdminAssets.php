<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MatthiasMullie\Minify;

class MinifyAdminAssets extends Command
{
    protected $signature = 'minify:admin';
    protected $description = 'Minify CSS and JS assets for Admin panel';

    public function handle()
    {
        // Ensure build folders exist
        if (!file_exists(public_path('build/admin/css'))) {
            mkdir(public_path('build/admin/css'), 0777, true);
        }
        if (!file_exists(public_path('build/admin/js'))) {
            mkdir(public_path('build/admin/js'), 0777, true);
        }

        // -------------------
        // CSS FILES
        // -------------------
        $cssFiles = [
            base_path('assets/admin/css/style.css'),
            base_path('assets/admin/css/design.css'),
            base_path('assets/admin/css/multi-select.css'),
            base_path('assets/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css'),
            // base_path('public/styles/vendor/perfect-scrollbar.css'),
            base_path('assets/datetimepicker/jquery.datetimepicker.css'),
            base_path('assets/select/dist/css/select2.min.css'),
            base_path('assets/chosen/chosen.min.css'),
            // base_path('public/assets/datepicker/dist/css/bootstrap-datepicker.min.css'),
        ];

        $cssMinifier = new Minify\CSS();
        foreach ($cssFiles as $file) {
            if (file_exists($file)) {
                $cssMinifier->add($file);
            } else {
                $this->warn("CSS not found: {$file}");
            }
        }
        $cssMinifier->minify(public_path('build/admin/css/admin.min.css'));
        $this->info('Admin CSS minified!');

        // -------------------
        // JS FILES
        // -------------------
        $jsFiles = [
            base_path('assets/js/jquery.min.js'),
            // base_path('public/chartjs/Chart.bundle.js'),
            // base_path('public/chartjs/utils.js'),
            base_path('assets/admin/js/jquery.multi-select.js'),
            base_path('assets/admin/js/admin.js'),
            base_path('assets/chosen/chosen.jquery.js'),
            // base_path('assets/tinymce/tinymce.min.js'),
            // base_path('public/assets/datepicker/dist/js/bootstrap-datepicker.min.js'),
            base_path('assets/datetimepicker/build/jquery.datetimepicker.full.min.js'),
            base_path('assets/admin/js/admin-site.js'),
            base_path('assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js'),
            base_path('assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js'),
        ];

        $jsMinifier = new Minify\JS();
        foreach ($jsFiles as $file) {
            if (file_exists($file)) {
                $jsMinifier->add($file);
            } else {
                $this->warn("JS not found: {$file}");
            }
        }
        $jsMinifier->minify(public_path('build/admin/js/admin.min.js'));
        $this->info('Admin JS minified!');
    }
}
