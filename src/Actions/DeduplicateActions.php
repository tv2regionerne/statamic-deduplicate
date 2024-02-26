<?php

namespace Tv2regionerne\StatamicDeduplicate\Actions;

class DeduplicateActions
{
    public static function filter()
    {
        // Define a closure that manipulates the payload
        return function ($payload, $next) {
            if (! $this->params->get('deduplicate', false)) {
                return $next($payload);
            }

            $ids = app('deduplicate')->fetch();

            if ($this->params->has('id:not_in')) {
                $tagIds = $this->params['id:not_in'];
                if (is_string($tagIds)) {
                    $tagIds = explode('|', $tagIds);
                }
                $ids = array_merge($ids, $tagIds);
            }

            $this->params->put('id:not_in', $ids);

            return $next($payload);
        };
    }

    public static function registerEntries()
    {
        return function ($entries, $next) {

            if (! $this->params->get('deduplicate', false)) {
                return $next($entries);
            }

            if ($as = $this->params->get('as')) {
                $entries = $entries[$as];
            }

            $ids = $entries->pluck('id')->all();

            app('deduplicate')->merge($ids);

            return $next($entries);
        };
    }
}
