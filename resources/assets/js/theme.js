function setupThemeToggle(toggleBtn, iconElem, htmlElem) {
    const savedTheme = localStorage.getItem("theme") || "default";
    htmlElem.setAttribute("data-bs-theme", savedTheme);
    updateIcon(savedTheme);

    toggleBtn.addEventListener("click", function () {
        const currentTheme = htmlElem.getAttribute("data-bs-theme");
        const newTheme = currentTheme === "dark" ? "light" : "dark";

        htmlElem.setAttribute("data-bs-theme", newTheme);
        localStorage.setItem("theme", newTheme);
        updateIcon(newTheme);
    });

    function updateIcon(theme) {
        if (theme === "dark") {
            iconElem.classList.replace("ri-moon-line", "ri-sun-line");
        } else {
            iconElem.classList.replace("ri-sun-line", "ri-moon-line");
        }
    }
}


window.setupThemeToggle = setupThemeToggle;
