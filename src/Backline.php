<?php

namespace S4mpp\Backline;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use S4mpp\AdminPanel\Navigation\Module;

abstract class Backline
{
    // private static array $modules = [];

    // public static function getContextConfig()
    // {
    //     $namespace = Config::get('admin.namespace', 'App');

    //     $context_config = $namespace.'\\AdminPanel\\ContextConfig';

    //     return $context_config;
    // }

    // public static function getResources(): array
    // {
    //     $path = Config::get('admin.resources_path', app_path('AdminPanel')).'/Resources';

    //     if (! File::exists($path)) {
    //         return [];
    //     }

    //     $namespace = Config::get('admin.namespace', 'App');

    //     $resources = [];

    //     foreach (File::allFiles($path) as $file) {
    //         $name = str_replace('.php', '', $file->getFilename());

    //         $resources[str_replace('Resource', '', $name)] = $namespace.'\\AdminPanel\\Resources\\'.$name;
    //     }

    //     return $resources;
    // }

    // public static function getResource(string $name)
    // {
    //     $namespace = Config::get('admin.namespace', 'App');

    //     return $namespace.'\\AdminPanel\\Resources\\'.$name.'Resource';
    // }

    // public static function createModule(string $title, int $order = 0, ?string $color = null, string $icon = 'squares-2x2'): void
    // {
    //     self::$modules[Str::slug($title)] = new Module($title, max(0, $order), $color, $icon);
    // }

    // public static function getModules(): array
    // {
    //     $main = [
    //         'administrativo' => new Module('Administrativo', 0, config('admin.color', '#1f2937'), 'home'),
    //     ];

    //     return array_merge($main, self::$modules);
    // }

    public static function getGuardName(): string
    {
        return Config::get('backline.guard', 'web');
    }

    public static function getRoutePrefix(): ?string
    {
        return Config::get('backline.prefix');
    }

    public static function getDomain(): ?string
    {
        return Config::get('backline.domain');
    }

    // /**
    //  * @deprecated use getContextModel instead
    //  */
    // public static function hasContext(): bool
    // {
    //     return Config::get('admin.has_context', false); //TODO context model
    // }

    // public static function getContextModel(): ?string
    // {
    //     return Config::get('admin.context');
    // }

    // public static function saveLogsInDatabase(): bool
    // {
    //     return Config::get('admin.logs', false);
    // }

    // public static function canDisableUsers(): bool
    // {
    //     return Config::get('admin.can_disable_users', false);
    // }
}
