<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\CategoryDataTable;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use App\Http\Requests\Dashboard\Category\StoreCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryDataTable $categoryDataTable,
        protected CategoryRepositoryInterface $categoryInterface
    ) {}

    public function index()
    {
        return $this->categoryInterface->index($this->categoryDataTable);
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryInterface->store($request);
    }

    public function update(Request $request, Category $category)
    {
        try {

            $this->categoryInterface->update(
                $category,
                $request->all()
            );

            return redirect()
                ->route('admin.categories.index')
                ->with('success', trans('dashboard/categories.updated_successfully'));

        } catch (\Exception $e) {

            return redirect()
                ->route('admin.categories.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function destroy(Category $category) {
        $result = $this->categoryInterface->delete($category);
        if ($result['status']) {
            return redirect()->route('admin.categories.index')->with('success', trans('dashboard/categories.deleted_successfully'));
        }
        return match ($result['message'] ?? 'ERROR') {
            'HAS_CHILDREN' => redirect()->route('admin.categories.index')->with('error', trans('dashboard/categories.cannot_delete_with_children')),
            default => redirect()->route('admin.categories.index')->with('error', trans('dashboard/general.error_occurred')),
        };
    }
}
