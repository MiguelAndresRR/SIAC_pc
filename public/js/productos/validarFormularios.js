//Este script valida el formulario de crear, 
// nos permite verificar que se cumplan las condiciones y si no es el caso nos arroja un error. 
// Evitando que se pueda enviar.
const formularioCrear = document.getElementById("FormularioProductosCrear");
const inputsCrear = document.querySelectorAll("#FormularioProductosCrear input");

const expresiones = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,20}$/,
    numero: /^\d{1,10}(\.\d+)?$/
};
campos = {
    nombre: false,
    precio: false
};

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "nombre_producto":
            validarCampo(expresiones.nombre, e.target, "nombre");
            break;
        case "precio_producto":
            validarCampo(expresiones.numero, e.target, "precio");
            break;
    }
};

const validarCampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document
            .getElementById(`grupo__${campo}`)
            .classList.remove("form-group__producto__incorrecto");
        document
            .getElementById(`grupo__${campo}`)
            .classList.add("form-group__producto__correcto");
        campos[campo] = true;
    } else {
        document
            .getElementById(`grupo__${campo}`)
            .classList.add("form-group__producto__incorrecto");
        document
            .getElementById(`grupo__${campo}`)
            .classList.remove("form-group__producto__correcto");
        campos[campo] = false;
    }
};

inputsCrear.forEach((input) => {
    input.addEventListener("keyup", validarFormulario);
    input.addEventListener("blur", validarFormulario);
});

formularioCrear.addEventListener("submit", (e) => {
    e.preventDefault();

    inputsCrear.forEach((input) => validarFormulario({ target: input }));

    if (
        campos.nombre && campos.precio) {
        formularioCrear.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});
