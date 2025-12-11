<?php

namespace S4mpp\Backline\Composers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use S4mpp\Backline\Backline;
use S4mpp\Backline\Navigation\Item;
use S4mpp\Backline\Navigation\Menu;
use S4mpp\Backline\Navigation\Section;

class MenuComposer
{
    public function __construct(
        private readonly Request $request
    ) {}

    public function compose(View $view): void
    {
        $segment = 1;

        if (config('admin.prefix')) {
            $segment++;
        }

        $menu = new Menu;

        $this->createMenu($menu);

        $menu->activate(fn ($item) => $this->request->routeIs($item->getActivationRouteIs()))->ordenate();

        $menu_sections = $menu->getSections();

        $view->with('menu_sections', $menu_sections);
    }

    private function createMenu(Menu $menu): void
    {
        $main_section = new Section('Main', 'main', -1);

        $main_section->addItem(new Item(
            title: 'Home',
            icon: 'home',
            route_name: 'backline.home.index',
            activation_route_is: 'backline.home.index',
            order: -1,
        ));

        $menu->addSection($main_section);

        foreach (Backline::getResources() as $resource_class) {

            $section = null;

            $slug_section = $resource_class::getSection();

            if ($slug_section) {
                if (! $section = $menu->getSection($slug_section)) {
                    $section = $menu->addSection(new Section($slug_section, $slug_section));
                }
            }

            if (! $section) {
                $section = $main_section;
            }

            if (! $icon = $resource_class::getIcon()) {
                $icon = 'chevron-right';
            }

            $section->addItem(new Item(
                title: $resource_class::getTitle(),
                icon: $icon,
                route_name: $resource_class::getRouteName('action', 'index'),
                activation_route_is: $resource_class::getRouteName('action', '*'),
                order: $resource_class::getMenuOrder(),
                badge: $resource_class::badge()
            ));
        }
    }
}
