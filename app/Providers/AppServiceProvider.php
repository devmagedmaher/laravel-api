<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();


        Blade::include('admin.error', 'errorView');
        Blade::include('admin.success', 'successView');

        Blade::directive('error', function($expresion) 
        {
            list($error, $output) = explode(',', $expresion);
            $error = trim($error, "' ");
            $output = trim($output, "' ");
            return '<?php

                if ($errors->has(\''.$error.'\')) {
                    echo \''.$output.'\';
                }

            ?>';
        });

        Blade::if('admin', function() 
        {
            return Auth::user() && Auth::user()->isAdmin();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
