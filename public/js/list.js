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

document.addEventListener("DOMContentLoaded", function () {

    const rowsPerPage = 20;

    document.querySelectorAll(".table-container").forEach(container => {

        const tbody = container.querySelector("table tbody");
        const pagination = container.querySelector(".pagination");

        if (!tbody || !pagination) return;

        const allRows = Array.from(tbody.querySelectorAll("tr"));
        let currentPage = 1;
        const totalPages = Math.ceil(allRows.length / rowsPerPage);

        // =========================
        // CLICK ROW
        // =========================
        function attachRowClick() {
            container.querySelectorAll(".clickable-row").forEach(row => {

                row.style.cursor = "pointer";

                row.addEventListener("click", function (e) {
                    // tránh click vào button/link trong row
                    if (e.target.closest("button, a, input")) return;

                    const href = this.dataset.href;
                    if (href) window.location.href = href;
                });
            });
        }

        // =========================
        // RENDER TABLE
        // =========================
        function renderTable() {
            tbody.innerHTML = "";

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            allRows.slice(start, end).forEach(row => {
                tbody.appendChild(row);
            });

            attachRowClick(); // bind lại event
        }

        // =========================
        // RENDER PAGINATION
        // =========================
        function renderPagination() {
            pagination.innerHTML = "";

            // PREV
            const prev = document.createElement("button");
            prev.innerText = "←";
            prev.disabled = currentPage === 1;

            prev.addEventListener("click", () => {
                currentPage--;
                renderTable();
                renderPagination();
            });

            pagination.appendChild(prev);

            // PAGE NUMBERS
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.innerText = i;

                if (i === currentPage) {
                    btn.classList.add("active");
                }

                btn.addEventListener("click", () => {
                    currentPage = i;
                    renderTable();
                    renderPagination();
                });

                pagination.appendChild(btn);
            }

            // NEXT
            const next = document.createElement("button");
            next.innerText = "→";
            next.disabled = currentPage === totalPages;

            next.addEventListener("click", () => {
                currentPage++;
                renderTable();
                renderPagination();
            });

            pagination.appendChild(next);
        }

        // =========================
        // INIT
        // =========================
        renderTable();
        renderPagination();
    });

});