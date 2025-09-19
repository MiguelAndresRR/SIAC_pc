//Esta funcion es para la animacion del sidebar cuando tenga el mouse encima de el.
const sidebar = document.getElementById("sidebar");

sidebar.addEventListener("mouseenter", () => {
    if (window.innerWidth > 768) {
        sidebar.classList.remove("collapsed");
        sidebar.style.width = "200px";
    } else {
        sidebar.classList.remove("collapsed");
        sidebar.style.width = "10%";
    }
});

sidebar.addEventListener("mouseleave", () => {
    if (window.innerWidth > 768) {
        sidebar.classList.add("collapsed");
        sidebar.style.width = "70px";
    } else {
        sidebar.classList.add("collapsed");
        sidebar.style.width = "70px";
    }
});
