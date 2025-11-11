<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Form\File;
use S4mpp\Backline\Enums\Action;
use Illuminate\Routing\Controller;
use S4mpp\AdminPanel\Utils\Alpine;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\AdminPanel\Support\Activity;
use Illuminate\Support\Facades\Storage;
use S4mpp\Backline\Builders\FormBuilder;
use Illuminate\Support\Facades\Validator;
use S4mpp\AdminPanel\Enums\ActivityAction;
use S4mpp\Backline\DataTransfer\Persistor;
use Illuminate\Validation\ValidationException;
use S4mpp\AdminPanel\Builders\RepeaterBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class UpdateController extends Controller
{
    public function index(Resource $resource, int $id)
    {
        $form = (new FormBuilder(Action::Update))->collect($resource);
            
        $groups = $form->getGroups();

        $register = $resource->getModel()->findOrFail($id);
        
        $action = route($resource->getRouteName('action', 'update', 'save'), $id);
        
        $breadcrumbs = [$resource->getSectionLabel(), $resource->getTitle(), $id];
        
        $title = 'Editar';

        $method = 'PUT';

        return view('backline::resources.form', compact('title', 'breadcrumbs', 'groups', 'action', 'method', 'register'));
    }

    public function save(Request $request, Resource $resource, int $id)
    {
        $model = $resource->getModel();

        $register = $model->findOrFail($id);

        $form = (new FormBuilder(Action::Update))->collect($resource);

        $persistor = new Persistor($form, $model, $request->input());

        $persistor->setRegister($register);

        $validated_data = $persistor->validate();

        $persistor->save($validated_data);

        return to_route($resource->getRouteName('action', 'index'))->with('message', 'Registro alterado com sucesso.');        
    }
}
