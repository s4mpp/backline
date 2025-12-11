<?php

namespace S4mpp\Backline\Navigation;

use Closure;

final class Menu
{
    private array $sections = [];

    public function addSection(Section $section): Section
    {
        $this->sections[$section->getSlug()] = $section;

        return $section;
    }

    public function getSection(string $slug): ?Section
    {
        if (! array_key_exists($slug, $this->sections)) {
            return null;
        }

        return $this->sections[$slug];
    }

    public function activate(Closure $callback_activation)
    {
        foreach ($this->sections as &$section) {
            foreach ($section->getItems() as &$item) {
                $is_active = call_user_func($callback_activation, $item);

                if ($is_active) {
                    $item->activate();

                    break 2;
                }
            }
        }

        return $this;
    }

    public function ordenate()
    {
        $callback_ordenation = fn ($a, $b) => $this->sortByOrderAndTitle($a, $b);

        $this->sections = array_map(function ($section) use ($callback_ordenation) {
            $section->ordenateItems($callback_ordenation);

            return $section;
        }, $this->sections);

        uasort($this->sections, $callback_ordenation);

        return $this;
    }

    public function getSections()
    {
        return $this->sections;
    }

    private function sortByOrderAndTitle($a, $b)
    {
        $order_a = $a->getOrder();
        $order_b = $b->getOrder();

        if ($order_a === null && $order_b !== null) {
            return 1;
        }

        if ($order_a !== null && $order_b === null) {
            return -1;
        }

        if ($order_a !== $order_b) {
            return $order_a - $order_b;
        }

        return strcasecmp($a->getTitle(), $b->getTitle());
    }
}
