{{-- treasury_details table --}}
<div class="table-responsive mt-3">
    <table class="table table-sm text-center align-middle" id="deliveryTable{{ $treasury->id }}"
        style="border-collapse: separate; border-spacing: 0;">
        <thead>
            <tr>
                <th
                    style="background:#667eea; color:#fff; font-weight:500; padding: 10px; border:1px solid #667eea; text-align:center;">
                    #</th>
                <th
                    style="background:#667eea; color:#fff; font-weight:500; padding: 10px; border:1px solid #667eea; text-align:center;">
                    {{ trans('dashboard/treasury.delivery_treasury') }}
                </th>
                <th
                    style="background:#667eea; color:#fff; font-weight:500; padding: 10px; border:1px solid #667eea; text-align:center;">
                    {{ trans('dashboard/treasury.added_by') }}
                </th>
                <th
                    style="background:#667eea; color:#fff; font-weight:500; padding: 10px; border:1px solid #667eea; text-align:center;">
                    {{ trans('dashboard/general.created_at') }}
                </th>
                <th
                    style="background:#667eea; color:#fff; font-weight:500; padding: 10px; border:1px solid #667eea; text-align:center;">
                    {{ trans('dashboard/general.actions') }}
                </th>
            </tr>
        </thead>
        <tbody id="deliveryTableBody{{ $treasury->id }}">
            <tr>
                <td colspan="4" class="text-muted py-3">
                    <i class="fas fa-spinner fa-spin me-1"></i>
                    {{ trans('dashboard/general.loading') }}
                </td>
            </tr>
        </tbody>
    </table>
</div>