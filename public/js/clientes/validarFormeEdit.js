const formularioEdit = document.getElementById("form_editar-clientes");
const inputsEdit = document.querySelectorAll("#form_editar-clientes input");

const expresionesedit = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,25}$/,

    numero: /^[0-9]{1,10}$/,
};

const campos1 = {
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
            validarCampoEdit(expresionesedit.nombre, e.target, "apellido");
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
        campos1[campo] = true;
    } else {
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.add("form-group__cliente__incorrecto");

        campos1[campo] = false;
    }
};

inputsEdit.forEach((input) => {
    input.addEventListener("keyup", validarFormularioEdit);
    input.addEventListener("blur", validarFormularioEdit);
});

formularioEdit.addEventListener("submit", (e) => {
    e.preventDefault();
    inputsEdit.forEach((input) => validarFormularioEdit({ target: input }));

    if (campos1.nombre && campos1.apellido && campos1.telefono && campos1.documento) {
        formularioEdit.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});
