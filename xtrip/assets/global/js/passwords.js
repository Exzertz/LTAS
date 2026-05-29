
const togglePasswords = (classNames) => {
    const passwords = document.querySelectorAll(`.${classNames}`);

    passwords.forEach((field) => {
        field.type = field.type === "text" ? "password" : "text";
    });
}
