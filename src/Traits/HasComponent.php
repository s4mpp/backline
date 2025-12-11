<?php

namespace S4mpp\Backline\Traits;

trait HasComponent
{
    private string $component;

    public function getComponentName(): string
    {
        return $this->component;
    }

    public function setComponent(string $component): void
    {
        $this->component = $component;
    }
}
