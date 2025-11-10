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

    public static function getResources(): array
    {
        $path = Config::get('backline.resources_path', app_path('Backline')).'/Resources';

        if (! File::exists($path)) {
            return [];
        }
        
        $resources = [];

        foreach (File::allFiles($path) as $file) {
            $name = str_replace('Resource.php', '', $file->getFilename());

            $resources[$name] = self::getResource($name);
        }

        return $resources;
    }

    public static function getResource(string $name)
    {
        $namespace = Config::get('backline.app_namespace', 'App');

        return $namespace.'\\Backline\\Resources\\'.$name.'Resource';
    }



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

    public static function getRoutePrefix(): string
    {
        return Config::get('backline.prefix', 'backline');
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

    public static function canDisableUsers(): bool
    {
        return Config::get('backline.can_disable_users', false);
    }
}
