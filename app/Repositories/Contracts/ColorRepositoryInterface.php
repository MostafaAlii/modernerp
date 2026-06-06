<?php
namespace App\Repositories\Contracts;

use App\DataTables\Dashboard\Admin\ColorDataTable;
use App\Models\Color;
use App\Http\Requests\Dashboard\Color\StoreColorRequest;

interface ColorRepositoryInterface
{
    public function index(ColorDataTable $colorDataTable);
    public function store(StoreColorRequest $request);
    public function update(Color $color, array $data): Color;
    public function delete(Color $color): array;
}