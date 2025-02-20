<?php

namespace AvtoDev\Dadata;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class DadataServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/dadata.php';
        $publishPath = config_path('dadata.php');

        $this->publishes([$configPath => $publishPath], 'config');

        $loader = AliasLoader::getInstance();
        $loader->alias('DadataClean', ClientClean::class);

        $loaderHint = AliasLoader::getInstance();
        $loaderHint->alias('DadataSuggest', ClientSuggest::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('dadata_suggest', function () {
            return new ClientSuggest();
        });
        $this->app->bind('dadata_clean', function () {
            return new ClientClean();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/dadata.php', 'dadata');
    }
}
