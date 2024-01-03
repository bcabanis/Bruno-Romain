let avatar = ["Group75.png", "Group77.png", "Group76.png", "Group73.png", "Frame74.png", "Frame89.png", "Frame88.png", "Frame91.png", "Frame90.png", "Frame92.png"];

let divAvatar = document.querySelector('.divAvatar');
let labelFile = document.querySelector('.required');
let eventLabel;

function addAvatarPicture() {
    for (let i = 0; i < avatar.length; i++) {
        divAvatar.innerHTML += '<div class="avatarPicture col-sm-6"><img class="avatarImg" src="/assets/img/avatar/'+ avatar[i]+'" alt="Logo"></div>'
        
    }
}


labelFile.innerHTML = '<div class="imgPicture"><i class="fa-solid fa-upload"></i></div>';

addAvatarPicture();

