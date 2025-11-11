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
use S4mpp\Backline\DataTransfer\DataList;
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

        $table_builder = (new TableBuilder())->collect($resource);

        $columns = $table_builder->getColumns();

        $model = $resource->getModel();

        $registers = (new DataList($table_builder, $model))->getData();

        $actions = [
            'read' => $resource::hasAction(Action::Read),
            'update' => $resource::hasAction(Action::Update),
            'delete' => $resource::hasAction(Action::Delete),
        ];

        return view('backline::resources.list', compact('resource', 'columns', 'breadcrumbs', 'registers', 'actions'));
    }
}
