<?php

namespace S4mpp\Backline\Composers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Resource;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\Backline\Navigation\Menu;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use S4mpp\AdminPanel\Utils\AccessHistory;
use S4mpp\AdminPanel\Builders\PageBuilder;
use S4mpp\AdminPanel\Builders\ReportBuilder;
use S4mpp\Backline\Backline;

class MenuComposer
{
    public function __construct(
		private readonly Request $request
	) {
	}

    public function compose(View $view): void
    {
        $segment = 1;

        if(config('admin.prefix')) {
            $segment++;
        }


        $menu = new Menu();

        $this->createMenu($menu);

        $items = $menu->activate($this->request)->ordenate()->getItems();

        $view->with('menu', $items);
    }

    private function createMenu(Menu $menu)
    {
        $menu->createSection('Main', 'main', -1)->addItem(
            title: 'Home',
            icon: 'home',
            route_name: 'backline.home.index',
            activation_route_is: 'backline.home.index',
            order: -1,
        );
        
        foreach(Backline::getResources() as $resource_class) {

            $section = $resource_class::getSection();

            $menu->createSection($section, $section);

            $menu->section($section)
                ->addItem(
                    title: $resource_class::getTitle(),
                    icon: $resource_class::getIcon(),
                    route_name: $resource_class::getRouteName('action', 'index'),
                    activation_route_is: $resource_class::getRouteName('action', '*'),
                    order: -1,
                    badge: $resource_class::badge()
                );

        //     $resource = new $resource_class;

        //     foreach((new PageBuilder)->collect($resource)->getItems() as $page)
        //     {
        //         $menu->section($slug_resource)->addItem(
        //             title: $page->getTitle(),
        //             icon: 'chevron-right',
        //             route_name: $resource->getRouteName('page', $page->getSlug()),
        //             activation_route_is: $resource->getRouteName('page', $page->getSlug()),
        //             permission_name: $resource_class::getPermissionName('AdminResource', $resource::getName(), 'page', class_basename($page::class)),
        //         );
        //     }
        }
    }
}
