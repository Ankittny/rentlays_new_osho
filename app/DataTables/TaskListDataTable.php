<?php

namespace App\DataTables;

use App\Models\TaskList;
use Yajra\DataTables\Services\DataTable;
use Common;

class TaskListDataTable extends DataTable
{
    /**
     * Process the AJAX response for the datatable.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function ajax()
    {
        return datatables()
            ->of($this->query())
            ->editColumn('date', function ($item) {
                return ucwords(strtolower($item->date));
            })
            ->addColumn('image', function ($item) {
                if ($item->image) {
                    return '<a href="' . url('public/uploads/task_files/' . $item->image) . '" download>
                                <img src="' . url('public/uploads/task_files/' . $item->image) . '" alt="Pan Card" style="width: 60px; height: 60px;"/>
                            </a>';
                }
                return 'No Image';
            })
            ->editColumn('task_status', function ($item) {
                return ucwords(strtolower($item->task_status));
            })
            ->editColumn('property.name', function ($item) {
                return ucwords(strtolower($item->property->name));
            })
            ->addColumn('action', function ($taskList) {
                $edit = '';
                $delete = '';

                $admin = auth('admin')->user();
                if (Common::has_permission($admin->id, 'edit_task_list')) {
                    $edit = '<a href="' . url('admin/edit-task-list/' . $taskList->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }

                if (Common::has_permission($admin->id, 'delete_task_list')) {
                    $delete = '<a href="' . url('admin/delete-task-list/' . $taskList->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }

                return $edit . $delete;
            })
            ->rawColumns(['image','action'])->make(true);
    }

    /**
     * Prepare the query for the datatable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = TaskList::with('property:name,id')->select([
            'task_lists.id',
            'task_lists.date',
            'task_lists.image',
            'task_lists.task_status',
            'task_lists.property_id'
        ]);
        return $this->applyScopes($query);
    }

    /**
     * Build the HTML structure for the datatable.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns([
                ['data' => 'property.name', 'name' => 'property.name', 'title' => 'Property Name'],
                ['data' => 'date', 'name' => 'date', 'title' => 'Date'],
                ['data' => 'image', 'name' => 'image', 'title' => 'Image'],
                ['data' => 'task_status', 'name' => 'task_status', 'title' => 'Task Status'],
            ])->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ;
    }

    /**
     * Get the filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'tasklistsdatatables_' . time();
    }
}

