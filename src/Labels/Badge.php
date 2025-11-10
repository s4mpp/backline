<?php

namespace S4mpp\Backline\Labels;

use Closure;
use S4mpp\AdminPanel\Traits\HasComponent;

final class Badge extends Label
{
    // use HasComponent;

    private ?Closure $content = null;

    private ?Closure $color = null;

    public function __construct(string $title, ?string $field = null)
    {
        parent::__construct($title, $field);

        // $this->setComponent('admin::label.badge');
    }

    public function color(Closure $callback): self
    {
        $this->color = $callback;

        return $this;
    }

    public function content(Closure $callback): self
    {
        $this->content = $callback;

        return $this;
    }

    public function fromEnum(?string $method_label = null, ?string $method_color = null): self
    {
        $this->content(fn ($value) => ($method_label) ? $value->{$method_label}() : $value->name);

        $this->color(fn ($value) => ($method_color) ? $value->{$method_color}() : null);

        return $this;
    }

    public function getContentFormatted(): mixed
    {
        $value = $this->getContentAfterCallbacks();

        if ($this->content && $value) {
            return call_user_func($this->content, $value);
        }

        return $value;
    }

    // public function getColor(): ?string
    // {
    //     $value = $this->getValue();

    //     if ($this->color && $value) {
    //         return call_user_func($this->color, $value);
    //     }

    //     return null;
    // }

    // public function mapExcel(): Closure
    // {
    //     return fn () => $this->getValueFormatted();
    // }
}
