<?php

namespace S4mpp\Backline\Navigation;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

final class Menu
{
	private array $sections = [];

	private string $current_section = 'main';

	public function createSection(string $title, string $slug, ?int $order = null)
	{
		if(array_key_exists($slug, $this->sections))
		{
			return;
		}

		$this->sections[$slug] = [
			'title' => $title,
			'order' => $order,
			'items' => []
		];

		$this->current_section = $slug;

		return $this; 
	}

	public function section(string $slug)
	{
		$this->current_section = $slug;

		return $this;
	}

	public function addItem(
		string $title,
		string $icon,
		string $route_name,
		string $activation_route_is = null,
		int $order = 0,
		string $permission_name = null,
		int|float|string|null $badge = null
	)
	{
		$this->sections[$this->current_section]['items'][] = [
			'title' => $title,
			'icon' => $icon,
			'url' => route($route_name),
			'active' => false,
			'activation_route_is' => $activation_route_is ?? $route_name,
			'order' => $order,
			'permission_name' => $permission_name,
			'badge' => $badge,
		];
	}

	public function activate(Request $request)
	{
		foreach($this->sections as &$section)
		{
			foreach($section['items'] as &$item)
			{
				$is_active = $request->routeIs($item['activation_route_is']);

				$item['active'] = $is_active;

				if($is_active)
				{
					break 2;
				}
			}
		}

		return $this;
	}

	public function ordenate()
	{
		$this->sections = array_map(function ($item) {

            uasort($item['items'], fn($a, $b) => $this->sortByOrderAndTitle($a, $b));

            return $item;
        }, $this->sections);

        uasort($this->sections, fn($a, $b) => $this->sortByOrderAndTitle($a, $b));

        return $this;
	}

	public function getItems()
	{
		return $this->sections;
	}

	private function sortByOrderAndTitle($a, $b)
    {
        if ($a['order'] === null && $b['order'] !== null) {
            return 1;
        }

        if ($a['order'] !== null && $b['order'] === null) {
            return -1;
        }

        if ($a['order'] !== $b['order']) {
            return $a['order'] - $b['order'];
        }

        return strcasecmp($a['title'], $b['title']);
    }

	// public function filterPermissions(User $user)
	// {
	// 	$this->sections = array_map(function ($item) use ($user) {
    //         $item['items'] = array_filter($item['items'], fn($item) => $user->can($item['permission_name']));

    //         return $item;
    //     }, $this->sections);

    //     $this->sections = array_filter($this->sections, fn($section) => ! empty($section['items']));

    //     return $this;
	// }
}
