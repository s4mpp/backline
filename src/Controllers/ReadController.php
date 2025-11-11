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
}
