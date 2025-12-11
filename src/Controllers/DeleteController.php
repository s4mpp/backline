<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use S4mpp\Backline\Support\Activity;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\Backline\Builders\FormBuilder;
use S4mpp\Backline\Enums\ActivityAction;
use Illuminate\Validation\ValidationException;

final class DeleteController extends Controller
{
    public function index(Request $request, Resource $resource, int $id)
    {
        $model = $resource->getModel();
        
        $register = $model::query()->findOrFail($id);

        // $hidden_filter = ['filters' => $request->get('filters'), '_f' => $request->get('_f'), 'per_page' => $request->get('per_page')];

        // $redirect_back = to_route($resource->getRouteName('index'), $hidden_filter);

        if (! $register->delete()) {
            throw ValidationException::withMessages(['failed_deletion' => 'Falha ao excluir o registro']);
        }

        // $this->saveLog($register, $resource);

        return redirect()->back()->with('message', 'Registro excluído com sucesso.');
    }

    // TODO transaction DB
    // public function bulkDelete(Request $request, Resource $resource)
    // {
    //     $hidden_filter = ['filters' => $request->get('filters'), '_f' => $request->get('_f'), 'per_page' => $request->get('per_page')];

    //     $redirect_back = to_route($resource->getRouteName('index'), $hidden_filter);

    //     try {

    //         $ids = request()->input('ids');

    //         $ids = array_filter(explode(',', $ids));

    //         if (empty($ids)) {
    //             throw new Exception('Nenhum registro selecionado.');
    //         }

    //         if(count($ids) > 15) {
    //             throw new Exception('Limite de 15 registros por vez.');
    //         }

    //         $total = 0;

    //         $registers = $resource->getModel()->find($ids);

    //         foreach($registers as $register)
    //         {
    //             if($register->delete()) {
    //                 $total++;
    //                 $this->saveLog($register, $resource);
    //             }
    //         }

    //         return $redirect_back->with('message', $total.' registro(s) excluído(s) com sucesso.');
    //     } catch (Exception $e) {
    //         return $redirect_back->withErrors($e->getMessage(), 'exception');
    //     }
    // }

    // private function saveLog($register, Resource $resource)
    // {
    //     $log = (new Activity(ActivityAction::Delete, $register->id));

    //     $inputs = $resource->collectElements(new FormBuilder());

    //     foreach ($inputs as $input) {
    //         $name = $input->getFieldName();

    //         $log->setOriginalData($input->getTitle(), $register->getRawOriginal($name));
    //     }

    //     $log->setResource($resource->getName())->save(true);
    // }
}
