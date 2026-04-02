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