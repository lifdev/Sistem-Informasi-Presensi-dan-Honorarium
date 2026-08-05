import "./bootstrap";
import "../css/app.css";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

const html = document.documentElement;

window.toggleDarkMode = function () {
    html.classList.toggle("dark");

    localStorage.theme = html.classList.contains("dark") ? "dark" : "light";

    updateThemeIcon();
};

function updateThemeIcon() {
    const moon = document.getElementById("icon-moon");
    const sun = document.getElementById("icon-sun");

    if (!moon || !sun) return;

    if (html.classList.contains("dark")) {
        moon.classList.add("hidden");
        sun.classList.remove("hidden");
    } else {
        moon.classList.remove("hidden");
        sun.classList.add("hidden");
    }
}

if (localStorage.theme === "dark") {
    html.classList.add("dark");
}

document.addEventListener("DOMContentLoaded", updateThemeIcon);
