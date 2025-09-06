const formularioEdit = document.getElementById("FormularioProveedorEditar");
const inputsEdit = document.querySelectorAll("#FormularioProveedorEditar input");

const expresionesedit = {
    nombre: /^[a-zA-ZÁ-ÿ\s]{3,25}$/,
    numero: /^[0-9]{1,10}$/,
};

const campos = {
    nombre: false,
    nit :false,
    telefono: false,
};

const validarFormularioEdit = (e) => {
    switch (e.target.name) {
        case "nombre_proveedor":
            validarCampoEdit(expresionesedit.nombre, e.target, "nombre");
            break;
        case "telefono_proveedor":
            validarCampoEdit(expresionesedit.numero, e.target, "telefono");
            break;
        case "nit_proveedor":
            validarCampoEdit(expresionesedit.numero, e.target, "nit");
            break;
    }
};

const validarCampoEdit = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document
            .getElementById(`grupo_${campo}_edit`)
            .classList.remove("form-group__proveedor__incorrecto");
        document
            .getElementById(`grupo__${campo}_edit`)
            .classList.add("form-group__proveedor__correcto");

        campos[campo] = true;
    } else {
        document
            .getElementById(`grupo_${campo}_edit`)
            .classList.add("form-group__proveedor__incorrecto");
        document
            .getElementById(`grupo_${campo}_edit`)
            .classList.remove("form-group__proveedor__correcto");

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

    if (campos.nombre && campos.nit && campos.telefono) {
        formularioEdit.submit();
    } else {
        alert("Por favor completa los campos correctamente.");
    }
});
