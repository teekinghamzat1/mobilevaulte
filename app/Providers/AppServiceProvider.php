<?php

namespace App\Providers;

use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\Facades\View;
use App\Models\Settings;
use App\Models\SettingsCont;
use App\Models\TermsPrivacy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FacadesStorage::extend('sftp', function ($app, $config) {
            return new Filesystem(new SftpAdapter($config));
        });

        Paginator::useBootstrap();

        // Sharing settings with all view
        $settings = Settings::where('id', '1')->first();
        $terms =  TermsPrivacy::find(1);
        $moreset =  SettingsCont::find(1);

        View::share('settings', $settings);
        View::share('terms', $terms);
        View::share('moresettings', $moreset);
        View::share('mod', $settings->modules);

        // Dynamically apply user account currency to all views
        View::composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
                $user = \Illuminate\Support\Facades\Auth::guard('web')->user();
                if ($user) {
                    $sym = $user->currency;
                    $code = $user->s_currency;

                    if (!$sym && !$code && method_exists($user, 'currencies')) {
                        $def = $user->currencies()->where('is_default', true)->first()
                            ?? $user->currencies()->first();
                        if ($def) {
                            $sym = $def->currency_symbol;
                            $code = $def->currency_code;
                        }
                    }

                    if ($sym || $code) {
                        $viewData = $view->getData();
                        $current = $viewData['settings'] ?? View::shared('settings');
                        if ($current) {
                            $userSettings = clone $current;
                            if ($sym) {
                                $userSettings->currency = $sym;
                            }
                            if ($code) {
                                $userSettings->s_currency = $code;
                            }
                            $view->with('settings', $userSettings);
                        }
                    }
                }
            }
        });
    }
}