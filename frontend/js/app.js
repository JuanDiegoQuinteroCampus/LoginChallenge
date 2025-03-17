document.getElementById("loginForm").addEventListener("submit", async function (event) {
    event.preventDefault();
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    if (email.trim() === "" || password.trim() === "") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Please enter both email and password!",
        });
        return;
    }

    if(!validateMail(email)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Invalid email",
        });
        return;
    }

    if (password.length < 6) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Password must be at least 6 characters!",
        });
        return;
    }

    spinner(); 
    await proccesingLogin(email, password);
});

async function proccesingLogin(email, password) {
    return new Promise((resolve) => {
        setTimeout(async () => {
            const success = await sendData(email, password); 
            // spinner(false); // Ocultar spinner
            if (success) {
               localStorage.setItem("timeLogin", success.time);
               localStorage.setItem("id", success.id);
               localStorage.setItem("email", success.email);
               window.location.href = './successLogin.html'
            }
            resolve();
        }, 2000); 
    });
}

async function sendData(email, password) {
    try {
        let response = await fetch("http://localhost:8000/", {
            method: "POST",
            body: new URLSearchParams({ action: 1, email, password }),
        });

        let data = await response.json();
        console.log(data);
        if (!response.ok || data.error) throw new Error(data.error || `Error: ${response.status}`);
        return data.data;
    } catch (error) {
        Swal.fire({ icon: "error", title: "Oops...", text: error.message || "Connection failed" });
        return false;
    }
}

function succeessLogin(){
    document.getElementById('content1').classList.add('d-none')
}

function spinner(status = true) {
    const spinner = document.getElementById("spinner");
    status ? spinner.classList.remove("d-none") : spinner.classList.add("d-none");
}

function validateMail(correo) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(correo);
}