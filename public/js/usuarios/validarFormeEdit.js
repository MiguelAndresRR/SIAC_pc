const formularioEdit = document.getElementById("form_editar1");
const inputsEdit = document.querySelectorAll("#form_editar1 input");

const expresionesedit = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,25}$/,
    user: /^[a-zA-Z0-9_]{3,16}$/,
};

const campos = {
    usuario: false,
    apellido: false,
    user: false,
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

    if (campos.usuario && campos.apellido && campos.user) {
        formularioEdit.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});