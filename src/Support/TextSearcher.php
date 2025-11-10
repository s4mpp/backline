<?php

namespace S4mpp\Backline\Support;

use Closure;

final class TextSearcher
{
    private bool $is_exact = false;

    private ?Closure $prepare = null;

    public function __construct(private string $title, private string $field) {}

    public function prepare(Closure $prepare): self
    {
        $this->prepare = $prepare;

        return $this;
    }

    public function prepareSearchTerm(string $search_term): string
    {
        if(!$this->prepare) {
            return $search_term;
        }

        return call_user_func($this->prepare, $search_term);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function exact()
    {
        $this->is_exact = true;
    }

    public function isExact()
    {
        return $this->is_exact;
    }
}
