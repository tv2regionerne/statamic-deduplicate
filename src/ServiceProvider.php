<?php

namespace Tv2regionerne\StatamicDeduplicate;

use Statamic\Providers\AddonServiceProvider;
use Statamic\Tags\Collection\Collection;
use Tv2regionerne\StatamicDeduplicate\Actions\DeduplicateActions;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        Tags\Deduplicate::class,
    ];

    public function register()
    {
        $this->app->singleton('deduplicate', function () {
            return new Deduplicate;
        });

        Collection::hook('init', DeduplicateActions::filter());
        Collection::hook('fetched-entries', DeduplicateActions::registerEntries());
    }
}
