<?php

namespace S4mpp\Backline\Builders;

use Closure;
use S4mpp\AdminPanel\Resource;
use S4mpp\Backline\Labels\Label;
use S4mpp\Backline\Support\Ordenation;
use S4mpp\Backline\Support\TextSearcher;

class TableBuilder
{
    private array $search_by = [];

    private array $columns = [];

    private ?Ordenation $ordenation = null;

    //TODO duplicado ReadBuilder/TableBuilder
    private ?Closure $query_builder_appends = null;

    public function searchBy(string $title, string $field): TextSearcher
    {
        $text_searcher = new TextSearcher($title, $field);
        
        $this->search_by[] = $text_searcher;

        return $text_searcher;
    }

    public function getSearchs()
    {
        return $this->search_by;
    }

    public function sortByDesc(string $field): void
    {
        $this->ordenation = new Ordenation($field, 'desc');
    }

    public function sortByAsc(string $field): void
    {
        $this->ordenation = new Ordenation($field, 'asc');
    }

    public function getOrdenation()
    {
        if ($this->ordenation) {
            return $this->ordenation;
        }

        return new Ordenation('id', 'desc');
    }

    public function columns(Label ...$columns): void
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
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

    
}
