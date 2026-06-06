<?php
namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Color;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ColorDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Color);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))

            ->addColumn('action', function (Color $color) {
                return view('dashboard.admin.colors.btn.actions', compact('color'));
            })

            ->editColumn('name', function (Color $color) {
                return $color->translate(app()->getLocale())?->name
                    ?? $color->translate('ar')?->name
                    ?? '-';
            })

            // COLOR PREVIEW
            ->editColumn('hex_code', function (Color $color) {
                return '
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <span style="
                            display:inline-block;
                            width:28px;
                            height:28px;
                            border-radius:50%;
                            background-color:' . e($color->hex_code) . ';
                            border:1px solid #dee2e6;
                        "></span>
                        <span class="text-muted small">' . e($color->hex_code) . '</span>
                    </div>
                ';
            })

            ->editColumn('status', function (Color $color) {
                return '
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="badge-status">' . $color->status->badge() . '</span>
                    </div>
                ';
            });

        if (EnsureOwner::check()) {
            $dataTable->editColumn('company', function (Color $color) {
                return $color->company?->name ?? '-';
            });
        }

        $dataTable
            ->editColumn('created_at', function (Color $color) {
                return $this->formatTranslatedDate($color->created_at);
            })
            ->editColumn('updated_at', function (Color $color) {
                return $this->formatTranslatedDate($color->updated_at);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'hex_code', 'created_at', 'updated_at']);

        return $dataTable;
    }

    public function query(): QueryBuilder
    {
        $query = Color::query()
            ->with(['translations'])
            ->latest();

        if (EnsureOwner::check()) {
            $query->with(['company']);
        }

        return $query;
    }

    public function getColumns(): array
    {
        $columns = [
            [
                'name'      => 'DT_RowIndex',
                'data'      => 'DT_RowIndex',
                'title'     => '#',
                'className' => 'text-center',
                'orderable' => false,
            ],
            [
                'name'       => 'name',
                'data'       => 'name',
                'title'      => trans('dashboard/colors.name'),
                'className'  => 'text-center',
                'searchable' => false,
            ],
            [
                'name'       => 'hex_code',
                'data'       => 'hex_code',
                'title'      => trans('dashboard/colors.hex_code'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
            [
                'name'       => 'status',
                'data'       => 'status',
                'title'      => trans('dashboard/colors.is_active'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
        ];

        /*if (EnsureOwner::check()) {
            $columns[] = [
                'name'       => 'company',
                'data'       => 'company',
                'title'      => trans('dashboard/colors.company'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ];
        }*/

        $columns[] = [
            'name'      => 'created_at',
            'data'      => 'created_at',
            'title'     => trans('dashboard/general.created_at'),
            'className' => 'text-center',
        ];

        $columns[] = [
            'name'      => 'updated_at',
            'data'      => 'updated_at',
            'title'     => trans('dashboard/general.updated_at'),
            'className' => 'text-center',
        ];

        $columns[] = [
            'name'       => 'action',
            'data'       => 'action',
            'title'      => trans('dashboard/general.actions'),
            'className'  => 'text-center',
            'orderable'  => false,
            'searchable' => false,
        ];

        return $columns;
    }
}