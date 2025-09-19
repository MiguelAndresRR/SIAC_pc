//Este script valida el formulario de editar, 
// nos permite verificar que se cumplan las condiciones y si no es el caso nos arroja un error. 
// Evitando que se pueda enviar.
const formularioEdit = document.getElementById("form_editar1");
const inputsEdit = document.querySelectorAll("#form_editar1 input");

const expresionesedit = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,25}$/,
    user: /^[a-zA-Z0-9_]{3,16}$/,
    numero: /^[0-9]{1,10}$/,
};

const campos = {
    usuario: false,
    apellido: false,
    user: false,
    telefono: false,
    documento: false,
};

const validarFormularioEdit = (e) => {
    switch (e.target.name) {
        case "nombre_usuario":
            validarCampoEdit(expresionesedit.nombre, e.target, "usuario");
            break;
        case "apellido_usuario":
            validarCampoEdit(expresionesedit.nombre, e.target, "apellido");
            break;
        case "user":
            validarCampoEdit(expresionesedit.user, e.target, "user");
            break;
        case "telefono_usuario":
            validarCampoEdit(expresionesedit.numero, e.target, "telefono");
            break;
        case "documento_usuario":
            validarCampoEdit(expresionesedit.numero, e.target, "documento");
            break;
    }
};

const validarCampoEdit = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.remove("form-group__usuario__incorrecto");
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.add("form-group__usuario__correcto");

        campos[campo] = true;
    } else {
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.add("form-group__usuario__incorrecto");
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.remove("form-group__usuario__correcto");

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

    if (campos.usuario && campos.apellido && campos.user && campos.telefono && campos.documento) {
        formularioEdit.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});
