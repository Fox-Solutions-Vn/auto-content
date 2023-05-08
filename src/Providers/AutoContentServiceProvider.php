<?php

namespace FoxSolution\AutoContent\Providers;

use FoxSolution\AutoContent\Adapters\OpenAiAdapter;
use FoxSolution\AutoContent\Contracts\OpenAiInterface;
use FoxSolution\AutoContent\Facades\OpenAiFacade;
use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AutoContentServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->singleton(OpenAiInterface::class, function () {
            return new OpenAiAdapter();
        });

        AliasLoader::getInstance()->alias('OpenAi', OpenAiFacade::class);
    }

    public function boot(): void
    {
        $this->setNamespace('plugins/auto-content')
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        Helper::autoload('../../helpers');

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-auto-content',
                'priority' => 9,
                'parent_id' => 'cms-core-settings',
                'name' => 'plugins/auto-content::content.name',
                'icon' => null,
                'url' => route('auto-content.setting.index'),
            ]);
        });

        $this->app->register(HookServiceProvider::class);
    }
}
