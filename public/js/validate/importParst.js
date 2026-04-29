
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("parstForm"); // hoặc dùng id nếu có

    if (!form) return;

    form.addEventListener("submit", function (e) {
        let hasError = false;
        let firstErrorInput = null;

        // reset toàn bộ lỗi
        document.querySelectorAll(".error-text").forEach(el => el.innerText = "");
        document.querySelectorAll(".input-field").forEach(el => {
            el.classList.remove("input-error");
        });
        document.querySelectorAll(".parst-box").forEach(box => {
            box.classList.remove("parst-error");
        });

        const requiredFields = [
            'code', 'name', 'quantity', 'unit',
            'buy_price', 'buy_date', 'sale_status', 'sale_price'
        ];

        const numericFields = [
            'quantity', 'buy_price', 'sale_price', 'buy_shipping_cost'
        ];

        let items = {};

        document.querySelectorAll(".input-field").forEach(input => {
            let index = input.dataset.index;
            let field = input.dataset.field;

            if (!items[index]) items[index] = {};
            items[index][field] = input;
        });

        Object.keys(items).forEach(index => {

            let item = items[index];

            // check dòng rỗng
            let isEmpty = true;
            Object.values(item).forEach(input => {
                if (input.value.trim() !== "") isEmpty = false;
            });

            if (isEmpty) return;

            let box = document.querySelector(`.parst-box[data-index="${index}"]`);

            // required
            requiredFields.forEach(field => {
                let input = item[field];

                if (input && input.value.trim() === "") {

                    hasError = true;

                    input.classList.add("input-error");
                    if (box) box.classList.add("parst-error");

                    let errorBox = input.parentElement.querySelector(".error-text");
                    if (errorBox) {
                        errorBox.innerText = "Trường này bắt buộc";
                    }

                    if (!firstErrorInput) {
                        firstErrorInput = input;
                    }
                }
            });

            // numeric
            numericFields.forEach(field => {
                let input = item[field];

                if (input && input.value.trim() !== "" && isNaN(input.value)) {

                    hasError = true;

                    input.classList.add("input-error");
                    if (box) box.classList.add("parst-error");

                    let errorBox = input.parentElement.querySelector(".error-text");
                    if (errorBox) {
                        errorBox.innerText = "Phải là số";
                    }

                    if (!firstErrorInput) {
                        firstErrorInput = input;
                    }
                }
            });
            //  DATE VALIDATE
            let buyDate = item['buy_date']?.value;
            let stockDate = item['stock_in_date']?.value;
            let saleDate = item['sale_date']?.value;

            function toDate(d) {
                return d ? new Date(d) : null;
            }

            let dBuy = toDate(buyDate);
            let dStock = toDate(stockDate);
            let dSale = toDate(saleDate);

            // buy <= stock
            if (dBuy && dStock && dBuy > dStock) {
                hasError = true;

                let input = item['stock_in_date'];
                input.classList.add("input-error");

                let errorBox = input.parentElement.querySelector(".error-text");
                if (errorBox) {
                    errorBox.innerText = "Ngày về bãi phải ≥ ngày nhập";
                }

                if (!firstErrorInput) firstErrorInput = input;
            }

            // stock <= sale
            if (dStock && dSale && dStock > dSale) {
                hasError = true;

                let input = item['sale_date'];
                input.classList.add("input-error");

                let errorBox = input.parentElement.querySelector(".error-text");
                if (errorBox) {
                    errorBox.innerText = "Ngày bán phải ≥ ngày về bãi";
                }

                if (!firstErrorInput) firstErrorInput = input;
            }

        });

        //  CHẶN SUBMIT
        if (hasError) {
            e.preventDefault();

            if (firstErrorInput) {
                firstErrorInput.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

                setTimeout(() => {
                    firstErrorInput.focus();
                }, 200);
            }
        }

    });

});
