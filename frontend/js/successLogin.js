document.addEventListener("DOMContentLoaded", function() {
    const timeLogin = localStorage.getItem("timeLogin");
    const id = localStorage.getItem("id");
    const email = localStorage.getItem("email");
    if (!timeLogin && !id && !email ) {
        logOut();
    }

    let loginTime = new Date(timeLogin);
    let now = new Date();

    if (now  > loginTime) {
        Swal.fire({
            title: "Session Ended",
            text: "Your session has expired. You will be redirected.",
            icon: "warning",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed || result.dismiss === Swal.DismissReason.close) {
                logOut();
            }
        });
    }
    document.getElementById('email').textContent = email;
});

document.getElementById('logout').addEventListener("click", function (e) {
    Swal.fire({
        title: "Are you sure you are logged out?",
        text: "You will be logged out and will have to log in again.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, log out",
        cancelButtonText: "Cancel",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            spinner();
            logOut();
        }
    });
  });

function logOut(){
    localStorage.clear();
    window.location.href = './index.html';
}

function spinner(status = true) {
    const spinner = document.getElementById("spinner");
    status ? spinner.classList.remove("d-none") : spinner.classList.add("d-none");
}