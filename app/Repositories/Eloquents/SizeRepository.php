<?php
namespace App\Repositories\Eloquents;
use App\DataTables\Dashboard\Admin\SizeDataTable;
use App\Repositories\Contracts\SizeRepositoryInterface;
use App\Models\{Size, Company};
use App\Http\Requests\Dashboard\Size\StoreSizeRequest;
use Illuminate\Support\Facades\DB;
class SizeRepository implements SizeRepositoryInterface {
    public function index(SizeDataTable $sizeDataTable) {
        $companies = Company::whereStatus('active')->get(['id', 'name']);
        return $sizeDataTable->render('dashboard.admin.sizes.index', [
            'title'     => trans('dashboard/sizes.sizes'),
            'companies' => $companies,
        ]);
    }

    public function store(StoreSizeRequest $request) {
        try {
            DB::beginTransaction();
            $size = Size::create([
                'status' => $request->boolean('status'),
            ]);
            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $size->translateOrNew($locale)->name = $value;
                }
            }
            $size->save();
            DB::commit();
            return redirect()->route('admin.sizes.index')
                ->with('success', trans('dashboard/sizes.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.sizes.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(Size $size, array $data): Size {
        try {
            DB::beginTransaction();
            $size->update([
                'status' => $data['status'] ?? $size->status,
            ]);
            if (isset($data['name'])) {
                foreach ($data['name'] as $locale => $name) {
                    if (filled($name)) {
                        $size->translateOrNew($locale)->name = $name;
                    }
                }
            }
            $size->save();
            DB::commit();
            return $size;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Size $size): array
    {
        try {
            DB::beginTransaction();
            $size->delete();
            DB::commit();
            return ['status' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status'  => false,
                'message' => 'ERROR',
            ];
        }
    }
}