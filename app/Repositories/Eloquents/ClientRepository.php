<?php

namespace  App\Repositories\Eloquents;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\ClientDataTable;
use App\Enums\Client\ClientStatus;

class ClientRepository implements ClientRepositoryInterface
{
    public function index(ClientDataTable $clientDataTable)
    {
        return $clientDataTable->render('dashboard.admin.clients.index', ['title' => 'العملاء']);
    }

    public function create()
    {
        return view('dashboard.admin.clients.btn.create', ['title' => 'اضافه عميل']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'email' => 'nullable|email|unique:clients,email',
        ]);
        Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->phone,
            'status'   => ClientStatus::ACTIVE->value,
        ]);
        return redirect()->route('admin.clients.index')->with('success', 'تم حفظ العميل بنجاح!');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('dashboard.admin.clients.btn.edit', ['client' => $client, 'title' => 'تعديل العميل']);
    }

    public function update(Request $request, $id)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
        ]);

        $client = Client::findOrFail($id);
        $client->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        return redirect()->route('admin.clients.index')->with('success', 'تم تحديث العميل بنجاح!');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success', 'تم الحذف بنجاح!');
    }
}