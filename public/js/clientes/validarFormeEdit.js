const formularioEdit = document.getElementById("form_editar-clientes");
const inputsEdit = document.querySelectorAll("#form_editar-clientes input");

const expresionesedit = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,25}$/,
    user: /^[a-zA-Z0-9_]{3,16}$/,
    numero: /^[0-9]{1,10}$/,
};

const campos = {
    nombre: false,
    apellido: false,
    telefono: false,
    documento: false,
};

const validarFormularioEdit = (e) => {
    switch (e.target.name) {
        case "nombre_cliente":
            validarCampoEdit(expresionesedit.nombre, e.target, "nombre");
            break;
        case "apellido_cliente":
            validarCampoEdit(expresionesedit.nombre, e.target, "apellidos");
            break;
        case "telefono_cliente":
            validarCampoEdit(expresionesedit.numero, e.target, "telefono");
            break;
        case "documento_cliente":
            validarCampoEdit(expresionesedit.numero, e.target, "documento");
            break;
    }
};

const validarCampoEdit = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.remove("form-group__cliente__incorrecto");
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.add("form-group__cliente__correcto");
        campos[campo] = true;
    } else {
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.add("form-group__cliente__incorrecto");
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.remove("form-group__cliente__correcto");

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

    if (campos.nombre && campos.apellido && campos.user && campos.telefono && campos.documento) {
        formularioEdit.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});
