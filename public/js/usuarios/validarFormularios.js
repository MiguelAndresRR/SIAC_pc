const formularioCrear = document.getElementById("formularioUsuarios");
const inputsCrear = document.querySelectorAll("#formularioUsuarios input");

const expresiones = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,25}$/,
    user: /^[a-zA-Z0-9_]{3,16}$/,
    numero: /^[0-9]{1,10}$/,
};
campos = {
    usuario: false,
    apellido: false,
    user: false,
    documento: false,
    telefono: false,
};

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "nombre_usuario":
            validarCampo(expresiones.nombre, e.target, "usuario");
            break;
        case "apellido_usuario":
            validarCampo(expresiones.nombre, e.target, "apellido");
            break;
        case "user":
            validarCampo(expresiones.user, e.target, "user");
            break;
        case "documento_usuario":
            validarCampo(expresiones.numero, e.target, "documento");
            break;
        case "telefono_usuario":
            validarCampo(expresiones.numero, e.target, "telefono");
            break;
    }
};

const validarCampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document
            .getElementById(`grupo__${campo}`)
            .classList.remove("form-group__usuario__incorrecto");
        document
            .getElementById(`grupo__${campo}`)
            .classList.add("form-group__usuario__correcto");
        campos[campo] = true;
    } else {
        document
            .getElementById(`grupo__${campo}`)
            .classList.add("form-group__usuario__incorrecto");
        document
            .getElementById(`grupo__${campo}`)
            .classList.remove("form-group__usuario__correcto");
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
        campos.usuario &&
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
