<?php

namespace S4mpp\Backline\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Workbench\App\Models\User;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\Backline\Enums\Action;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Utils\Query;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use S4mpp\AdminPanel\Utils\Alpine;
use Workbench\App\Models\BasicItem;
use Illuminate\Support\Facades\Auth;
use S4mpp\AdminPanel\Utils\Searcher;
use S4mpp\Backline\Concerns\Resource;
use S4mpp\AdminPanel\Enums\ExportType;
use S4mpp\AdminPanel\Models\Automation;
use S4mpp\AdminPanel\Utils\AccessHistory;
use S4mpp\Backline\Builders\TableBuilder;
use S4mpp\Backline\Services\DataProvider;
use S4mpp\AdminPanel\Builders\PageBuilder;
use S4mpp\AdminPanel\Builders\FilterBuilder;
use S4mpp\AdminPanel\Builders\ReportBuilder;
use S4mpp\AdminPanel\Exports\Csv\CsvExporter;
use S4mpp\AdminPanel\Exports\Pdf\PdfExporter;
use S4mpp\AdminPanel\Exports\Xlsx\XlsxExporter;
use S4mpp\AdminPanel\Builders\CustomActionBuilder;
use S4mpp\AdminPanel\Models\Traits\CanBeAutomatable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ResourceController extends Controller
{
    public function index(Request $request, Resource $resource)
    {
        $breadcrumbs = [$resource->getSectionLabel()];

        $table_builder = new TableBuilder();

        $resource->table($table_builder);

        $columns = $table_builder->getColumns();

        $model = $resource->getModel();

        $registers = (new DataProvider($table_builder, $model))->getData();

        $actions = [
            'read' => $resource::hasAction(Action::Read),
        ];

        return view('backline::resources.list', compact('resource', 'columns', 'breadcrumbs', 'registers', 'actions'));
    }

    // public function index(Request $request, Resource $resource, TableBuilder $table_builder, FilterBuilder $filter_builder, ReportBuilder $report_builder, PageBuilder $page_builder)
    // {
    //     $registers_per_page = $request->get('per_page', 15);

    //     if (method_exists($resource, 'filters')) {
    //         $resource->filters($filter_builder);
    //     }

    //     $filters = $filter_builder->getItems();

    //     if (method_exists($resource, 'table')) {

    //         $resource->table($table_builder);
    //     }

    //     $custom_action = new CustomActionBuilder();

    //     if (method_exists($resource, 'customActions')) {

    //         $resource->customActions($custom_action);
    //     }

    //     $columns = $table_builder->getColumns();

    //     $sort_config = array_filter(explode(',', $request->query('sort')));

    //     $select_fields = Query::getSelectFields($columns);

    //     $with_eager_loading_fields = Query::getEagerLoadingFields($resource->getModel(), $select_fields, $columns);

    //     $sort_fields = Query::getSortFields($table_builder->getOrdenation(), $columns, $sort_config);

    //     $filters_selected = $this->getValuesFilterSelected($filters);

    //     $query = $resource->getModel()->select($select_fields)
    //         ->with($with_eager_loading_fields)
    //         ->where(Query::search('search_'.$resource->getName(), $table_builder->getSearchs()))
    //         ->where(Query::filter($filters, $filters_selected))
    //         ->orderByRaw(...$sort_fields);

    //     if($query_builder_appends = $table_builder->getQueryBuilderAppends()) {
    //         tap($query, $table_builder->getQueryBuilderAppends());
    //     }
            
    //     $registers = $query->paginate($registers_per_page);

    //     if (empty($columns) && $registers->isNotEmpty()) {
    //         foreach (array_keys($registers->first()->getAttributes()) as $attribute) {
    //             $columns[] = new Text($attribute, $attribute);
    //         }
    //     }

    //     $sums = [];

    //     if ($select_fields_to_sum = Query::getSelectFieldsToSum($columns)) {
    //         $sums = $resource->getModel()->select(DB::raw(implode(', ', $select_fields_to_sum)))
    //             ->where(Query::search('search_'.$resource->getName(), $table_builder->getSearchs()))
    //             ->where(Query::filter($filters, $filters_selected))
    //             ->get()->first()->toArray();
    //     }

    //     $custom_actions = array_filter($custom_action->getItemsFilteredByPermissions($resource), fn($custom_action) => $custom_action->allowBulkActions());

    //     $custom_action_alpine_data = [];

    //     foreach ($custom_actions as $custom_action) {

    //         if ($custom_action->hasConfirmation()) {
    //             $custom_action_alpine_data[] = Alpine::parse('modalConfirm'.$custom_action->getSlug(true), false);
    //         }
    //     }

    //     $placeholder_search = Searcher::getMessagePlaceholderSearch($table_builder->getSearchs());

    //     $user = Auth::guard(AdminPanel::getGuardName())->user();

    //     $can_duplicate = $resource::hasAction(Action::Duplicate) && $user->can($resource::getPermissionName('action', 'create'));

    //     $can_read = $resource::hasAction(Action::Read) && $user->can($resource::getPermissionName('action', 'read'));

    //     $can_update = $resource::hasAction(Action::Update) && $user->can($resource::getPermissionName('action', 'update'));

    //     $can_delete = $resource::hasAction(Action::Delete) && $user->can($resource::getPermissionName('action', 'delete'));

    //     $can_export = $user->can($resource::getPermissionName('resource', 'export'));

    //     $delete_message = $resource::getDeleteMessage();

    //     AccessHistory::put($resource->getName(), $resource->getTitle(), route($resource->getRouteName('action', 'index')));

    //     $filters_description = Searcher::getFilterWithDescription($filters, $filters_selected);

    //     $name_labels = [];
        
    //     $first_column = $columns[0] ?? null;

    //     $label = $resource->getLabel();
        
    //     foreach($registers as $register) {
            
    //         if (! empty($label) && $register[$label]) {
    //             $name_labels[$register->id] = $register[$label] ?? null;

    //             continue;
    //         }

    //         if($first_column) {

    //             $first_column->setRegister($register);
                                        
    //             $first_column->setValueFromRegister();
    
    //             $name_labels[$register->id] = $first_column->getValueFormatted();

    //             continue;
    //         }

    //         $name_labels[$register->id] = '#'.$register->id;
    //     }

    //     $model_resource = $resource->getModel();

    //     $total_automations = null;
    //     if(in_array(CanBeAutomatable::class, class_uses_recursive($model_resource))) {
    //         $total_automations = Automation::whereHasMorph('automatable', [$model_resource::class])->count();
    //     }

    //     $has_automations = !is_null($total_automations) && $can_update;

    //     $breadcrumbs = [$resource->getSectionLabel()];
        
    //     return view('admin::resources.list', compact(
    //         'name_labels',
    //         'sort_config',
    //         'can_update',
    //         'can_delete',
    //         'can_export',
    //         'can_read',
    //         'can_duplicate',
    //         'sums',
    //         'columns',
    //         'registers',
    //         'resource',
    //         'filters',
    //         'placeholder_search',
    //         'filters_selected',
    //         'delete_message',
    //         'registers_per_page',
    //         'filters_description',
    //         'total_automations',
    //         'has_automations',
    //         'breadcrumbs',
    //         'custom_actions',
    //         'custom_action_alpine_data',
    //     ));
    // }

    // public function export(Resource $resource, TableBuilder $table_builder, FilterBuilder $filter_builder, string $format): Response|BinaryFileResponse
    // {
    //     if (method_exists($resource, 'filters')) {

    //         $resource->filters($filter_builder);
    //     }

    //     $filters = $filter_builder->getItems();

    //     if (method_exists($resource, 'table')) {

    //         $resource->table($table_builder);
    //     }

    //     $columns = $table_builder->getColumns();

    //     $ordenation = $table_builder->getOrdenation();

    //     $select_fields = Query::getSelectFields($columns);

    //     $with_eager_loading_fields = Query::getEagerLoadingFields($resource->getModel(), $select_fields, $columns);

    //     $filters_selected = $this->getValuesFilterSelected($filters, request()->query());

    //     $searchers = $table_builder->getSearchs();

    //     $query = $resource->getModel()
    //         ->select($select_fields)
    //         ->with($with_eager_loading_fields)
    //         ->orderBy($ordenation->getField(), $ordenation->getDirection())
    //         ->where(Query::search('search_'.$resource->getName(), $searchers))
    //         ->where(Query::filter($filters, $filters_selected));

    //     if($query_builder_appends = $table_builder->getQueryBuilderAppends()) {
    //         tap($query, $table_builder->getQueryBuilderAppends());
    //     }

    //     $registers = $query->get();

    //     if (empty($columns) && $registers->isNotEmpty()) {
    //         foreach (array_keys($registers->first()->getAttributes()) as $attribute) {
    //             $columns[] = new Text($attribute, $attribute);
    //         }
    //     }

    //     $export_type = ExportType::from($format);

    //     if ($export_type->rendersSum() && $select_fields_to_sum = Query::getSelectFieldsToSum($columns)) {
    //         $sums = $resource->getModel()->select(DB::raw(implode(', ', $select_fields_to_sum)))
    //             ->where(Query::search('search_'.$resource->getName(), $searchers))
    //             ->where(Query::filter($filters, $filters_selected))
    //             ->get()->first()->toArray();
    //     }

    //     $exporter_class = $export_type->exporter();

    //     /** @var PdfExporter|CsvExporter|XlsxExporter */
    //     $exporter = new $exporter_class($resource->getTitle(), null, $columns);

    //     if ($export_type->hasParams()) {

    //         $filters_description = Searcher::getFilterWithDescription($filters, $filters_selected, true);

    //         $params = [];

    //         foreach($filters_description as  $filter) {
    //             $params[$filter['title']] = $filter['value'] ?? 'Todos';
    //         }

    //         $exporter->params(array_merge(
    //             $params,
    //             Searcher::getSearchDescription(request()->get('search'), Searcher::getMessagePlaceholderSearch($searchers))
    //         ));
    //     }

    //     $exporter->header();

    //     $exporter->body($registers, $sums ?? []);

    //     return $exporter->getFile();
    // }

    // // TODO colocar no Utils/filter
    // private function getValuesFilterSelected(array $filters)
    // {
    //     $values = [];

    //     $is_filtering = boolval(request()->query('_f', false));

    //     foreach ($filters as $filter) {

    //         if (! $is_filtering) {
    //             $term = $filter->getDefaultValue();
    //         } else {
    //             $term = request()->input('filters.'.$filter->getFieldName());
    //         }

    //         $values[$filter->getFieldName()] = $term;
    //     }

    //     return $values;
    // }
}
