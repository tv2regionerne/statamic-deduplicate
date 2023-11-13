# Statamic Deduplicate

> Statamic Deduplicate is a Statamic addon that provides a singleton store for entry ID's.  
> The addon ensure a consistent syntax.

## How to Install

Run the following command from your project root:

``` bash
composer require tv2regionerne/statamic-deduplicate
```

### Use with the collection tag
Start by creating a new tag which extends the Laravel collection tag.
An example can be seen below.

Usage is ```{{ collection:handle deduplicate="true" }}``` 

```php
<?php

namespace App\Tags;

use Statamic\Facades\Antlers;
use Statamic\Facades\Scope;
use Statamic\Tags\Collection\Collection as StatamicCollection;
use Statamic\Tags\Collection\Entries;
use Tv2regionerne\StatamicDeduplicate\Events\CollectionTagEvent;

class Collection extends StatamicCollection
{

    public function __call($method, $args)
    {
        $this->deduplicateApply();

        $entries = parent::__call($method, $args);

        $this->deduplicateUpdate($entries);

        CollectionTagEvent::dispatch($this);
        return $entries;
    }

    public function index()
    {
        $this->deduplicateApply();

        $entries = parent::index();

        $this->deduplicateUpdate($entries);

        CollectionTagEvent::dispatch($this);
        return $entries;
    }

    protected function deduplicateApply()
    {
        if (!$this->params->get('deduplicate', false)) {
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
        if (!$this->params->get('deduplicate', false)) {
            return;
        }

        if ($as = $this->params->get('as')) {
            $entries = $entries[$as];
        }

        $ids = $entries->pluck('id')->all();

        app('deduplicate')->merge($ids);
    }
}

```

## How to Use

Here's where you can explain how to use this wonderful addon.
