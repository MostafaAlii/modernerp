<script>
    let itemIndex = 0;

document.getElementById('addItemBtn').addEventListener('click', function () {
    addItem();
});

function addItem(existingData = null) {
    const template  = document.getElementById('itemTemplate').innerHTML;
    const html      = template.replaceAll('__INDEX__', itemIndex);
    const container = document.getElementById('itemsContainer');

    container.insertAdjacentHTML('beforeend', html);

    const rows    = container.querySelectorAll('.item-row');
    const newRow  = rows[rows.length - 1];

    // لو بيعدل — املى البيانات
    if (existingData) {
        newRow.querySelector('.variant-select').value = existingData.product_variant_id;
        newRow.querySelector('.unit-select').value    = existingData.sales_unit_id;
        newRow.querySelector('.item-qty').value       = existingData.quantity;
        newRow.querySelector('.item-price').value     = existingData.unit_price;
        newRow.querySelector('.item-total').textContent = parseFloat(existingData.total_price).toFixed(2);
    }

    // زرار الحذف
    newRow.querySelector('.remove-item-btn').addEventListener('click', function () {
        newRow.remove();
        updateRowNumbers();
        calcTotals();
    });

    updateRowNumbers();
    calcTotals();
    itemIndex++;
}

// لما يغير الـ sales unit → ابحث عن السعر تلقائياً
function autoFillPrice(unitSelect) {
    const row          = unitSelect.closest('.item-row');
    const variantSelect = row.querySelector('.variant-select');
    const priceInput   = row.querySelector('.item-price');

    const selectedOption = variantSelect.options[variantSelect.selectedIndex];
    if (!selectedOption || !selectedOption.dataset.prices) return;

    const prices     = JSON.parse(selectedOption.dataset.prices);
    const salesUnitId = unitSelect.value;

    if (prices[salesUnitId]) {
        priceInput.value = prices[salesUnitId];
        calcRowTotal(priceInput);
    }
}

function calcRowTotal(input) {
    const row   = input.closest('.item-row');
    const qty   = parseFloat(row.querySelector('.item-qty').value)   || 0;
    const price = parseFloat(row.querySelector('.item-price').value) || 0;
    const total = qty * price;

    row.querySelector('.item-total').textContent = total.toFixed(2);
    calcTotals();
}

function calcTotals() {
    // جمع كل الـ rows
    let totalAmount = 0;
    document.querySelectorAll('.item-total').forEach(cell => {
        totalAmount += parseFloat(cell.textContent) || 0;
    });

    const discount    = parseFloat(document.getElementById('discountInput').value)    || 0;
    const paidAmount  = parseFloat(document.getElementById('paidAmountInput').value)  || 0;
    const netAmount   = totalAmount - discount;
    const remaining   = netAmount - paidAmount;

    document.getElementById('totalAmount').textContent    = totalAmount.toFixed(2);
    document.getElementById('netAmountDisplay').value     = netAmount.toFixed(2);
    document.getElementById('remainingDisplay').value     = remaining.toFixed(2);

    // لو المتبقي سالب → لون أحمر
    const remainingField = document.getElementById('remainingDisplay');
    remainingField.classList.toggle('text-danger', remaining < 0);
}

function updateRowNumbers() {
    document.querySelectorAll('.item-row').forEach((row, index) => {
        row.querySelector('.item-number').textContent = index + 1;
    });
}
</script>
