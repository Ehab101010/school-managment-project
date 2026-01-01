document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".menu-btn");

    buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const parent = btn.parentElement;

             document.querySelectorAll(".menu-item.open").forEach((item) => {
                if (item !== parent) item.classList.remove("open");
            });

             parent.classList.toggle("open");
        });
    });
});
