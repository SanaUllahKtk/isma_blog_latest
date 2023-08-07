<?php

namespace App\Console\Commands;

use Clockwork\Storage\Storage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:name {name} {--col} {--namespace=""}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $model = $this->argument('name');
        $name = strtolower($this->argument('name'));
        $cols = explode(',', $this->option('col'));
        $namespace = ($this->option('namespace')) ? 'namespace App\Http\Controllers\Admin\'' . $this->option('namespace') . ';' : 'namespace App\Http\Controllers\Admin;';
        \Artisan::call('make:model -m' . $model);

        $datatableFile = "<?php

namespace App\DataTables;

use App\Models\\$model;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class " . $model . "DataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed \$query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(\$query)
    {
        return datatables()
            ->eloquent(\$query)
            ->addColumn('action', function (\$value) {
                \$edit_route = route('admin." . $name . "s.edit', \$value->id);
                \$edit_callback = 'setValue';
                \$model = '#edit-$name-modal';
                \$delete_route = route('admin." . $name . "s.destroy', \$value->id);
                return view('content.table-component.action', compact('edit_route', 'delete_route', 'edit_callback', 'modal'));
            })
            ->editColumn('created_at', function (\$data) {
                return  '<span class=\"badge badge-primary\">' . date(\"M jS, Y h:i A\", strtotime(\$data->created_at)) . '</span>';
            })";

        if (in_array('image', $cols)) {
            $datatableFile .= "->editColumn('image', function (\$data) {
        \$image = \$data->image ?? 'images/avatars/1-small.png';
        return  view('content.table-component.avatar', compact('image'));
    })";
        }


        $datatableFile .= "->addColumn('status', function (\$data) {
                \$route = route('admin." . $name . "s.status');
                return view('content.table-component.switch', compact('data', 'route'));
            })
            ->escapeColumns('created_at', 'action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\\$model \$model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query($model \$model)
    {
        return \$model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return \$this->builder()
            ->setTableId('$name-table')
            ->columns(\$this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->parameters([
                'scrollX' => true, 'paging' => true,
                'lengthMenu' => [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
            ])
            ->buttons(
                Button::make('csv'),
                Button::make('excel'),
                Button::make('print'),
                Button::make('pageLength'),
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),";

        foreach ($cols as $key => $c) {
            $datatableFile .= "Column::make('$c'),";
        }


        $datatableFile .= "
        Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::computed('status')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return '" . $model . "._' . date('YmdHis');
    }
}";

        $controller = "<?php
$namespace
use Hash;
use App\Models\\" . $model . ";
use Illuminate\Http\Request;
use App\DataTables\\" . $model . "DataTable;
use App\Http\Controllers\Controller;

class " . $model . "Controller extends Controller
{
    public function index(" . $model . "DataTable \$table)
    {
        \$pageConfigs = ['has_table' => true,];
        // \$table->with('id', 1);
        return \$table->render('content.tables." . $name . "s', compact('pageConfigs'));
    }
    public function store(Request \$request)
    {
       
    }
    public function edit(\$id)
    {
        \$doctor = " . $model . "::findOrFail(\$id);
        return response(\$doctor);
    }

    public function update(Request \$request)
    {
       
    }

    public function status(Request \$request)
    {
        \$request->validate([
            'id' => 'required|numeric|exists:" . $name . "s,id',
            'status' => 'required|in:active,inactive',
        ]);

        " . $model . "::findOrFail(\$request->id)->update(['status' => \$request->status]);

        return response([
            'message' => '" . $name . " status updated successfully',
            'table' => '" . $name . "-table',
        ]);
    }

    public function destroy(\$id)
    {
        " . $model . "::findOrFail(\$id)->delete();
        return response([
            'header' => 'Deleted!',
            'message' => '" . $name . " deleted successfully',
            'table' => '" . $name . "-table',
        ]);
    }
}
";







        $blade = `@extends('layouts/contentLayoutMaster')

@section('title', '$model')
@section('page-style')
@endsection

@section('content')

    <section>
        <div class="row match-height">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <x-card>
                    {!! \$dataTable->table() !!}
                </x-card>
            </div>
        </div>
    </section>


    <x-side-modal title="Add ` . $name . `" id="add-` . $name . `-modal">
        <x-form id="add-` . $name . `" method="POST" class="" :route="route('admin.` . $name . `s.store')">
            <div class="col-md-12 col-12 ">
                <x-input name="name" />
            </div>
           </x-form>
    </x-side-modal>
    <x-side-modal title="Update ` . $name . `" id="edit-` . $name . `-modal">
        <x-form id="edit-` . $name . `" method="POST" class="" :route="route('admin.` . $name . `s.update')">

            <div class="col-md-12 col-12 ">
                <x-input name="name" />
                <x-input name="id" type="hidden" />
            </div>
          
        </x-form>
    </x-side-modal>
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $('#` . $name . `-table_wrapper .dt-buttons').append(
                \`<button type="button" data-show="add-` . $name . `-modal" class="btn btn-flat-success waves-effect float-md-right">Add</button>\`
            );
            $(document).on('click', '[data-show]', function() {
                const modal = $(this).data('show');
                $(\`#\${modal}\`).modal('show');
            });
        });

        function setValue(data, modal) {

            $(\`\${modal} #id\`).val(data.id);
            $(\`\${modal} #name\`).val(data.name);
            $(modal).modal('show');
        }
    </script>
@endsection
`;




        //datatable store

        $datatable_path = "app/DataTables/" . $model . "DataTable.php";
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . $datatable_path, "wb");
        fwrite($fp, $datatableFile);
        fclose($fp);
        //controller store
        if (!empty($this->option('namespace'))) {
            $controller_path = "app/Http/Controllers/Admin/" . $this->option('namespace') . "/" . $model . "DataTable.php";
        } else {
            $controller_path = "app/Http/Controllers/Admin/" . $model . "Controller.php";
        }
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . $controller_path, "wb");
        fwrite($fp, $datatableFile);
        fclose($fp);

        //blade store
        $datatable_path = "resources/views/content/tables" . $model . "DataTable.php";
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . $datatable_path, "wb");
        fwrite($fp, $blade);
        fclose($fp);
    }
}
