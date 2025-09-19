//Este script valida el formulario de crear, 
// nos permite verificar que se cumplan las condiciones y si no es el caso nos arroja un error. 
// Evitando que se pueda enviar.
const formularioCrear = document.getElementById("formularioProveedor");
const inputsCrear = document.querySelectorAll("#formularioProveedor input");

const expresiones = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,25}$/,
    user: /^[a-zA-Z0-9_]{3,16}$/,
    numero: /^[0-9]{1,10}$/,
};
campos = {
    nombre : false,
    telefono : false,
    nit : false
};

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "nombre_proveedor":
            validarCampo(expresiones.nombre, e.target, "nombre");
            break;
        case "telefono_proveedor":
            validarCampo(expresiones.numero, e.target, "telefono");
            break;
        case "nit_proveedor":
            validarCampo(expresiones.numero, e.target, "nit");
            break;
    }
};

const validarCampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document
            .getElementById(`grupo__${campo}`)
            .classList.remove("form-group__proveedor__incorrecto");
        document
            .getElementById(`grupo__${campo}`)
            .classList.add("form-group__proveedor__correcto");
        campos[campo] = true;
    } else {
        document
            .getElementById(`grupo__${campo}`)
            .classList.add("form-group__proveedor__incorrecto");
        document
            .getElementById(`grupo__${campo}`)
            .classList.remove("form-group__proveedor__correcto");
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
        campos.nombre && campos.telefono && campos.nit
    ) {
        formularioCrear.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});
