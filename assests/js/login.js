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