<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Http\Request;
use S4mpp\Backline\Enums\Action;
use Illuminate\Routing\Controller;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\Backline\Builders\FormBuilder;
use S4mpp\Backline\DataTransfer\Persistor;

final class UpdateController extends Controller
{
    public function index(Resource $resource, int $id)
    {
        $model = $resource->getModel();
        
        $register = $model::query()->findOrFail($id);
        
        $form = (new FormBuilder(Action::Update))->collect($resource);

        $groups = $form->getGroups();

        $action = route($resource->getRouteName('action', 'update', 'save'), $id);

        $breadcrumbs = [$resource->getSectionLabel(), $resource->getTitle(), $id];

        $title = 'Editar';

        $method = 'PUT';

        return view('backline::resources.form', compact('title', 'breadcrumbs', 'groups', 'action', 'method', 'register'));
    }

    public function save(Request $request, Resource $resource, int $id)
    {
        $model = $resource->getModel();
        
        $register = $model::query()->findOrFail($id);

        $form = (new FormBuilder(Action::Update))->collect($resource);

        $persistor = new Persistor($form, $model, $request->input());

        $persistor->setRegister($register);

        $validated_data = $persistor->validate();

        $persistor->save($validated_data);

        return to_route($resource->getRouteName('action', 'index'))->with('message', 'Registro alterado com sucesso.');
    }
}
