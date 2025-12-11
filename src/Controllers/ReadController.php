<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Routing\Controller;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\Backline\Builders\ReadBuilder;

final class ReadController extends Controller
{
    public function index(Resource $resource, int $id)
    {
        $breadcrumbs = [$resource->getSectionLabel(), $resource->getTitle(), $id];

        $model = $resource->getModel();
        
        $register = $model::query()->findOrFail($id);

        $read = new ReadBuilder;

        if(method_exists($resource, 'read')) {
            $resource->read($read);
        }

        $groups = $read->getItems();

        return view('backline::resources.read', compact('register', 'groups', 'breadcrumbs', 'read'));
    }
}
