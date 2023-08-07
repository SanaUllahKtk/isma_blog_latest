<?php

namespace App\DataTables;

use App\Models\Blog;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
      
        return datatables()
            ->eloquent($query)
            ->addColumn('name', function ($data) {
                return $data->first_name . ' ' . $data->last_name;
            })
            ->editColumn('created_at', function ($data) {
                return  date("M jS, Y h:i A", strtotime($data->created_at));
            })

            ->editColumn('description', function ($data) {
                $id = 'blog-' . $data->id;
                $title = 'Blog Description';
                $body = $data->description;
                return view('content.table-component.modal', compact('id', 'body', 'title'));
            })
            ->editColumn('image', function ($data) {
                $image = $data->image ?? 'images/avatars/1-small.png';
                return  view('content.table-component.avatar', compact('image'));
            })
            ->addColumn('status', function ($data) {
                if (auth()->user()->isAdmin !== '1') {
                    $status = '';
                    if ($data->status === 'active') {
                        $status = '<span class="badge badge-pill badge-light-success">Active</span>';
                    } elseif ($data->status === 'inactive') {
                        $status = '<span class="badge badge-pill badge-light-danger">Inactive</span>';
                    }
                    return $status;
                }
                $route = route('admin.blogs.status');
                return view('content.table-component.switch', compact('data', 'route'));
            })
            ->editColumn('delete', function ($data) {
                if (auth()->user()->isAdmin !== '1') {
                    $route = route('dashboard.blog.delete', $data->id);
                } else {
                    $route = route('admin.blog.delete', $data->id);
                }
                $data = ['delete' => $route];
                $class = 'btn-icon btn-icon rounded-circle btn-danger';
                $icon = '<svg aria-hidden="true" focusable="false" data-prefix="fa-duotone" data-icon="trash-can" class="svg-inline--fa fa-trash-can fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><g class="fa-group"><path class="fa-primary" d="M432 32H320l-11.58-23.16c-2.709-5.42-8.25-8.844-14.31-8.844H153.9c-6.061 0-11.6 3.424-14.31 8.844L128 32H16c-8.836 0-16 7.162-16 16V80c0 8.836 7.164 16 16 16h416c8.838 0 16-7.164 16-16V48C448 39.16 440.8 32 432 32z" fill="currentColor"/><path class="fa-secondary" d="M32 96v368C32 490.5 53.5 512 80 512h288c26.5 0 48-21.5 48-48V96H32zM144 416c0 8.875-7.125 16-16 16S112 424.9 112 416V192c0-8.875 7.125-16 16-16S144 183.1 144 192V416zM240 416c0 8.875-7.125 16-16 16S208 424.9 208 416V192c0-8.875 7.125-16 16-16s16 7.125 16 16V416zM336 416c0 8.875-7.125 16-16 16s-16-7.125-16-16V192c0-8.875 7.125-16 16-16s16 7.125 16 16V416z" fill="currentColor"/></g></svg>';
                return   $delete = view('content.table-component.button', compact('data', 'icon', 'class'));
            })
            ->escapeColumns('status', 'delete');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Blog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Blog $model)
    {

        $model =  $model->newQuery();

        if (auth()->user()->isAdmin !== '1') {
            $model->where('user_id', auth()->user()->id);
        } else {
            if ($this->blogs === 'true') {
                $model->where('user_id', auth()->user()->id);
            } else {
                $model->where('user_id', '!=', auth()->user()->id);
            }
        }


        $model->with(['user']);

        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('blog-table')
            ->columns($this->getColumns())
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
            Column::make('id'),
            Column::make('title'),
            Column::make('image'),
            Column::make('user.name')
                ->title('Author'),
            Column::make('description'),
            Column::computed('delete')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('created_at'),
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
        return 'Blog_' . date('YmdHis');
    }
}
