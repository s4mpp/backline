<?php

namespace S4mpp\Backline\Traits;

trait CanBeInline
{
    private bool $inline = false;

    public function inline(): self
    {
        $this->inline = true;

        return $this;
    }

    public function isInline(): bool
    {
        return $this->inline;
    }
}
