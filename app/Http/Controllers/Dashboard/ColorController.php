<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\ColorDataTable;
use App\Repositories\Contracts\ColorRepositoryInterface;
use App\Models\Color;
use App\Http\Requests\Dashboard\Color\StoreColorRequest;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function __construct(
        protected ColorDataTable $colorDataTable,
        protected ColorRepositoryInterface $colorInterface
    ) {}

    public function index()
    {
        return $this->colorInterface->index($this->colorDataTable);
    }

    public function store(StoreColorRequest $request)
    {
        return $this->colorInterface->store($request);
    }

    public function update(Request $request, Color $color)
    {
        try {
            $this->colorInterface->update($color, $request->all());

            return redirect()->route('admin.colors.index')
                ->with('success', trans('dashboard/colors.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('admin.colors.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function destroy(Color $color)
    {
        $result = $this->colorInterface->delete($color);

        if ($result['status']) {
            return redirect()->route('admin.colors.index')
                ->with('success', trans('dashboard/colors.deleted_successfully'));
        }

        return redirect()->route('admin.colors.index')
            ->with('error', trans('dashboard/general.error_occurred'));
    }
}