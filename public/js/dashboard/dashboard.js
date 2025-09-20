const sidebar = document.getElementById("sidebar");

sidebar.addEventListener("mouseenter", () => {
    if (window.innerWidth > 768) {
        // Pantallas grandes
        sidebar.classList.remove("collapsed");
        sidebar.style.width = "200px";
    } else {
        // Pantallas pequeñas
        sidebar.classList.remove("collapsed");
        sidebar.style.width = "60%"; // se abre más ancho en móvil
    }
});

sidebar.addEventListener("mouseleave", () => {
    if (window.innerWidth > 768) {
        // Pantallas grandes
        sidebar.classList.add("collapsed");
        sidebar.style.width = "70px";
    } else {
        // Pantallas pequeñas
        sidebar.classList.add("collapsed");
        sidebar.style.width = "70px"; // se esconde del todo en móvil
    }
});
