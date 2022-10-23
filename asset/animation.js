const progressBar = document.getElementById("progress-bar");
const progressNext = document.getElementById("Next");
const progressPrev = document.getElementById("Previous");
const accountID = document.getElementById("account_noo")
const steps = document.querySelectorAll(".step");
let active = 1;


var filter_account = /^[0-9]{10}$/;
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
function validate() {
    var v = document.getElementById("amount").value;
    if (isNaN(v)) {
        document.getElementById("msg").innerHTML = "Should be a Number";
    }
    else {
        document.getElementById("msg").innerHTML = "";
    }
}
function checkAccount() {
    var account = document.getElementById("account_noo").value;
    if (!filter_account.test(account)) {
        document.getElementById("account_noo").setCustomValidity("Invalid account number!");
        document.getElementById("account_noo").reportValidity();
        return false;
    }
    else {
        document.getElementById("account_noo").setCustomValidity("")
        return true;
    }
}
function checkAll() {
    if (checkAccount() && validate()) { return true; }
    else {
        alert("Please enter all information correctly!");
        return false;
    }
}
const updateProgress = () => {
    // toggle active class on list items
    steps.forEach((step, i) => {
        if (i < active) {
            step.classList.add("active");
        } else {
            step.classList.remove("active");
        }
    });
    // set progress bar width  
    progressBar.style.width =
        ((active - 1) / (steps.length - 1)) * 100 + "%";
    // enable disable prev and next buttons
    if (active === 1) {
        progressPrev.disabled = true;
    } else if (active === steps.length) {
        progressNext.disabled = true;
    } else {
        progressPrev.disabled = false;
        progressNext.disabled = false;
    }
};

progressNext.addEventListener("click", () => {
    active++;
    if (active > steps.length) {
        active = steps.length;
    }
    updateProgress();

});

progressPrev.addEventListener("click", () => {
    active--;
    if (active < 1) {
        active = 1;
    }
    updateProgress();
    console.log(active)

});

