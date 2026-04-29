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
<p><strong>Tên khách hàng:</strong> ${customer} - ${customer_phone}</p>
    <p><strong>Người nhận hàng:</strong> ${receiver_name}</p>
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

    <table class="total-table">
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
// ---------------export invoice----------------
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