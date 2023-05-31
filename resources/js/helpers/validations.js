const isRequired = (value) => !!value || "Campo Obligatorio.";
const isEmail = (value) =>
    /.+@.+\..+/.test(value) ? true : "El email debe ser válido.";
const maxLength = (value, max) =>
    value?.length <= max ? true : "Logingitud maxima " + max;
const isNumber = (value) =>
    /^[0-9]+$/.test(value) ? true : "Solo se permite números.";

export { isRequired, isEmail, maxLength, isNumber };
