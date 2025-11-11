<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Models\Log;
use S4mpp\Backline\Enums\Action;
use S4mpp\Backline\Utils\Alpine;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\Backline\Builders\ReadBuilder;
use S4mpp\Backline\Builders\RepeaterBuilder;
use S4mpp\Backline\Builders\CustomActionBuilder;

final class ReadController extends Controller
{
    public function index(Resource $resource, int $id)
    {
        $breadcrumbs = [$resource->getSectionLabel(), $resource->getTitle(), $id];

        $register = $resource->getModel()->findOrFail($id);

        $read = new ReadBuilder($register);

        $resource->read($read);

        $groups = $read->getItems();
        

        return view('backline::resources.read', compact('register', 'groups', 'breadcrumbs', 'read'));
    }
    // {
    //     $register = $resource->getModel()->findOrFail($id);

    //     $custom_action = new CustomActionBuilder();

    //     if (method_exists($resource, 'customActions')) {

    //         $resource->customActions($custom_action);
    //     }

    //     $custom_actions = $custom_action->getItemsFilteredByPermissions($resource);

    //     $custom_action_alpine_data = [];

    //     foreach ($custom_actions as $custom_action) {
    //         $custom_action->validate($register);

    //         if ($custom_action->hasConfirmation() && $custom_action->isValid()) {
    //             $custom_action_alpine_data[] = Alpine::parse('modalConfirm'.$custom_action->getSlug(true), false);
    //         }
    //     }

    //     $read = new ReadBuilder($register);

    //     if (method_exists($resource, 'read')) {

    //         $resource->read($read);
    //     }

    //     $groups = $read->getGroups();

    //     $panels = $read->getPanels();

    //     $label = $resource->getLabel();

    //     if (! empty($label)) {
    //         $label_register = $register[$label] ?? null;
    //     }

    //     if (! isset($label_register) || ! $label_register) {
    //         $label_register = '#'.Str::padLeft($id, 5, '0');
    //     }

    //     $repeater = new RepeaterBuilder();

    //     if (method_exists($resource, 'repeaters')) {

    //         $resource->repeaters($repeater);
    //     }

    //     $repeaters = $repeater->getItems();

    //     $activity_log = collect([]);

    //     if (AdminPanel::saveLogsInDatabase()) {
    //         $activity_log = Log::latest('id')
    //             ->where('resource', $resource->getName())
    //             ->where('register_id', $id)
    //             ->with(['user:id,name'])
    //             ->limit(15)->get();
    //     }

        
    //     $user = Auth::guard(AdminPanel::getGuardName())->user();
        
    //     $can_update = $resource::hasAction(Action::Update) && $user->can($resource::getPermissionName('action', 'update'));
        
    //     $breadcrumbs = [$resource->getSectionLabel(), $resource->getTitle()];

    //     return view('admin::resources.read', compact('resource', 'groups', 'can_update', 'register', 'breadcrumbs', 'custom_actions', 'panels', 'repeaters', 'custom_action_alpine_data', 'activity_log'));
    // }
}
