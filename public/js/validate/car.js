document.getElementById('carForm')?.addEventListener('submit', function (e) {

    let isValid = true;
    document.querySelectorAll('.error').forEach(el => el.innerText = '');

    // ===== LẤY VALUE =====
    const code = document.getElementById('code').value.trim();
    const name = document.getElementById('name').value.trim();
    const brand = document.getElementById('brand_id').value;
    const engine = document.getElementById('engine_number').value.trim();
    const chassis = document.getElementById('chassis_number').value.trim();
    const payload = document.getElementById('payload').value.trim();
    const supplier = document.getElementById('supplier_id').value;
    const buy_price = document.getElementById('buy_price').value;
    const buy_date = document.getElementById('buy_date').value;
    const warehouse = document.getElementById('warehouse_id').value;
    const sale_status = document.getElementById('sale_status').value;

    // ===== REQUIRED =====
    function required(value, field, label) {
        if (!value) {
            document.getElementById('error-' + field).innerText = label + ' không được để trống';
            return false;
        }
        return true;
    }

    if (!required(code, 'code', 'Mã xe')) isValid = false;
    if (!required(name, 'name', 'Tên xe')) isValid = false;
    if (!required(brand, 'brand_id', 'Hãng')) isValid = false;
    if (!required(engine, 'engine_number', 'Số máy')) isValid = false;
    if (!required(chassis, 'chassis_number', 'Số khung')) isValid = false;
    if (!required(payload, 'payload', 'Trọng tải')) isValid = false;
    if (!required(supplier, 'supplier_id', 'Nhà cung cấp')) isValid = false;
    if (!required(buy_price, 'buy_price', 'Giá nhập')) isValid = false;
    if (!required(buy_date, 'buy_date', 'Ngày nhập')) isValid = false;
    if (!required(sale_status, 'sale_status', 'Trạng thái')) isValid = false;

    // ===== NUMBER (>=0) =====
    function checkNumber(value, field, label) {
        if (value !== '') {
            if (isNaN(value) || Number(value) < 0) {
                document.getElementById('error-' + field).innerText = label + ' phải >= 0';
                return false;
            }
        }
        return true;
    }

    if (!checkNumber(buy_price, 'buy_price', 'Giá nhập')) isValid = false;

    // OPTIONAL number
    if (!checkNumber(document.getElementById('buy_shipping_cost')?.value, 'buy_shipping_cost', 'Phí vận chuyển')) isValid = false;
    if (!checkNumber(document.getElementById('sale_price')?.value, 'sale_price', 'Giá bán')) isValid = false;
    if (!checkNumber(document.getElementById('sale_price_invoices')?.value, 'sale_price_invoices', 'Giá hóa đơn')) isValid = false;

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

    // bắt buộc
    if (!checkDate('buy_date', 'Ngày nhập', true)) isValid = false;

    // optional
    if (!checkDate('stock_in_date', 'Ngày về bãi')) isValid = false;
    if (!checkDate('sale_date', 'Ngày bán')) isValid = false;

    // ===== STOP =====
    if (!isValid) {
        e.preventDefault();
    }
});