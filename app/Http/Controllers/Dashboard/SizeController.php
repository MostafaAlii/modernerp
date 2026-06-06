<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\SizeDataTable;
use App\Repositories\Contracts\SizeRepositoryInterface;
use App\Models\Size;
use App\Http\Requests\Dashboard\Size\StoreSizeRequest;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function __construct(
        protected SizeDataTable $sizeDataTable,
        protected SizeRepositoryInterface $sizeInterface
    ) {}

    public function index()
    {
        return $this->sizeInterface->index($this->sizeDataTable);
    }

    public function store(StoreSizeRequest $request)
    {
        return $this->sizeInterface->store($request);
    }

    public function update(Request $request, Size $size)
    {
        try {
            $this->sizeInterface->update($size, $request->all());

            return redirect()->route('admin.sizes.index')
                ->with('success', trans('dashboard/sizes.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('admin.sizes.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function destroy(Size $size)
    {
        $result = $this->sizeInterface->delete($size);

        if ($result['status']) {
            return redirect()->route('admin.sizes.index')
                ->with('success', trans('dashboard/sizes.deleted_successfully'));
        }

        return redirect()->route('admin.sizes.index')
            ->with('error', trans('dashboard/general.error_occurred'));
    }
}