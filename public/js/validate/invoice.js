document.getElementById('invoiceForm')?.addEventListener('submit', function (e) {

    let isValid = true;
    document.querySelectorAll('.error').forEach(el => el.innerText = '');

    // ===== GET VALUE =====
    const code = document.getElementById('code').value.trim();
    const customer_name = document.getElementById('customer_name').value.trim();
    const phone = document.getElementById('customer_phone').value.trim();
    const address = document.getElementById('customer_address').value.trim();
    const receiver = document.getElementById('receiver_name').value.trim();
    const sale_date = document.getElementById('sale_date').value;
    const invoicer = document.getElementById('invoicer').value.trim();
    const delivery_date = document.getElementById('delivery_date').value;
    const shipping_cost = document.getElementById('shipping_cost').value;
    const status = document.getElementById('status').value;

    const paid_amount = document.getElementById('paid_amount')?.value || '';
    const debt_date = document.getElementById('dubt_due_date')?.value;

    const isGuest = document.getElementById('guestCustomer')?.checked;

    // ===== REQUIRED (FIX status=0) =====
    function required(value, field, label) {
        if (value === '' || value === null) {
            document.getElementById('error-' + field).innerText = label + ' không được để trống';
            return false;
        }
        return true;
    }

    if (!required(code, 'code', 'Mã hóa đơn')) isValid = false;

    // 👉 nếu KHÔNG phải khách ngoài thì mới check
    if (!isGuest) {
        if (!required(customer_name, 'customer_name', 'Khách hàng')) isValid = false;
    }

    if (!required(phone, 'customer_phone', 'SĐT')) isValid = false;
    if (!required(sale_date, 'sale_date', 'Ngày bán')) isValid = false;
    if (!required(invoicer, 'invoicer', 'Người tạo')) isValid = false;
    if (!required(status, 'status', 'Trạng thái')) isValid = false;

    // ===== PHONE =====

    // ===== NUMBER >=0 =====
    function checkNumber(value, field, label) {
        if (value !== '') {
            if (isNaN(value) || Number(value) < 0) {
                document.getElementById('error-' + field).innerText = label + ' phải >= 0';
                return false;
            }
        }
        return true;
    }

    if (!checkNumber(shipping_cost, 'shipping_cost', 'Phí vận chuyển')) isValid = false;
    if (!checkNumber(paid_amount, 'paid_amount', 'Tiền đã trả')) isValid = false;

    // ===== DATE =====
    function checkDate(id, label, required = false) {
        const el = document.getElementById(id);
        if (!el) return true;

        const val = el.value;

        if (required && !val) {
            document.getElementById('error-' + id).innerText = label + ' không được để trống';
            return false;
        }

        if (val && isNaN(Date.parse(val))) {
            document.getElementById('error-' + id).innerText = label + ' không hợp lệ';
            return false;
        }

        return true;
    }

    if (!checkDate('sale_date', 'Ngày bán', true)) isValid = false;
    if (!checkDate('delivery_date', 'Ngày giao')) isValid = false;
    if (!checkDate('dubt_due_date', 'Ngày hẹn trả')) isValid = false;

    // ===== LOGIC NÂNG CAO =====
    if (sale_date && delivery_date) {
        const d1 = new Date(sale_date);
        const d2 = new Date(delivery_date);

        if (!isNaN(d1) && !isNaN(d2) && d2 < d1) {
            document.getElementById('error-delivery_date').innerText = 'Ngày giao phải >= ngày bán';
            isValid = false;
        }
    }

    // ===== DEBUG (nếu vẫn lỗi thì mở console xem) =====
    const itemRows = document.querySelectorAll('#invoice-item-box tbody tr');

if (itemRows.length === 0) {
    alert('Phải có ít nhất 1 sản phẩm trong hoá đơn');
    isValid = false;
}
    // ===== STOP =====
    if (!isValid) {
        e.preventDefault();
    }
});