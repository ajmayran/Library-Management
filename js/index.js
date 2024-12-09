const container = document.getElementById('container');
const registerBtn = document.getElementById('login_adm');
const loginBtn = document.getElementById('login_stud');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});