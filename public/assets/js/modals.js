document.addEventListener('DOMContentLoaded', (e) => {

    //@todo : Ajouter une classe pour de cibler que les formulaire devant lancer des modals
    const elements = document.querySelectorAll('form button.registration[type="submit"]');

    elements.forEach(function(element){
        element.addEventListener('click', (e) => {

            // annule le comportement normal du bouton
            e.preventDefault();

            const formData = new FormData(e.target.form);
            
            const hiddenElementName = e.target.form.name + '_destination';
            console.log(hiddenElementName);
            const url = document.getElementById(hiddenElementName).value;

            // const url = document.querySelector('form ');
            // Envoyer les données du formulaire au serveur
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.status == 200) {
                    let btn = document.querySelector('#modal .modal-footer button');
                    btn.classList.remove('btn-secondary');
                    btn.classList.add('btn-primary');
                    btn.innerHTML = 'Me connecter';
                    btn.addEventListener('click', (e) => {
                        document.location.replace('/login');
                    });
                }

                if (response.status == 200 || response.status == 401 ) { 
                    return response.text();
                }
            })
            .then(html => {
                document.querySelector('#modal .modal-body').innerHTML = html;
                const myModal = new bootstrap.Modal('#modal', {keyboard: false})
                myModal.show();
                // ici
            })
            .catch(error => {
                console.error('Une erreur s\'est produite lors de la validation :', error);
            });            
        });
    });

});