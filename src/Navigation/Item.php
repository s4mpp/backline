<?php

namespace S4mpp\Backline\Navigation;

final class Item
{
    private bool $is_active = false;

    public function __construct(
        private string $title,
        private string $icon,
        private string $route_name,
        private ?string $activation_route_is = null,
        private ?int $order = null,
        private ?string $permission_name = null,
        private int|float|string|null $badge = null
    ) {}

    public function getActivationRouteIs()
    {
        return $this->activation_route_is;
    }

    public function activate(): void
    {
        $this->is_active = true;
    }

    public function isActive()
    {
        return $this->is_active;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getBadge()
    {
        return $this->badge;
    }

    public function getUrl()
    {
        return route($this->route_name);
    }
}
