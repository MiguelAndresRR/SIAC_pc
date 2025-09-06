const formularioCrear = document.getElementById("formularioCliente");
const inputsCrear = document.querySelectorAll("#formularioCliente input");

const expresiones = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,25}$/,
    user: /^[a-zA-Z0-9_]{3,16}$/,
    numero: /^[0-9]{1,10}$/,
};
campos = {
    nombre: false,
    apellido: false,
    documento: false,
    telefono: false,
};

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "nombre_cliente":
            validarCampo(expresiones.nombre, e.target, "nombre");
            break;
        case "apellido_cliente":
            validarCampo(expresiones.nombre, e.target, "apellidos");
            break;
        case "documento_cliente":
            validarCampo(expresiones.numero, e.target, "documento");
            break;
        case "telefono_cliente":
            validarCampo(expresiones.numero, e.target, "telefono");
            break;
    }
};

const validarCampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document
            .getElementById(`grupo__${campo}`)
            .classList.remove("form-group__cliente__incorrecto");
        document
            .getElementById(`grupo__${campo}`)
            .classList.add("form-group__cliente__correcto");
        campos[campo] = true;
    } else {
        document
            .getElementById(`grupo__${campo}`)
            .classList.add("form-group__cliente__incorrecto");
        document
            .getElementById(`grupo__${campo}`)
            .classList.remove("form-group__cliente__correcto");
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
        campos.nombre &&
        campos.apellido &&
        campos.user &&
        campos.documento &&
        campos.telefono
    ) {
        formularioCrear.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});
