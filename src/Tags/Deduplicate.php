<?php

namespace Tv2regionerne\StatamicDeduplicate\Tags;

use Statamic\Tags\Tags;

class Deduplicate extends Tags
{
    public function wildcard($id)
    {
        $this->params['ids'] = [$id];

        $this->merge();
    }

    public function merge()
    {
        $ids = $this->params->get('ids');
        if (is_string($ids)) {
            $ids = explode('|', $ids);
        }

        app('deduplicate')->merge($ids);
    }
}
