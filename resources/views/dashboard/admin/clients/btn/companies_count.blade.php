<a href="{{ route('admin.companies.index', ['client_id' => $client->id]) }}"
    class="badge badge-primary text-primary fs-6 text-decoration-none">
    <i class="fa fa-building"></i>
    {{ $client->companies_count }} {{ trans('dashboard/client.companies') }}
</a>