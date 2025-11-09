<?php

use Illuminate\Support\Str;
use S4mpp\Backline\Backline;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Enums\Action;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\Middleware\Page;
use Illuminate\Support\Facades\Config;
use S4mpp\AdminPanel\Middleware\Module;
use S4mpp\AdminPanel\Middleware\Report;
use S4mpp\Backline\Middleware\Resource;
use S4mpp\AdminPanel\Middleware\Section;
use S4mpp\AdminPanel\Builders\PageBuilder;
use S4mpp\AdminPanel\Builders\ReportBuilder;
use S4mpp\AdminPanel\Middleware\CustomAction;
use S4mpp\Backline\Middleware\RestrictedArea;
use S4mpp\Backline\Controllers\AuthController;
use S4mpp\Backline\Controllers\HomeController;
use S4mpp\AdminPanel\Controllers\LogController;
use S4mpp\AdminPanel\Controllers\PageController;
use S4mpp\AdminPanel\Controllers\ReadController;
use S4mpp\AdminPanel\Controllers\UserController;
use S4mpp\AdminPanel\Middleware\ContextSelected;
use S4mpp\AdminPanel\Controllers\AdminController;
use S4mpp\AdminPanel\Controllers\CreateController;
use S4mpp\AdminPanel\Controllers\DeleteController;
use S4mpp\AdminPanel\Controllers\ReportController;
use S4mpp\AdminPanel\Controllers\UpdateController;
use S4mpp\Backline\Controllers\ResourceController;
use S4mpp\AdminPanel\Controllers\ContextController;
use S4mpp\AdminPanel\Controllers\DashboardController;
use S4mpp\AdminPanel\Controllers\DuplicateController;
use S4mpp\AdminPanel\Controllers\AutomationController;
use S4mpp\AdminPanel\Controllers\IntegrationController;
use S4mpp\AdminPanel\Controllers\CustomActionController;
use S4mpp\Backline\Concerns\Resource as BackLineResource;
use S4mpp\AdminPanel\Controllers\RoleAndPermissionController;

Route::aliasMiddleware('restricted-area', RestrictedArea::class);

$route = Route::middleware('web');

if ($prefix = Backline::getRoutePrefix()) {

    $route->prefix($prefix);
}

if ($domain = Backline::getDomain()) {
    $route->domain($domain);
}

$route->group(function (): void {

    Route::controller(AuthController::class)->group(function (): void {

        Route::get('/', 'login')->name('backline.login');
        Route::post('/', 'auth')->name('backline.auth');
        Route::post('/sair', 'logout')->name('backline.logout');
    });

    Route::middleware('restricted-area:'.Backline::getGuardName())->group(function (): void {

        $additional_middlewares = Config::get('backline.middlewares', []);

        // Route::prefix('/sistema')->middleware($additional_middlewares)->group(function (): void {

        //     Route::prefix('/permissoes')->middleware('can:AdminConfig.x.config.permissions')->controller(RoleAndPermissionController::class)->group(function (): void {
        //         Route::get('/', 'index')->name('admin.roles-and-permissions');

        //         Route::post('/criar-grupo', 'createRole')->name('admin.roles-and-permissions.roles.create');
        //         Route::put('/alterar-grupo/{id}', 'updateRole')->name('admin.roles-and-permissions.roles.update');
        //         Route::delete('/excluir-grupo/{id}', 'deletePermission')->name('admin.roles-and-permissions.roles.delete');

        //         Route::get('/grupo/{id}/permissoes', 'rolePermissions')->name('admin.roles-and-permissions.roles.permissions');
        //         Route::put('/grupo/{id}/salvar-permissoes', 'saveRolePermissions')->name('admin.roles-and-permissions.roles.save-permissions');

        //         Route::post('/criar-permissao', 'createPermission')->name('admin.roles-and-permissions.permissions.create');
        //         Route::put('/alterar-permissao/{id}', 'updatePermission')->name('admin.roles-and-permissions.permissions.update');
        //         Route::delete('/excluir-permissao/{id}', 'deletePermission')->name('admin.roles-and-permissions.permissions.delete');
        //     });

        //     Route::prefix('/usuarios')->middleware('can:AdminConfig.x.config.users')->controller(UserController::class)->group(function (): void {
        //         Route::get('/', 'index')->name('admin.users');
        //         Route::get('/detalhes/{id}', 'details')->name('admin.users.details');
        //         Route::post('/cadastrar', 'create')->name('admin.users.create');
        //         Route::put('/editar/{id}', 'update')->name('admin.users.update');
        //         Route::put('/atribuir-grupos/{id}', 'saveRoles')->name('admin.users.save-roles');
        //         Route::post('/gerar-senha/{id}', 'generatePassword')->name('admin.users.generate-password');
                
        //         Route::get('/atribuir-permissoes/{id}', 'setPermissions')->name('admin.users.set-permissions');
        //         Route::put('/atribuir-permissoes/{id}', 'savePermissions')->name('admin.users.save-permissions');
        //     });
        // });

        Route::middleware($additional_middlewares)->group(function (): void {

            Route::get('/home', HomeController::class)->name('backline.home.index');

        //     Route::middleware(Module::class)->group(function (): void {
        //         foreach (AdminPanel::getModules() as $module) {
        //             Route::get($module->getSlug(), [HomeController::class, 'section'])->name('admin.section.'.$module->getSlug());
        //         }

                Route::middleware(Resource::class)->group(function (): void {

                    $resources = Backline::getResources();

                    /** @var BackLineResource $resource */
                    foreach ($resources as $resource) {

                        $r = new $resource;

                        $section = $r->getSection();

                        Route::prefix($section.'/'.$resource::getSlug())->group(function () use ($r, $resource): void {

                            Route::get('/', [ResourceController::class, 'index'])->name($resource::getRouteName('action', 'index'));
        //                     Route::get('/exportar/{format}', [ResourceController::class, 'export'])->middleware('can:'.$resource::getPermissionName('resource', 'export'))->name($resource::getRouteName('export'));

        //                     foreach((new ReportBuilder)->collect($r)->getItems() as $report)
        //                     {
        //                         Route::get($report->getSlug(), [ReportController::class, 'index'])->middleware(Report::class)->name($resource::getRouteName('action', 'report', $report->getSlug()));
        //                         Route::get($report->getSlug().'/exportar/{format}', [ReportController::class, 'export'])->middleware(Report::class)->name($resource::getRouteName('action', 'report', 'export', $report->getSlug()));
        //                     }


        //                     if ($resource::hasAction(Action::Create)) {
        //                         Route::prefix('/cadastrar')->controller(CreateController::class)->middleware('can:'.$resource::getPermissionName('action', 'create'))->group(function () use ($resource): void {
        //                             Route::get('/', 'index')->name($resource::getRouteName('action', 'create'));
        //                             Route::post('/', 'save')->name($resource::getRouteName('action', 'create', 'save'));
        //                         });
        //                     }

        //                     if ($resource::hasAction(Action::Update)) {
        //                         Route::prefix('/editar/{id}')->controller(UpdateController::class)->middleware('can:'.$resource::getPermissionName('action', 'update'))->group(function () use ($resource): void {
        //                             Route::get('/', 'index')->name($resource::getRouteName('update'));
        //                             Route::put('/', 'save')->name($resource::getRouteName('update.save'));
        //                         });
                                
        //                         //TODO habilitar automacao no config
        //                         Route::prefix('/automacoes')->controller(AutomationController::class)->middleware('can:'.$resource::getPermissionName('action', 'update'))->group(function () use ($resource): void {
        //                             Route::get('/', 'index')->name($resource::getRouteName('automations'));
        //                             Route::get('/criar', 'create')->name($resource::getRouteName('automations.create-automation'));
        //                             Route::post('/criar', 'save')->name($resource::getRouteName('automations.create-automation.save'));
        //                             Route::delete('/{id}/excluir', 'delete')->name($resource::getRouteName('automations.delete'));
        //                             Route::post('/criar-em-massa', 'createInBulk')->name($resource::getRouteName('automations.create-in-bulk'));
        //                         });
        //                     }


        //                     if ($resource::hasAction(Action::Read)) {
        //                         Route::get('/visualizar/{id}', [ReadController::class, 'index'])->middleware('can:'.$resource::getPermissionName('action', 'read'))->name($resource::getRouteName('read'));
        //                     }

        //                     if ($resource::hasAction(Action::Duplicate)) {
        //                         Route::post('/duplicar/{id}', [DuplicateController::class, 'save'])->middleware('can:'.$resource::getPermissionName('action', 'create'))->name($resource::getRouteName('duplicate'));
        //                     }

        //                     if ($resource::hasAction(Action::Delete)) {
        //                         Route::delete('/excluir/{id}', [DeleteController::class, 'index'])->middleware('can:'.$resource::getPermissionName('action', 'delete'))->name($resource::getRouteName('delete'));
        //                         Route::delete('/excluir-varios', [DeleteController::class, 'bulkDelete'])->middleware('can:'.$resource::getPermissionName('action', 'delete'))->name($resource::getRouteName('delete.bulk'));
        //                     }

        //                     // Route::prefix('/relatorio')->controller(ReportController::class)->middleware(Report::class)->group(function () use ($resource): void {
        //                     //     Route::get('/{slug}', 'index')->name($resource::getRouteName('report'));
        //                     //     Route::get('/exportar/{format}/{slug}', 'export')->name($resource::getRouteName('report', 'export'));
        //                     // });

        //                     Route::put('/acao/{id}/{slug}', [CustomActionController::class, 'execute'])->middleware(CustomAction::class)->name($resource::getRouteName('custom-action'));
        //                     Route::put('/acao-varios/{slug}', [CustomActionController::class, 'bulkExecute'])->middleware(CustomAction::class)->name($resource::getRouteName('custom-action.bulk'));

        //                     // Route::get('/{slug}', [PageController::class, 'index'])->middleware(Page::class)->name($resource::getRouteName('page'));

                            
                            
                            
        //                     foreach((new PageBuilder)->collect($r)->getItems() as $page) {
        //                         Route::get('/pagina/'.$page->getSlug(), [PageController::class, 'index'])->middleware(Page::class)->name($resource::getRouteName('page', $page->getSlug()));
        //                     }
                            
                        });
                    }
                // });
            });
        });
    });
});
