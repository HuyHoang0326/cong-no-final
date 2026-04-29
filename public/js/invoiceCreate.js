// ---------------fill invoice item product in invoice create----------
let index = document.querySelectorAll("#invoice-item-box table").length;

document
    .getElementById("invoice-add-row-product")
    .addEventListener("click", function () {
        const invoiceItemBox = document.getElementById("invoice-item-box");
        const newRow = document.createElement("table");
        newRow.classList.add("invoice-table","product-table");

        newRow.innerHTML = `
            <thead>
                <tr class = >
                    <th>Xe/Phụ Tùng</th>
                    <th class="field-car">Mã Xe</th>
                    <th class="field-car">Tên Xe</th>
                    <th class="field-car" readonly>Hãng</th>
                    <th class="field-car" readonly>Số Máy</th>
                    <th class="field-car" readonly>Số Khung</th>
                    <th class="field-car" readonly>Trọng Tải</th>
                    <th class="field-car">Đơn Giá Bán</th>
                    <th class="field-car" readonly>Đơn Giá Hóa Đơn Xe Xe</th>
                    <th class="field-parst">Mã Phụ Tùng</th>
                    <th class="field-parst">Tên</th>
                    <th class="field-parst" readonly>Loại Hàng</th>
                    <th class="field-parst" readonly>Cũ/Mới</th>
                    <th class="field-parst" readonly>Nhà Cung Cấp</th>
                    <th class="field-parst" readonly>Số Lượng Còn</th>
                    <th class="field-parst">Số Lượng Bán</th>
                    <th class="field-parst">Đơn Vị Tính</th>
                    <th class="field-parst">Đơn Giá Bán</th>
                    <th class="field-parst" readonly>Tổng Giá Bán</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>

                    <!-- Loại -->
                    <td>
                        <select name="items[${index}][type]" class="invoice-select item-type">
                            <option value="car">Xe</option>
                            <option value="parst">Phụ Tùng</option>
                        </select>
                    </td>

                    <!-- ===== CAR ===== -->
                    <td class="field-car">
                        <div class="search-box">
                            <input type="text"
                            name="items[${index}][car_serial]"
                            class="car-serial"
                            placeholder="Mã Xe">
                            <div class="suggest-box"></div> 
                        </div>
                    </td>

                    <td class="field-car">
                        <input type="text"
                            name="items[${index}][car_name]"
                            class="car-name "
                            placeholder="Tên Xe">
                            <div class="suggest-box"></div> 
                    </td>

                    <td class="field-car">
                        <input type="text"
                            name="items[${index}][brand]"
                            class="car-brand" readonly>
                    </td>

                    <td class="field-car">
                        <input type="text"
                            name="items[${index}][engine_number]"
                            class="car-engine" readonly>
                    </td>

                    <td class="field-car">
                        <input type="text"
                            name="items[${index}][chassis_number]"
                            class="car-chassis" readonly>
                    </td>

                    <td class="field-car">
                        <input type="text"
                            name="items[${index}][payload]"
                            class="car-payload" readonly>
                    </td>

                    <td class="field-car">
                        <input type="text"
                            name="items[${index}][car_price]"
                            class="car-price price-sale format-number">
                    </td>

                    <td class="field-car">
                        <input type="text"
                            name="items[${index}][car_invoice_price]"
                            class="car-invoice-price price-invoice format-number">
                    </td>


                    <!-- ===== PARST ===== -->
                    <td class="field-parst">
                        <div class="search-box">
                            <input type="text"
                                name="items[${index}][parst_code]"
                                class="parst-code"
                                placeholder="Mã Phụ Tùng">
                                <div class="suggest-box"></div>
                        </div>
                    </td>

                    <td class="field-parst">
                        <input type="text"
                            name="items[${index}][parst_name]"
                            class="parst-name">
                             <div class="suggest-box"></div> 
                    </td>

                    <td class="field-parst">
                        <input type="text"
                            name="items[${index}][category]"
                            class="parst-category" readonly>
                    </td>

                    <td class="field-parst">
                        <input type="text"
                            name="items[${index}][condition]"
                            class="parst-condition" readonly>
                    </td>

                    <td class="field-parst">
                        <input type="text"
                            name="items[${index}][supplier]"
                            class="parst-supplier" readonly>
                    </td>

                    <td class="field-parst">
                        <input type="number"
                            name="items[${index}][quantity_stock]"
                            class="parst-stock-quantity" readonly>
                    </td>

                    <td class="field-parst">
                        <input type="number"
                            name="items[${index}][quantity_sold]"
                            class="parst-sold-quantity">
                    </td>

                    <td class="field-parst">
                        <input
                            name="items[${index}][unit]"
                            class="parst-unit" readonly>
                    </td>

                    <td class="field-parst">
                        <input type="text"
                            name="items[${index}][parst_price]"
                            class="parst-price price-sale format-number">
                    </td>

                    <td class="field-parst">
                        <input type="text"
                            name="items[${index}][total_parst_price]"
                            class="total-parst-price total-parst-price-sale format-number" readonly>
                    </td>

                    <td>
                        <button type="button" class="btn btn-delete remove-item">X</button>
                    </td>

                </tr>
            </tbody>
    `;
        invoiceItemBox.appendChild(newRow);
        addTableLabels();
        //------------off class field parst--------------
        const parstFields = newRow.querySelectorAll(".field-parst");
        parstFields.forEach((el) => (el.style.display = "none"));

        index++;
    });
// ---------delete invoice item product----------------
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("btn-delete")) {
        e.target.closest("table").remove();
        calculateParstTotals();
        calculateCarTotals();
        renderInvoicePreview();
    }
});
// ----------- select type for product and change field-------------------
document.addEventListener("change", function (e) {
    if (e.target.classList.contains("invoice-select")) {
        const type = e.target.value;
        const row = e.target.closest("table");
        const carFields = row.querySelectorAll(".field-car");
        const parstFields = row.querySelectorAll(".field-parst");

        if (type == "car") {
            carFields.forEach((el) => (el.style.display = ""));
            parstFields.forEach((el) => (el.style.display = "none"));
        }
        if (type == "parst") {
            carFields.forEach((el) => (el.style.display = "none"));
            parstFields.forEach((el) => (el.style.display = ""));
        }
    }
});
// ---------- search serial car and fill field for input in add product for invoice-------------------

document.addEventListener("input", function (e) {

    if (e.target.classList.contains("car-serial")) {

        let keyword = e.target.value;
        let suggestBox = e.target.closest(".field-car").querySelector(".suggest-box");

        if (keyword.length === 0) {
            suggestBox.innerHTML = "";
            return;
        }

        fetch(`/cars/search-serial?keyword=${keyword}`)
            .then(res => res.json())
            .then(data => {

                suggestBox.innerHTML = "";

                data.forEach(car => {

                    let div = document.createElement("div");
                    div.classList.add("suggest-item");
                    div.innerText = car.code;

                    div.addEventListener("click", function () {

                        let row = e.target.closest("tr");

                        row.querySelector(".car-serial").value = car.code ?? '';
                        row.querySelector(".car-name").value = car.name ?? '';
                        row.querySelector(".car-brand").value = car.brand_name ?? '';
                        row.querySelector(".car-engine").value = car.engine_number ?? '';
                        row.querySelector(".car-chassis").value = car.chassis_number ?? '';
                        row.querySelector(".car-payload").value = car.payload ?? '';
                        row.querySelector(".car-price").value = formatMoney(car.sale_price) ?? '';
                        row.querySelector(".car-invoice-price").value = formatMoney(car.sale_price) ?? '';

                        suggestBox.innerHTML = "";
                        calculateCarTotals()
                        renderInvoicePreview();
                    });

                    suggestBox.appendChild(div);
                });
            });
    }

});
// -------------seach name-----------------------------------------------------------
document.addEventListener("input", function (e) {

    if (e.target.classList.contains("car-name")) {

        let keyword = e.target.value;
        let suggestBox = e.target.closest(".field-car").querySelector(".suggest-box");

        if (keyword.length === 0) {
            suggestBox.innerHTML = "";
            return;
        }

        fetch(`/cars/search-name?keyword=${keyword}`)
            .then(res => res.json())
            .then(data => {

                suggestBox.innerHTML = "";

                data.forEach(car => {

                    let div = document.createElement("div");
                    div.classList.add("suggest-item");

                    // hiển thị đẹp hơn
                    div.innerText = `${car.name} (${car.code})`;

                    div.addEventListener("click", function () {

                        let row = e.target.closest("tr");

                        row.querySelector(".car-serial").value = car.code ?? '';
                        row.querySelector(".car-name").value = car.name ?? '';
                        row.querySelector(".car-brand").value = car.brand_name ?? '';
                        row.querySelector(".car-engine").value = car.engine_number ?? '';
                        row.querySelector(".car-chassis").value = car.chassis_number ?? '';
                        row.querySelector(".car-payload").value = car.payload ?? '';
                        row.querySelector(".car-price").value = formatMoney(car.sale_price) ?? '';
                        row.querySelector(".car-invoice-price").value = formatMoney(car.sale_price) ?? '';

                        suggestBox.innerHTML = "";
                        calculateCarTotals();
                        renderInvoicePreview();
                    });

                    suggestBox.appendChild(div);
                });
            });
    }

});
// ---------- search serial parsts and fill field for input in add product for invoice-------------------
document.addEventListener("input", function (e) {

    if (e.target.classList.contains("parst-code")) {

        let keyword = e.target.value;
        let suggestBox = e.target.closest(".field-parst").querySelector(".suggest-box");

        if (keyword.length === 0) {
            suggestBox.innerHTML = "";
            return;
        }

        fetch(`/parsts/search-serial?keyword=${keyword}`)
            .then(res => res.json())
            .then(data => {

                suggestBox.innerHTML = "";

                data.forEach(parst => {

                    let div = document.createElement("div");
                    div.classList.add("suggest-item");
                    div.innerText = parst.code;

                    div.addEventListener("click", function () {

                        let row = e.target.closest("tr");

                        row.querySelector(".parst-code").value = parst.code ?? '';
                        row.querySelector(".parst-name").value = parst.name ?? '';
                        row.querySelector(".parst-category").value = parst.category_name ?? '';
                        row.querySelector(".parst-condition").value = parst.condition ?? '';
                        row.querySelector(".parst-supplier").value = parst.supplier ?? '';
                        row.querySelector(".parst-stock-quantity").value = parst.quantity ?? '';
                        row.querySelector(".parst-price").value = formatMoney(parst.sale_price) ?? '';
                        row.querySelector(".parst-unit").value = parst.unit
                        suggestBox.innerHTML = "";

                        calculateParstRow(row);
                    });

                    suggestBox.appendChild(div);
                });
            })
    }
});
//---------- search name parst for invoice-------------------
document.addEventListener("input", function (e) {

    if (e.target.classList.contains("parst-name")) {

        let keyword = e.target.value;
        let suggestBox = e.target.closest(".field-parst").querySelector(".suggest-box");

        if (keyword.length === 0) {
            suggestBox.innerHTML = "";
            return;
        }

        fetch(`/parsts/search-name?keyword=${keyword}`)
            .then(res => res.json())
            .then(data => {

                suggestBox.innerHTML = "";

                data.forEach(parst => {

                    let div = document.createElement("div");
                    div.classList.add("suggest-item");

                    // hiển thị đẹp hơn
                    div.innerText = `${parst.name} (${parst.code})`;

                    div.addEventListener("click", function () {

                        let row = e.target.closest("tr");

                        row.querySelector(".parst-code").value = parst.code ?? '';
                        row.querySelector(".parst-name").value = parst.name ?? '';
                        row.querySelector(".parst-category").value = parst.category_name ?? '';
                        row.querySelector(".parst-condition").value = parst.condition ?? '';
                        row.querySelector(".parst-supplier").value = parst.supplier ?? '';
                        row.querySelector(".parst-stock-quantity").value = parst.quantity ?? '';
                        row.querySelector(".parst-price").value = formatMoney(parst.sale_price) ?? '';
                        row.querySelector(".parst-unit").value = parst.unit ?? '';

                        suggestBox.innerHTML = "";

                        calculateParstRow(row);
                    });

                    suggestBox.appendChild(div);
                });
            });
    }

});
//---------- search name customer for invoice-------------------
document.addEventListener("input", function (e) {

    if (e.target.classList.contains("customer-name")) {
        let parentGroup = e.target.closest(".customer-group");
        let guestCheckbox = parentGroup.querySelector(".guestCustomer");
        let suggestBox = parentGroup.querySelector(".suggest-box");
        let hiddenIdInput = parentGroup.querySelector(".customer-id");

        // Nếu tick Khách Ngoài thì không search
        if (guestCheckbox.checked) return;

        let keyword = e.target.value.trim();

        // Nếu người dùng sửa tay → reset id
        hiddenIdInput.value = "";

        if (keyword.length === 0) {
            suggestBox.innerHTML = "";
            return;
        }

        fetch(`/customers/search?keyword=${keyword}`)
            .then(res => res.json())
            .then(data => {

                suggestBox.innerHTML = "";

                data.forEach(customer => {
                    let div = document.createElement("div");
                    div.classList.add("suggest-item");

                    div.innerText = customer.name;
                    div.dataset.id = customer.id; // lưu id

                    div.addEventListener("click", function () {
                        // Hiển thị tên
                        e.target.value = customer.name;

                        document.querySelector(".customer-phone").value = customer.phone;
                        document.querySelector(".customer-address").value = customer.address;
                        // Gán id để submit
                        hiddenIdInput.value = customer.id;

                        // Ẩn gợi ý
                        suggestBox.innerHTML = "";

                        renderInvoicePreview();
                    });

                    suggestBox.appendChild(div);
                });
            });
    }
});
//--------------- close check box when value true---------------
document.addEventListener("change", function (e) {

    if (e.target.classList.contains("guestCustomer")) {

        let parentGroup = e.target.closest(".customer-group");
        let hiddenIdInput = parentGroup.querySelector(".customer-id");
        let suggestBox = parentGroup.querySelector(".suggest-box");

        if (e.target.checked) {

            suggestBox.innerHTML = "";
            hiddenIdInput.disabled = true; // không gửi lên API
            hiddenIdInput.style.display = "none";

        } else {

            hiddenIdInput.disabled = false; // gửi lại id cũ
            hiddenIdInput.style.display = "";

        }

    }

});
// -------------------check box document-----------------------
document.addEventListener("DOMContentLoaded", function () {

    const haiQuan = document.querySelector('input[value="hai_quan"]');
    const dangKiem = document.querySelector('input[value="dang_kiem"]');
    const hopDong = document.querySelector('input[value="hop_dong"]');

    const daGiaoDu = document.querySelector('input[value="da_giao_du"]');
    const chuaGiao = document.querySelector('input[value="chua_giao"]');

    const docs = [haiQuan, dangKiem, hopDong];

    // ===== ĐÃ GIAO ĐỦ =====
    daGiaoDu.addEventListener("change", function () {
        if (this.checked) {

            docs.forEach(doc => doc.checked = false);

            chuaGiao.checked = false;
        }
    });

    // ===== CHƯA GIAO ĐỦ =====
    chuaGiao.addEventListener("change", function () {
        if (this.checked) {

            docs.forEach(doc => doc.checked = false);

            daGiaoDu.checked = false;
        }
    });

    // ===== GIẤY TỜ RIÊNG =====
    docs.forEach(doc => {
        doc.addEventListener("change", function () {

            if (this.checked) {
                daGiaoDu.checked = false;
                chuaGiao.checked = false;
            }

            // 👉 CHECK nếu cả 3 đều đã tick
            const allChecked = docs.every(d => d.checked);

            if (allChecked) {
                // bật ĐÃ GIAO ĐỦ
                daGiaoDu.checked = true;

                // tắt 3 giấy tờ
                docs.forEach(d => d.checked = false);
            }

        });

    });

});
//--------------- total one parst -------------------
function calculateParstRow(row) {

    const quantity = parseFloat(row.querySelector(".parst-sold-quantity")?.value) || 0;
    const priceSale = parseFloat(row.querySelector(".parst-price")?.value) || 0;
    const priceInvoice = parseFloat(row.querySelector(".parst-invoice-price")?.value) || 0;

    const totalSale = quantity * priceSale;
    const totalInvoice = quantity * priceInvoice;

    const totalSaleInput = row.querySelector(".total-parst-price-sale");
    const totalInvoiceInput = row.querySelector(".total-parst-invoice-price");

    if (totalSaleInput) totalSaleInput.value = totalSale;
    if (totalInvoiceInput) totalInvoiceInput.value = totalInvoice;
    calculateParstTotals();
}
// -----------listen-----------------------
document.addEventListener("input", function (e) {

    const row = e.target.closest("tr");
    if (!row) return;

    // PARST
    if (
        e.target.classList.contains("parst-sold-quantity") ||
        e.target.classList.contains("parst-price") ||
        e.target.classList.contains("parst-invoice-price")
    ) {
        calculateParstRow(row);
    }

    // CAR
    if (
        e.target.classList.contains("car-price") ||
        e.target.classList.contains("car-invoice-price")
    ) {
        calculateCarTotals();
    }

});
//--------------- total all parst -------------------
function calculateParstTotals() {
    let totalSale = 0;
    let totalInvoice = 0;

    document.querySelectorAll(".total-parst-price-sale").forEach(input => {
        totalSale += parseFloat(input.value) || 0;
    });

    document.querySelectorAll(".total-parst-invoice-price").forEach(input => {
        totalInvoice += parseFloat(input.value) || 0;
    });


    calculateInvoiceTotals();
}
// -----------------total all car------------------------
function calculateCarTotals() {

    let totalSale = 0;
    let totalInvoice = 0;

    document.querySelectorAll(".car-price").forEach(input => {
        totalSale += parseFloat(input.value) || 0;
    });

    document.querySelectorAll(".car-invoice-price").forEach(input => {
        totalInvoice += parseFloat(input.value) || 0;
    });

    calculateInvoiceTotals();
}
//-----------------total-------------
function calculateInvoiceTotals() {
    let carSale = 0;
    let parstSale = 0;

    document.querySelectorAll(".car-price").forEach(input => {
        carSale += parseFloat(input.value) || 0;
    });

    document.querySelectorAll(".total-parst-price-sale").forEach(input => {
        parstSale += parseFloat(input.value) || 0;
    });

    const paid = parseFloat(document.querySelector(".paid-amount")?.value) || 0;

    const totalSale = carSale + parstSale;
    const totalDebt = totalSale - paid;

    document.querySelector(".total-sale").value = formatMoney(totalSale);
    document.querySelector(".total-invoice").value = formatMoney(document.querySelectorAll(".car-invoice-price")[0].value);
    document.querySelector(".total-debt").value = formatMoney(totalDebt);
}
//--------------listen input-------------
document.addEventListener("input", function(e){
    if (e.target.classList.contains("date-sell")) {
        renderInvoicePreview();
    }
    if(
        e.target.classList.contains("paid-amount") ||
        e.target.classList.contains("deposit-amount")
    ){
        renderInvoicePreview();
        calculateInvoiceTotals();
    }

});
//-----------------render invoice preview----------------
function renderInvoicePreview() {
    const preview = document.getElementById("invoice-preview");

    preview.style.display = "block";
    // ===== HELPER =====
    const getText = (selector) => {
        return document.querySelector(selector)?.value?.trim() || "";
    };

    const getNumber = (selector) => {
        return parseFloat(document.querySelector(selector)?.value) || 0;
    };

    // ===== LẤY DATA =====
    const customer = getText(".customer-name");
    const customer_phone = getText(".customer-phone");
    const customer_address = getText(".customer-address");
    const receiver_name = getText(".receiver-name");
    const invoiceCode = getText(".invoice-id");
    const dateValue = document.querySelector(".date-sell").value;

    let day = "", month = "", year = "";
    if (dateValue) {
        const d = new Date(dateValue);
        day = d.getDate() || "";
        month = d.getMonth() + 1 || "";
        year = d.getFullYear() || "";
    }

    // ===== DANH SÁCH SẢN PHẨM =====
    let rows = "";
    let index = 1;
let totalPrice = 0;
    document.querySelectorAll("#invoice-item-box table").forEach(table => {
        const type = table.querySelector(".item-type")?.value || "";

        if (type === "car") {
            const name = table.querySelector(".car-name")?.value || "";
            const serial = table.querySelector(".car-serial")?.value || "";
            const price = parseFloat(table.querySelector(".car-price")?.value) || 0;
            totalPrice += price;
            rows += `
                <tr>
                    <td>${index++}</td>
                    <td>${serial}</td>
                    <td>${name}</td>
                    <td>xe</td>
                    <td>1</td>
                    <td>${formatMoney(price)}</td>
                    <td>${formatMoney(price)}</td>
                </tr>
            `;
        }

        if (type === "parst") {
            const name = table.querySelector(".parst-name")?.value || "";
            const code = table.querySelector(".parst-code")?.value || "";
            const qty = parseFloat(table.querySelector(".parst-sold-quantity")?.value) || 0;
            const price = parseFloat(table.querySelector(".parst-price")?.value) || 0;
            const totalRow = qty * price;
            totalPrice += totalRow;
            rows += `
                <tr>
                    <td>${index++}</td>
                    <td>${code}
                    <td>${name}</td>
                    <td>cái</td>
                    <td>${qty}</td>
                    <td>${formatMoney(price)}</td>
                    <td>${formatMoney(totalRow)}</td>
                </tr>
            `;
        }
    });

    // ===== RENDER =====
    preview.innerHTML = `
    <div class = "logo">
        <div class="title">XE NÂNG HOA QUYẾT NINH BÌNH</div>
        <div class = "head-inf">CHUYÊN: BÁN XE NÂNG DẦU, XĂNG, ĐIỆN NHẬT BÃI</div>
        <div class = "head-inf">PHỤ TÙNG XE NÂNG CÁC LOẠI</div>
        <div class = "head-inf">Địa chỉ: xóm 1 - Yên Mạc - Ninh Bình</div>
        <div class = "head-inf">Điện thoại: 0986.670.666 - 0966.172.101</div>
    </div>
    <hr>
    <br>
    <div class="hdbh">HOÁ ĐƠN BÁN HÀNG</div>

    <div class="sub-header">
        <div>Số: ${invoiceCode}</div>
    </div>

    <p><strong>Tên khách hàng:</strong> ${customer}${customer_phone}</p>
    <p><strong>Tên người nhận hàng:</strong>${receiver_name}</p>
    <p><strong>Địa chỉ:</strong> ${customer_address}</p>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã Sản Phẩm</th>
                <th>Tên Hàng</th>
                <th>ĐVT</th>
                <th>Số Lượng</th>
                <th>Đơn Giá</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            ${rows}
        </tbody>
    </table>

    <table class="total-table">
        <tr>
            <td class="text-right"><strong>CỘNG TIỀN HÀNG:</strong></td>
            <td class="text-right">${formatMoney(totalPrice)}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>TỔNG THANH TOÁN:</strong></td>
            <td class="text-right">${formatMoney(totalPrice)}</td>
        </tr>
    </table>
    <div class="date-button">Ngày ${day} Tháng ${month} Năm ${year}</div>
    <div class="signature">
        <div>NGƯỜI LẬP PHIẾU<br>(Ký)</div>
        <div>NGƯỜI NHẬN HÀNG<br>(Ký)</div>
        <div>GIÁM ĐỐC<br>(Ký)</div>
    </div>
`;
}
// ------------------------------------
function formatMoney(number) {
    return Number(number || 0).toLocaleString('vi-VN');
}

document.addEventListener("input", function () {
    renderInvoicePreview();
});

document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", function () {

        this.querySelectorAll(".format-number").forEach(input => {
           input.value = input.value.replace(/[.,]/g, '');
        });

    });
});

// ------------print-----------------
function printInvoice() {
    const content = document.getElementById("invoice-preview").innerHTML;

    const printWindow = window.open('', '', 'width=900,height=700');

    printWindow.document.write(`
        <html>
        <head>
            <title>In hóa đơn</title>
            <style>
                body { font-family: Arial; padding: 20px; }
                .logo{margin-top:-25px}
                .hdbh{margin-top:-15px; text-align: center; font-weight: bold; font-size: 16px;}
                .total-table{margin-top:10px}
                tr {font-size: 12px;}
                table { width: 100%; border-collapse: collapse; }
                table, th, td { border: 1px solid #000; }
                th, td { padding: 6px; text-align: center; }
                .title { text-align: center; font-weight: bold; font-size: 20px;}
                .text-right { text-align: right; }
                .head-inf{
    text-align: center;
}
 .sub-header {
    text-align: center;
    margin: 5px 0 10px;
    font-weight: bold;
}
    .date-button{
    margin-top: 20px;
    display: flex;
    justify-content: right;
    font-weight: bold;
}
.signature {
    margin-top: 30px;
    display: flex;
    justify-content: space-between;
    text-align: center;
    font-size: 10px;
    font-weight: bold;
}
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.print();
}

function addTableLabels() {
    document.querySelectorAll(".invoice-table").forEach(table => {
        const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.innerText);

        table.querySelectorAll("tbody tr").forEach(row => {
            row.querySelectorAll("td").forEach((td, i) => {
                td.setAttribute("data-label", headers[i] || "");
            });
        });
    });
}

// chạy sau khi render
setTimeout(addTableLabels, 500);