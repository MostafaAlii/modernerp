<?php

namespace App\Repositories\Contracts;

use App\DataTables\Dashboard\Admin\ClientDataTable;
use Illuminate\Http\Request;
use App\Models\Client;

interface ClientRepositoryInterface
{
    public function index(ClientDataTable $clientDataTable);
    public function create();
    public function store(Request $request);
    public function edit($id);
    public function update(Request $request, $id);
    public function destroy(Client $client);
}