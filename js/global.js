document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const body = document.body;
    const sidebar = document.getElementById("sidebar");

    themeToggle.addEventListener("click", function () {
        body.classList.toggle("dark-mode");
    });
});