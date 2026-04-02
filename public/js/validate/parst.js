document.getElementById('parstForm')?.addEventListener('submit', function (e) {

    let isValid = true;

    // clear lỗi cũ
    document.querySelectorAll('.error').forEach(el => el.innerText = '');

    // ===== LẤY VALUE =====
    const code = document.getElementById('code')?.value.trim();
    const name = document.getElementById('name')?.value.trim();
    const category = document.getElementById('parst_category_id')?.value;
    const condition = document.getElementById('item_condition')?.value.trim();
    const quantity = document.getElementById('quantity')?.value;
    const unit = document.getElementById('unit')?.value.trim();
    const buy_price = document.getElementById('buy_price')?.value;
    const buy_date = document.getElementById('buy_date')?.value;
    const sale_status = document.getElementById('sale_status')?.value;

    const shipping = document.getElementById('buy_shipping_cost')?.value;
    const stock_date = document.getElementById('stock_in_date')?.value;
    const warehouse = document.getElementById('warehouse_id')?.value;
    const sale_date = document.getElementById('sale_date')?.value;
    const sale_price = document.getElementById('sale_price')?.value;
    const sale_invoice = document.getElementById('sale_price_invoices')?.value;

    // ===== REQUIRED =====
    function required(value, field, label) {
        if (!value) {
            document.getElementById('error-' + field).innerText = label + ' không được để trống';
            return false;
        }
        return true;
    }

    if (!required(code, 'code', 'Mã phụ tùng')) isValid = false;
    if (!required(name, 'name', 'Tên')) isValid = false;
    if (!required(category, 'parst_category_id', 'Danh mục')) isValid = false;
    if (!required(condition, 'item_condition', 'Tình trạng')) isValid = false;
    if (!required(quantity, 'quantity', 'Số lượng')) isValid = false;
    if (!required(unit, 'unit', 'Đơn vị')) isValid = false;
    if (!required(buy_price, 'buy_price', 'Giá nhập')) isValid = false;
    if (!required(buy_date, 'buy_date', 'Ngày nhập')) isValid = false;
    if (!required(sale_status, 'sale_status', 'Trạng thái')) isValid = false;

    // ===== NUMBER >= 0 =====
    function checkNumber(value, field, label) {
        if (value !== '' && value != null) {
            if (isNaN(value) || Number(value) < 0) {
                document.getElementById('error-' + field).innerText = label + ' phải >= 0';
                return false;
            }
        }
        return true;
    }

    if (!checkNumber(quantity, 'quantity', 'Số lượng')) isValid = false;
    if (!checkNumber(buy_price, 'buy_price', 'Giá nhập')) isValid = false;

    // optional number
    if (!checkNumber(shipping, 'buy_shipping_cost', 'Phí vận chuyển')) isValid = false;
    if (!checkNumber(sale_price, 'sale_price', 'Giá bán')) isValid = false;
    if (!checkNumber(sale_invoice, 'sale_price_invoices', 'Giá hóa đơn')) isValid = false;

    // ===== QUANTITY > 0 =====
    if (quantity && Number(quantity) <= 0) {
        document.getElementById('error-quantity').innerText = 'Số lượng phải > 0';
        isValid = false;
    }

    // ===== DATE =====
    function checkDate(value, field, label, required = false) {
        if (required && !value) {
            document.getElementById('error-' + field).innerText = label + ' không được để trống';
            return false;
        }

        if (value && isNaN(Date.parse(value))) {
            document.getElementById('error-' + field).innerText = label + ' không hợp lệ';
            return false;
        }

        return true;
    }

    if (!checkDate(buy_date, 'buy_date', 'Ngày nhập', true)) isValid = false;
    if (!checkDate(stock_date, 'stock_in_date', 'Ngày về kho')) isValid = false;
    if (!checkDate(sale_date, 'sale_date', 'Ngày bán')) isValid = false;

    // ===== LOGIC NGHIỆP VỤ =====

    // đã bán phải có giá
    if (sale_status == 1 && !sale_price) {
        document.getElementById('error-sale_price').innerText = 'Đã bán phải có giá bán';
        isValid = false;
    }

    // đã bán phải có ngày bán
    if (sale_status == 1 && !sale_date) {
        document.getElementById('error-sale_date').innerText = 'Đã bán phải có ngày bán';
        isValid = false;
    }

    // ===== STOP =====
    if (!isValid) {
        e.preventDefault();
    }

});