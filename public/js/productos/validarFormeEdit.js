//Este script valida el formulario de editar, 
// nos permite verificar que se cumplan las condiciones y si no es el caso nos arroja un error. 
// Evitando que se pueda enviar.
const formularioEdit = document.getElementById("form_editar");
const inputsEdit = document.querySelectorAll("#form_editar input");

const expresionesedit = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,20}$/,
    numero: /^\d{1,10}(\.\d+)?$/
};

const campos = {
    nombre: false,
    precio : false,
};

const validarFormularioEdit = (e) => {
    switch (e.target.name) {
        case "nombre_producto":
            validarCampoEdit(expresionesedit.nombre, e.target, "nombre");
            break;
        case "precio_producto":
            validarCampoEdit(expresionesedit.numero, e.target, "precio");
            break;
    }
};

const validarCampoEdit = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.remove("form-group__producto__incorrecto");
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.add("form-group__producto__correcto");

        campos[campo] = true;
    } else {
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.add("form-group__producto__incorrecto");
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.remove("form-group__producto__correcto");

        campos[campo] = false;
    }
};

inputsEdit.forEach((input) => {
    input.addEventListener("keyup", validarFormularioEdit);
    input.addEventListener("blur", validarFormularioEdit);
});

formularioEdit.addEventListener("submit", (e) => {
    e.preventDefault();

    inputsEdit.forEach((input) => validarFormularioEdit({ target: input }));

    if (campos.nombre && campos.precio) {
        formularioEdit.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});
