document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".clickable-row").forEach(row => {
        row.addEventListener("click", function () {
            const url = this.dataset.href;
            if (url) {
                window.location.href = url;
            }
        });
    });
});
row.addEventListener("click", function (e) {
    if (e.target.closest("button, a, input")) return;
    window.location.href = this.dataset.href;
});