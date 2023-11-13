<?php

namespace Tv2regionerne\StatamicDeduplicate;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{

    public function register()
    {
        $this->app->singleton('deduplicate', function () {
            return new Deduplicate();
        });
    }
}
