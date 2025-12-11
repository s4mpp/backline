<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Http\Request;
use S4mpp\Backline\Enums\Action;
use Illuminate\Routing\Controller;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\Backline\Builders\TableBuilder;
use S4mpp\Backline\DataTransfer\DataList;

final class ResourceController extends Controller
{
    public function index(Request $request, Resource $resource)
    {
        $breadcrumbs = [$resource->getSectionLabel()];

        $table_builder = (new TableBuilder)->collect($resource);

        $columns = $table_builder->getColumns();

        $model = $resource->getModel();

        $registers = (new DataList($table_builder, $model))->getPaginated();

        $actions = array_filter([
            'create' => $resource::hasAction(Action::Create),
            'read' => $resource::hasAction(Action::Read),
            'update' => $resource::hasAction(Action::Update),
            'delete' => $resource::hasAction(Action::Delete),
        ]);

        return view('backline::resources.list', compact('resource', 'columns', 'breadcrumbs', 'registers', 'actions'));
    }
}
