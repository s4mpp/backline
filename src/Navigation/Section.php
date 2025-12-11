<?php

namespace S4mpp\Backline\Navigation;

final class Section
{
    private array $items = [];

    public function __construct(private string $title, private string $slug, private ?int $order = null) {}

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function ordenateItems($callback): void
    {
        uasort($this->items, $callback);
    }
}
