<?php

namespace Tv2regionerne\StatamicDeduplicate;

class Deduplicate
{
    protected $ids;

    public function __construct()
    {
        $this->ids = collect();
    }

    public function fetch()
    {
        return $this->ids->all();
    }

    public function merge($ids)
    {
        $this->ids = $this->ids->concat($ids);

        return $this;
    }

    protected function deduplicateApply()
    {
        if (! $this->params->get('deduplicate', false)) {
            return;
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
    }

    protected function deduplicateUpdate($entries)
    {
        if (! $this->params->get('deduplicate', false)) {
            return;
        }

        if ($as = $this->params->get('as')) {
            $entries = $entries[$as];
        }

        $ids = $entries->pluck('id')->all();

        app('deduplicate')->merge($ids);
    }
}
