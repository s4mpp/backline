<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Http\Request;
use S4mpp\Backline\Enums\Action;
use Illuminate\Routing\Controller;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\Backline\Builders\FormBuilder;
use S4mpp\Backline\DataTransfer\Persistor;

final class CreateController extends Controller
{
    public function index(Resource $resource)
    {
        $form = (new FormBuilder(Action::Create))->collect($resource);

        $groups = $form->getGroups();

        $action = route($resource->getRouteName('action', 'create', 'save'));

        $breadcrumbs = [$resource->getSectionLabel(), $resource->getTitle()];

        $title = 'Cadastrar';

        $method = 'POST';

        return view('backline::resources.form', compact('title', 'breadcrumbs', 'groups', 'action', 'method'));
    }

    public function save(Request $request, Resource $resource)
    {
        $model = $resource->getModel();

        $form = (new FormBuilder(Action::Create))->collect($resource);

        $persistor = new Persistor($form, $model, $request->input());

        $validated_data = $persistor->validate();

        $persistor->save($validated_data);

        return to_route($resource->getRouteName('action', 'index'))->with('message', 'Registro cadastrado com sucesso.');
    }
}
