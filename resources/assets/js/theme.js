document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const themeIcon = document.getElementById("theme-icon");
    const html = document.documentElement;
    
    // Cargar el tema guardado en localStorage
    const savedTheme = localStorage.getItem("theme") || "default";
    html.setAttribute("data-bs-theme", savedTheme);
    updateIcon(savedTheme);

    themeToggle.addEventListener("click", function () {
        let newTheme = html.getAttribute("data-bs-theme") === "dark" ? "light" : "dark";
        
        // Aplicar nuevo tema
        html.setAttribute("data-bs-theme", newTheme);
        localStorage.setItem("theme", newTheme);
        updateIcon(newTheme);
    });

    function updateIcon(theme) {
        if (theme === "dark") {
            themeIcon.classList.replace("ri-moon-line", "ri-sun-line");
        } else {
            themeIcon.classList.replace("ri-sun-line", "ri-moon-line");
        }
    }
});
