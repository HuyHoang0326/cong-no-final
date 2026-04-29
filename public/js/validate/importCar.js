
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("carForm");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let hasError = false;
        let firstErrorInput = null;

        // reset
        document.querySelectorAll(".error-text").forEach(el => el.innerText = "");
        document.querySelectorAll(".input-field").forEach(el => {
            el.classList.remove("input-error");
        });
        document.querySelectorAll(".parst-box").forEach(box => {
            box.classList.remove("parst-error");
        });

        //  REQUIRED CHO CAR
        const requiredFields = [
            'code',
            'brand_id',
            'buy_price',
            'buy_date',
            'payload',
            'sale_status',
            'sale_price',
            'chassis_number',
        ];

        //  NUMERIC
        const numericFields = [
            'payload',
            'buy_price',
            'buy_shipping_cost',
            'sale_price',
            'sale_price_invoices'
        ];

        let items = {};

        // group theo index
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
            // checkbox REQUIRED
            let docGroup = box?.querySelector(".document-checkbox-group");

            if (docGroup) {

                let checkedCount = docGroup.querySelectorAll(
                    'input[type="checkbox"]:checked'
                ).length;

                if (checkedCount === 0) {

                    hasError = true;

                    let err = docGroup.querySelector(".error-text");
                    if (err) {
                        err.innerText = "Bắt buộc";
                    }

                    docGroup.classList.add("input-error");

                    if (!firstErrorInput) firstErrorInput = docGroup;
                }
            }
            //  REQUIRED
            requiredFields.forEach(field => {
                let input = item[field];

                if (input && input.value.trim() === "") {

                    hasError = true;

                    input.classList.add("input-error");
                    if (box) box.classList.add("parst-error");

                    let errorBox = input.parentElement.querySelector(".error-text");
                    if (errorBox) {
                        errorBox.innerText = "Bắt buộc";
                    }

                    if (!firstErrorInput) firstErrorInput = input;
                }
            });

            //  NUMERIC
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

                    if (!firstErrorInput) firstErrorInput = input;
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
            console.log("BOX:", box);
console.log("DOCGROUP:", docGroup);

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

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".document-checkbox-group").forEach(group => {

        const get = (value) =>
            group.querySelector(`input[value="${value}"]`);

        const full = get("da_giao_du");
        const notYet = get("chua_giao");

        const docs = [
            get("hai_quan"),
            get("dang_kiem"),
            get("hop_dong")
        ];

        function offDocs() {
            docs.forEach(cb => {
                if (cb) cb.checked = false;
            });
        }

        function offSpecial() {
            if (full) full.checked = false;
            if (notYet) notYet.checked = false;
        }

        function allDocsChecked() {
            return docs.every(cb => cb && cb.checked);
        }

        group.querySelectorAll("input[type=checkbox]").forEach(cb => {

            cb.addEventListener("change", function () {

                const val = this.value;

                // ======================
                // ✔ FULL (ĐẦY ĐỦ)
                // ======================
                if (val === "da_giao_du" && this.checked) {
                    offDocs(); // ❌ OFF 3 giấy tờ
                    if (notYet) notYet.checked = false;
                }

                // ======================
                // ✔ CHƯA GIAO
                // ======================
                if (val === "chua_giao" && this.checked) {
                    offDocs(); // ❌ OFF 3 giấy tờ
                    if (full) full.checked = false;
                }

                // ======================
                // ✔ 3 GIẤY TỜ
                // ======================
                if (["hai_quan", "dang_kiem", "hop_dong"].includes(val)) {

                    offSpecial();

                    // nếu có tick FULL → vẫn phải OFF docs
                    if (full && full.checked) {
                        offDocs();
                    }

                    // auto bật FULL nếu đủ 3
                    if (allDocsChecked() && full) {
                        full.checked = true;
                    } else if (full) {
                        full.checked = false;
                    }
                }

                // ======================
                // chống conflict
                // ======================
                if (full && full.checked) {
                    offDocs(); //  luôn ưu tiên FULL
                    if (notYet) notYet.checked = false;
                }

                if (notYet && notYet.checked) {
                    offDocs();
                    if (full) full.checked = false;
                }

            });

        });

    });

});