<?php
namespace App\Repositories\Eloquents;

use App\DataTables\Dashboard\Admin\ColorDataTable;
use App\Repositories\Contracts\ColorRepositoryInterface;
use App\Models\{Color, Company};
use App\Http\Requests\Dashboard\Color\StoreColorRequest;
use Illuminate\Support\Facades\DB;

class ColorRepository implements ColorRepositoryInterface
{
    public function index(ColorDataTable $colorDataTable)
    {
        $companies = Company::whereStatus('active')->get(['id', 'name']);

        return $colorDataTable->render('dashboard.admin.colors.index', [
            'title'     => trans('dashboard/colors.colors'),
            'companies' => $companies,
        ]);
    }

    public function store(StoreColorRequest $request)
    {
        try {
            DB::beginTransaction();

            $color = Color::create([
                'hex_code' => $request->hex_code,
                'status'   => $request->boolean('status'),
            ]);

            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $color->translateOrNew($locale)->name = $value;
                }
            }

            $color->save();

            DB::commit();
            return redirect()->route('admin.colors.index')
                ->with('success', trans('dashboard/colors.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.colors.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(Color $color, array $data): Color
    {
        try {
            DB::beginTransaction();

            $color->update([
                'hex_code' => $data['hex_code'] ?? $color->hex_code,
                'status'   => $data['status']   ?? $color->status,
            ]);

            if (isset($data['name'])) {
                foreach ($data['name'] as $locale => $name) {
                    if (filled($name)) {
                        $color->translateOrNew($locale)->name = $name;
                    }
                }
            }

            $color->save();

            DB::commit();
            return $color;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Color $color): array
    {
        try {
            DB::beginTransaction();
            $color->delete();
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