let popup = document.querySelector('#popupHome');
let getTogether = document.querySelector('.gettogethernew');
let pathRegister = "/registration";

function addPopUp() {
    popup.innerHTML = `<div class="bgpopupjoin"><div class="popupjoin"><img src="assets/img/logo-gettogether-black.svg" alt=""><h4>Nouvelle fonctionnalité<br>Get together</h4><p>Inscrivez-vous pour rejoindre notre nouvelle communauté dès maintenant !</p><a href="${pathRegister}">Je m’inscris</a></div></div>`;
}

getTogether.addEventListener('click', addPopUp);