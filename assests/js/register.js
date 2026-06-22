const registerForm = document.querySelector("#registerModal form");

function showError(input, message) {
    const existing = input.parentElement.querySelector(".error-message");
    if (existing) existing.remove();
    input.classList.add("input-error");
    const error = document.createElement("span");
    error.className = "error-message";
    error.textContent = message;
    input.parentElement.insertBefore(error, input.nextSibling);
}

function clearError(input) {
    const existing = input.parentElement.querySelector(".error-message");
    if (existing) existing.remove();
    input.classList.remove("input-error");
}

function validateUsername(username) {
    return username.trim().length > 0;
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validateContact(contact) {
    return /^07\d{8}$/.test(contact);
}

function validateAddress(address) {
    return /,/.test(address);
}

function validatePassword(password) {
    return password.length >= 6 && /[A-Z]/.test(password) && /[a-z]/.test(password) && /[0-9]/.test(password);
}

function validatePostalCode(code) {
    return code.length > 0;
}

function validateField(input) {
    const name = input.getAttribute("name");
    const value = input.value.trim();

    clearError(input);

    if (input.hasAttribute("required") && !value) {
        showError(input, "This field is required.");
        return false;
    }

    if (name === "username" && value && !validateUsername(value)) {
        showError(input, "Please enter a username.");
        return false;
    }

    if (name === "firstName" && value && value.length < 1) {
        showError(input, "Please enter your first name.");
        return false;
    }

    if (name === "lastName" && value && value.length < 1) {
        showError(input, "Please enter your last name.");
        return false;
    }

    if (name === "email" && value && !validateEmail(value)) {
        showError(input, "Please enter a valid email address.");
        return false;
    }

    if (name === "contact" && value && !validateContact(value)) {
        showError(input, "Contact number must start with 07 and be exactly 10 digits.");
        return false;
    }

    if (name === "address" && value && !validateAddress(value)) {
        showError(input, "Address must be separated by commas (e.g., street, city, province).");
        return false;
    }

    if (name === "password" && value && !validatePassword(value)) {
        showError(input, "Password must be at least 6 characters with at least one uppercase letter, one lowercase letter, and one number.");
        return false;
    }

    if (name === "confirmPassword" && value) {
        const password = registerForm.querySelector("input[name='password']");
        if (value !== password.value.trim()) {
            showError(input, "Passwords do not match.");
            return false;
        }
    }

    if (name === "postalCode" && value && !validatePostalCode(value)) {
        showError(input, "Please enter a valid postal code.");
        return false;
    }

    return true;
}

async function checkUsernameAvailability(input) {
    const value = input.value.trim();
    if (!value) return true;
    try {
        const res = await fetch("../controllers/checkUsername.php?username=" + encodeURIComponent(value));
        const data = await res.json();
        clearError(input);
        if (data.exists) {
            showError(input, "This username is already taken.");
            return false;
        }
        return true;
    } catch {
        return true;
    }
}

const registerMessage = document.getElementById("registerMessage");

function showFormMessage(message, type) {
    registerMessage.textContent = message;
    registerMessage.className = "form-message " + (type || "");
    registerMessage.style.display = message ? "block" : "none";
}

if (registerForm) {
    const inputs = registerForm.querySelectorAll("input, select");
    inputs.forEach(input => {
        input.addEventListener("blur", function () {
            validateField(this);
            if (this.getAttribute("name") === "username" && this.value.trim()) {
                checkUsernameAvailability(this);
            }
        });
        input.addEventListener("input", function () {
            if (this.classList.contains("input-error")) {
                validateField(this);
            }
        });
    });

    registerForm.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            const target = e.target;
            if (target.tagName === "INPUT" || target.tagName === "SELECT") {
                e.preventDefault();
                registerForm.dispatchEvent(new Event("submit", { cancelable: true }));
            }
        }
    });

    const modalContent = registerForm.closest(".modal-content");
    if (modalContent) {
        modalContent.addEventListener("mousedown", function (e) {
            e.stopPropagation();
        });
        modalContent.addEventListener("dblclick", function (e) {
            e.stopPropagation();
        });
    }

    registerForm.addEventListener("submit", async function (e) {
        e.preventDefault();
        showFormMessage("", "");

        let valid = true;
        for (const input of inputs) {
            if (!validateField(input)) {
                valid = false;
            }
        }
        const usernameInput = registerForm.querySelector("input[name='username']");
        if (usernameInput && usernameInput.value.trim()) {
            const available = await checkUsernameAvailability(usernameInput);
            if (!available) valid = false;
        }
        if (!valid) {
            const firstError = registerForm.querySelector(".input-error");
            if (firstError) firstError.focus();
            return;
        }

        const formData = new FormData(registerForm);
        try {
            const res = await fetch(registerForm.action, {
                method: "POST",
                body: formData,
                headers: { "X-Requested-With": "XMLHttpRequest" }
            });
            const data = await res.json();

            if (data.status === "error") {
                if (data.field) {
                    const field = registerForm.querySelector("[name='" + data.field + "']");
                    if (field) showError(field, data.message);
                } else {
                    showFormMessage(data.message, "error");
                }
            } else if (data.status === "success") {
                registerForm.reset();
                document.querySelectorAll(".error-message").forEach(e => e.remove());
                document.querySelectorAll(".input-error").forEach(e => e.classList.remove("input-error"));
                showFormMessage(data.message, "success");
                setTimeout(function () {
                    openModal(loginModal);
                    setActiveTrigger(loginBtn);
                }, 1500);
            }
        } catch {
            showFormMessage("Something went wrong. Please try again.", "error");
        }
    });
}
