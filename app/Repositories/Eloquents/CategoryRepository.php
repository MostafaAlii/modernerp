<?php

namespace App\Repositories\Eloquents;

use App\DataTables\Dashboard\Admin\CategoryDataTable;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\{Category, Company};
use App\Http\Requests\Dashboard\Category\StoreCategoryRequest;
use App\Enums\Category\{CategoryStatus};
use Illuminate\Support\Facades\DB;
class CategoryRepository implements CategoryRepositoryInterface {
    public function index(CategoryDataTable $categoryDataTable) {
        $companies = Company::whereStatus('active')->get(['id', 'name']);
        return $categoryDataTable->render('dashboard.admin.categories.index', [
            'title' => trans('dashboard/categories.categories'),
            'companies' => $companies
        ]);
    }

    public function store(StoreCategoryRequest $request) {
        try {
            DB::beginTransaction();
            $category = Category::create([
                'parent_id' => $request?->parent_id,
                'status' => $request->boolean('status'),
            ]);
            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $category->translateOrNew($locale)->name = $value;
                }
                if (filled($request->short_description[$locale] ?? null)) {
                    $category->translateOrNew($locale)->short_description = $request->short_description[$locale];
                }
                if (filled($request->description[$locale] ?? null)) {
                    $category->translateOrNew($locale)->description = $request->description[$locale];
                }
            }
            $category->save();
            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', trans('dashboard/categories.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.categories.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(Category $category, array $data): Category {
        try {
            DB::beginTransaction();
            // MAIN TABLE UPDATE
            $category->update([
                'parent_id' => $data['parent_id'] ?? $category->parent_id,
                'status'    => $data['status'] ?? $category->status,
            ]);

            // TRANSLATIONS
            if (isset($data['name'])) {
                foreach ($data['name'] as $locale => $name) {
                    if (filled($name)) {
                        $category->translateOrNew($locale)->name = $name;
                    }
                }
            }

            if (isset($data['short_description'])) {
                foreach ($data['short_description'] as $locale => $value) {
                    if (filled($value)) {
                        $category->translateOrNew($locale)->short_description = $value;
                    }
                }
            }
            if (isset($data['description'])) {
                foreach ($data['description'] as $locale => $value) {
                    if (filled($value)) {
                        $category->translateOrNew($locale)->description = $value;
                    }
                }
            }
            $category->save();
            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Category $category): array {
        try {
            DB::beginTransaction();
            if ($category->children()->exists()) {
                return [
                    'status' => false,
                    'message' => 'HAS_CHILDREN',
                ];
            }
            $category->delete();
            DB::commit();
            return [
                'status' => true,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => false,
                'message' => 'ERROR',
            ];
        }
    }
}