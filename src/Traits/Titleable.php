<?php

namespace S4mpp\Backline\Traits;

use Illuminate\Support\Str;

trait Titleable
{
    protected string $title;

    public function __toString(): string
    {
        return $this->getTitle();
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSlug(bool $camel_case = false): string
    {
        $slug = Str::slug($this->getTitle());

        if ($camel_case) {
            return Str::camel($slug);
        }

        return $slug;
    }
}
