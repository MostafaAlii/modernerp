<?php
namespace App\Repositories\Contracts;

use App\DataTables\Dashboard\Admin\SizeDataTable;
use App\Models\Size;
use App\Http\Requests\Dashboard\Size\StoreSizeRequest;

interface SizeRepositoryInterface
{
    public function index(SizeDataTable $sizeDataTable);
    public function store(StoreSizeRequest $request);
    public function update(Size $size, array $data): Size;
    public function delete(Size $size): array;
}