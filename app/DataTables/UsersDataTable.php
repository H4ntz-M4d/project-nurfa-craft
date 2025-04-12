<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\SearchPane;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn() // Menambahkan nomor urut
            ->addColumn('action', function () {
                return 
                '<button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                	<!--begin::Menu item-->
                	<div class="menu-item px-3">
                		<a href="apps/customers/view.html" class="menu-link px-3">View</a>
                	</div>
                	<!--end::Menu item-->
                	<!--begin::Menu item-->
                	<div class="menu-item px-3">
                		<a href="#" class="menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
                	</div>
                	<!--end::Menu item-->
                </div>'
                ;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->select('id','username','email','created_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('usersTable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0,'descending')
                    ->searchPanes(SearchPane::make())
                    ->parameters([
                        'dom' => '
                        <"row mb-3 justify-content-between align-items-center" 
                            <"col-lg-4 col-md-6 col-12 text-md-start text-center"PB>
                            <"col-lg-4 col-md-6 col-12"f> 
                        >
                        <"table-wrapper"
                            <"table-responsive"t>
                        >
                        <"row mt-3 justify-content-between"
                            <"col-md-6 col-12"i> 
                            <"col-md-2 col-12 text-md-end text-center"p>
                        >',
                        'pageLength' => 10,
                        'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]], // Pilihan dropdown,
                        'drawCallback' => 'function() { KTMenu.createInstances(); }'
                    ])
                    ->buttons([
                        Button::make('excel')
                            ->text('<i class="fas fa-file-excel"></i>')
                            ->titleAttr('Export to Excel')
                            ->className('btn btn-success btn-sm'),
                        Button::make('pdf')
                            ->text('<i class="fas fa-file-pdf"></i>')
                            ->titleAttr('Export to PDF')
                            ->className('btn btn-danger btn-sm'),
                        Button::make('print')
                            ->text('<i class="fas fa-print"></i>')
                            ->titleAttr('Print')
                            ->className('btn btn-dark btn-sm'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('No'),
            Column::make('username'),
            Column::make('email'),
            Column::make('created_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
