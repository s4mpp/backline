<?php

namespace S4mpp\Backline\Builders;

use Closure;
use S4mpp\Backline\Labels\Label;
use S4mpp\AdminPanel\Concerns\Panel;
use S4mpp\Backline\Concerns\Resource;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Concerns\Repeater;
use S4mpp\AdminPanel\Support\ContextConfig;
use S4mpp\AdminPanel\Contracts\CollectionBuilder;

class ReadBuilder
{
    private array $panels = [];

    private array $groups = [];
    
    private array $repeaters = [];

    private ?string $current_group = null;
    
    public function collect(Resource $resource)
    {
        if(method_exists($resource, 'read')) {
        
            $resource->read($this);
        }
        
        return $this;
    }


    //TODO duplicado ReadBuilder/TableBuilder
    private ?Closure $query_builder_appends = null;

    public function group(string $name_group): self
    {
        $this->current_group = $name_group;

        return $this;
    }

    public function labels(Label ...$labels): void
    {
        $this->groups[$this->current_group] = $labels;

        $this->current_group = null;
    }

    // public function panels(Panel ...$panels): void
    // {
    //     $this->panels = $panels;
    // }

    public function getPanels()
    {
        return $this->panels;
    }

    // public function repeaters(Repeater ...$repeater): void
    // {
    //     $this->repeaters = $repeater;
    // }

    public function getRepeaters(): array
    {
        return $this->repeaters;
    }

    //TODO duplicado ReadBuilder/TableBuilder
    public function query(Closure $builder)
    {
        $this->query_builder_appends = $builder;
    }

    //TODO duplicado ReadBuilder/TableBuilder
    public function getQueryBuilderAppends(): ?Closure
    {
        return $this->query_builder_appends;
    }

    // public function collect(Resource $resource): self
    // {
    //     $resource->read($this);

    //     return $this;
    // }

    public function getItems(): array
    {
        return $this->groups;
    }
}
