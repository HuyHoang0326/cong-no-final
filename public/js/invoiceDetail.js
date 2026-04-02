let total = 0;
function renderInvoicePreviewEdit() {

    const preview = document.getElementById("invoice-preview");
    if (!preview) return;

    preview.style.display = "block";

    // ===== HELPER =====
    const getText = (selector) => {
        const el = document.querySelector(selector);
        if (!el) return "";
        return (el.value ?? el.innerText ?? "").toString().trim();
    };

    const parseMoney = (text) => {
        return parseFloat((text || "").replace(/,/g, "")) || 0;
    };
    // ===== DATA =====
    const customer = getText(".customer-name");
    const customer_phone = getText(".customer-phone");
    const customer_address = getText(".customer-address");
    const receiver_name = getText(".receiver-name");
    const invoiceCode = getText(".invoice-id");

    const dateValue =
        document.querySelector(".date-sell")?.value ||
        document.querySelector(".date-sell")?.innerText;

    let day = "", month = "", year = "";

    if (dateValue) {
        const d = new Date(dateValue);
        if (!isNaN(d)) {
            day = d.getDate();
            month = d.getMonth() + 1;
            year = d.getFullYear();
        }
    }
    // ===== ITEMS =====
    let rows = "";
    let index = 1;
    let totalPrice = 0;
    document.querySelectorAll(".product-card").forEach(card => {

        const isCar = card.classList.contains("car");
        const isParst = card.classList.contains("parst");

        // ===== CAR =====
        if (isCar) {
            const name = card.querySelector(".car-name")?.innerText?.trim() || "";
            const serial = card.querySelector(".car-serial")?.innerText?.trim() || "";

            const priceText = card.querySelector(".car-price")?.innerText || "0";
            const price = parseMoney(priceText);
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

        // ===== PARST =====
        if (isParst) {
            const name = card.querySelector(".parst-name")?.innerText?.trim() || "";
            const code = card.querySelector(".parst-code")?.innerText?.trim() || "";

            const qtyText = card.querySelector(".parst-sold-quantity")?.innerText || "0";
            const priceText = card.querySelector(".parst-price")?.innerText || "0";

            const qty = parseMoney(qtyText);
            const price = parseMoney(priceText);
            const totalRow = qty * price;

            totalPrice += totalRow;
            rows += `
                <tr>
                    <td>${index++}</td>
                    <td>${code}</td>
                    <td>${name}</td>
                    <td>cái</td>
                    <td>${qty}</td>
                    <td>${formatMoney(price)}</td>
                    <td>${formatMoney(totalRow)}</td>
                </tr>
            `;
        }
        total = totalPrice
    });
    // ===== RENDER =====
    preview.innerHTML = `
    <div class="title">HOÁ ĐƠN BÁN HÀNG</div>

    <div class="sub-header">
        <div>NGÀY ${day} THÁNG ${month} NĂM ${year}</div>
        <div>Số: ${invoiceCode}</div>
    </div>

    <p><strong>Người nhận hàng:</strong> ${receiver_name}</p>
    <p><strong>Đơn vị:</strong> ${customer} - ${customer_phone}</p>
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
            ${rows || `<tr><td colspan="7" style="text-align:center">Không có sản phẩm</td></tr>`}
        </tbody>
    </table>

    <table>
        <tr>
            <td class="text-right"><strong>CỘNG TIỀN HÀNG:</strong></td>
            <td class="text-right">${formatMoney(total)}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>THUẾ:</strong></td>
            <td class="text-right">0</td>
        </tr>
        <tr>
            <td class="text-right"><strong>TỔNG THANH TOÁN:</strong></td>
            <td class="text-right">${formatMoney(total)}</td>
        </tr>
    </table>

    <div class="date-button">NGÀY ${day} THÁNG ${month} NĂM ${year}</div>

    <div class="signature">
        <div>NGƯỜI LẬP PHIẾU<br>(Ký)</div>
        <div>NGƯỜI NHẬN HÀNG<br>(Ký)</div>
        <div>GIÁM ĐỐC<br>(Ký)</div>
    </div>
    `;
}

document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", function () {

        this.querySelectorAll(".format-number").forEach(input => {
           input.value = input.value.replace(/[.,]/g, '');
        });

    });
});

document.addEventListener("DOMContentLoaded", function () {
    renderInvoicePreviewEdit();
});

function formatMoney(number) {
    return Number(number || 0).toLocaleString('vi-VN');
}