const loginBtn = document.getElementById("loginBtn");
const registerBtn = document.getElementById("registerBtn");

const loginModal = document.getElementById("loginModal");
const registerModal = document.getElementById("registerModal");

const closeLogin = document.getElementById("closeLogin");
const closeRegister = document.getElementById("closeRegister");

function setActiveTrigger(trigger) {
    document.querySelectorAll(".auth-trigger").forEach(function (el) {
        el.classList.remove("is-active");
    });
    if (trigger) {
        trigger.classList.add("is-active");
    }
}

function openModal(modal) {
    closeModal(loginModal);
    closeModal(registerModal);
    modal.classList.add("is-open");
}

function closeModal(modal) {
    modal.classList.remove("is-open");
    if (!loginModal.classList.contains("is-open") && !registerModal.classList.contains("is-open")) {
        setActiveTrigger(null);
    }
}

if (loginBtn) {
    loginBtn.addEventListener("click", function (event) {
        event.preventDefault();
        openModal(loginModal);
        setActiveTrigger(loginBtn);
    });
}

if (registerBtn) {
    registerBtn.addEventListener("click", function (event) {
        event.preventDefault();
        openModal(registerModal);
        setActiveTrigger(registerBtn);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);

    if (params.get("showModel") === "1") {
        openModal(loginModal);
        setActiveTrigger(loginBtn);
    } else if (params.get("showModel") === "2") {
        openModal(registerModal);
        setActiveTrigger(registerBtn);
    } else if (params.get("showModel") === "3") {
        alert("Login Failed! Please check your credentials and try again.");
        openModal(loginModal);
        setActiveTrigger(loginBtn);
    } else if (params.get("showModel") === "4") {
        alert("Registration Successful! Please login with your credentials.");
        openModal(loginModal);
        setActiveTrigger(loginBtn);
    } else if (params.get("showModel") === "5") {
        alert("You password does not match with the re-entered password!");
        openModal(registerModal);
        setActiveTrigger(registerBtn);
    } else if (params.get("showModel") === "6") {
        alert("the email you entered is already registered! Please use a different email or login with your credentials.");
        openModal(registerModal);
        setActiveTrigger(registerBtn);
    } else if (params.get("showModel") === "7") {
        const error = params.get("error");
        alert("Registration Failed! " + error);
        openModal(registerModal);
        setActiveTrigger(registerBtn);
    }else{
        openModal(loginModal);
        setActiveTrigger(loginBtn);
    }
});

closeLogin.addEventListener("click", function () {
    closeModal(loginModal);
});

closeRegister.addEventListener("click", function () {
    closeModal(registerModal);
});

loginModal.addEventListener("click", function (event) {
    if (event.target === loginModal) {
        closeModal(loginModal);
    }
});

registerModal.addEventListener("click", function (event) {
    if (event.target === registerModal) {
        closeModal(registerModal);
    }
});

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeModal(loginModal);
        closeModal(registerModal);
    }
});

document.getElementById("province").addEventListener("change", function () {
    const provinceId = this.value;
    fetch("../controllers/getDistrict.php?province_id=" + provinceId)
        .then(response => response.text())
        .then(data => {
            document.getElementById("district").innerHTML = data;
        });
});

const loginForm = document.querySelector("#loginModal form");

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

function validateLoginField(input) {
    const name = input.getAttribute("name");
    const value = input.value.trim();
    clearError(input);
    if (!value) {
        showError(input, name === "username" ? "Username is required." : "Password is required.");
        return false;
    }
    return true;
}

if (loginForm) {
    const loginInputs = loginForm.querySelectorAll("input");

    loginInputs.forEach(function (input) {
        input.addEventListener("blur", function () {
            validateLoginField(this);
        });
        input.addEventListener("input", function () {
            if (this.classList.contains("input-error")) {
                validateLoginField(this);
            }
        });
    });

    loginForm.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            const target = e.target;
            if (target.tagName === "INPUT") {
                e.preventDefault();
                loginForm.dispatchEvent(new Event("submit", { cancelable: true }));
            }
        }
    });

    loginForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        let valid = true;
        loginInputs.forEach(function (input) {
            if (!validateLoginField(input)) {
                valid = false;
            }
        });

        if (!valid) {
            const firstError = loginForm.querySelector(".input-error");
            if (firstError) firstError.focus();
            return;
        }

        const formData = new FormData(loginForm);
        try {
            const res = await fetch(loginForm.action, {
                method: "POST",
                body: formData,
                headers: { "X-Requested-With": "XMLHttpRequest" }
            });
            const data = await res.json();
            if (data.status === "error") {
                const passwordInput = loginForm.querySelector("input[name='password']");
                showError(passwordInput, data.message);
                passwordInput.focus();
            } else if (data.status === "success") {
                window.location.href = data.redirect;
            }
        } catch {
            loginForm.submit();
        }
    });
}