<?php

namespace S4mpp\Backline\Concerns;

use Illuminate\Support\Str;
use S4mpp\Backline\Enums\Action;
use S4mpp\AdminPanel\Support\Filter;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\Backline\Builders\FormBuilder;
use S4mpp\Backline\Builders\ReadBuilder;
use S4mpp\Backline\Builders\TableBuilder;
use S4mpp\AdminPanel\Builders\PageBuilder;
use S4mpp\AdminPanel\Support\CustomAction;
use S4mpp\AdminPanel\Builders\ReportBuilder;
use S4mpp\AdminPanel\Builders\WidgetBuilder;
use S4mpp\AdminPanel\Builders\RepeaterBuilder;
use S4mpp\AdminPanel\Contracts\CollectionBuilder;
use S4mpp\AdminPanel\Builders\CustomActionBuilder;

class Resource
{
    // protected static string $title;

    // protected static string $label = '';

    // protected static ?string $default_field = null;

    protected static string $section = 'main';
    
    protected static string $icon = 'chevron-right';
    
    // protected static string $delete_message = 'Tem certeza que deseja excluir este registro?';

    // protected static array $actions = [];

    protected static int $menu_order = 0;

    public static function badge(): int|float|string|null
    {
        return null;
    }

    final public static function getName(): string
    {
        return str_replace('Resource', '', class_basename(static::class));
    }

    final public static function getIcon(): string
    {
        return static::$icon;
    }

    // final public static function getLabel(): ?string
    // {
    //     return static::$label;
    // }

    final public static function getMenuOrder(): int
    {
        return static::$menu_order;
    }

    final public static function getTitle(): string
    {
        return static::$title;
    }

    // final public static function getDefaultField(): ?string
    // {
    //     return static::$default_field;
    // }

    final public static function getSlug(): string
    {
        return Str::slug(self::getTitle());
    }

    final public static function getSection(): string
    {
        return static::$section;
    }

    final public static function getSectionLabel(): ?string
    {
        return self::getSection();
        // return AdminPanel::getModules()[self::getSection()]?->getTitle() ?? null;
    }

    // // /**
    // //  * @return array<string>
    // //  */
    // // final public function getSearch(): array
    // // {
    // //     //TODO [MAJOR] permitir especificar em qual campo o search deve buscar (atualmente ele busca em todo com OR)
    // //     //TODO [MAJOR] especificar tipo de busca: like, where,
    // //     return $this->search ?? [];
    // // }

    // final public static function getPermissionName(string $action, string $resource): string
    // {
    //     return implode('.', ['AdminResource', self::getName(), $action, $resource]);
    // }

    final public static function getRouteName(string ...$action): string
    {
        return implode('.', ['backline', self::getName(), ...$action]);
    }

    // final public static function getDeleteMessage(): string
    // {
    //     return static::$delete_message;
    // }

    // final public static function getActions(): array
    // {
    //     return static::$actions;
    // }

    final public static function hasAction(Action $action): bool
    {
        return in_array($action, static::$actions);
    }

    


    // // // final public function getDefaultRoute(): ?string
    // // // {
    // // // 	if($this->hasAction('read'))
    // // // 	{
    // // // 		return $this->getRouteName('read');
    // // // 	}
    // // // 	else if($this->hasAction('update'))
    // // // 	{
    // // // 		return $this->getRouteName('update');
    // // // 	}

    // // // 	return null;
    // // // }

    final public function getModel(): Model
    {
        $model = config('backline.app_namespace', '\App').'\\Models\\'.$this->getName();

        if (! class_exists($model)) {
            throw new \Exception('Model "'.$model.'" not found');
        }

        /** @var Model */
        return app($model);
    }    

    // /**
    //  * @deprecated use Builder::collect($resource)
    //  */
    // public function collectElements(CollectionBuilder $builder)
    // {
    //     $builder->collect($this);

    //     return $builder->getItems();
    // }
    
    // public function table(TableBuilder $table_builder): void {}

    // public function read(ReadBuilder $read_builder): void {}
    
    // public function form(FormBuilder $form_builder): void {}


    
    // public function repeaters(RepeaterBuilder $repeater_builder): void {}
    
    // public function customActions(CustomActionBuilder $custom_action_builder): void {}

    // public function reports(ReportBuilder $report_builder): void {}

    // public function pages(PageBuilder $page_builder): void {}

    // public function widgets(WidgetBuilder $widget_builder): void {}    
}
