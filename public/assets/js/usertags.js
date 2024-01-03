document.addEventListener('DOMContentLoaded', (e) => { 

  let tagsChoices = [];


// Fonction pour le traitement du clic sur un bouton tag-choice
function handleTagChoiceClick(event) {
    const button = event.target; // Récupérer le bouton sur lequel le clic s'est produit
    toggleTagChoice(button); // Appeler la fonction pour basculer les classes
    ListeDeBoutons(); // Mise à jour du tableau actif lorsqu'un bouton est cliqué
  }
  
  // Fonction pour basculer les classes du bouton
  function toggleTagChoice(button) {

    // Ajouter ou retirer la classe "tag-choice-active" du tag
    button.classList.toggle('tag-choice-active');

    // ajoute l'item à la liste des tags ou l'en retire si besoin
    if (button.classList.contains("tag-choice-active")) {
      tagsChoices.push(button.textContent);
    } else {
      tagsChoices.splice(tagsChoices.indexOf(button.textContent), 1);
    }
    
    // if (button.classList.contains('tag-choice')) {
    //   button.classList.remove('tag-choice'); // Le bouton est "tag-choice", on le transforme en "tag-choice-active"
    //   button.classList.add('tag-choice-active');
    // } else if (button.classList.contains('tag-choice-active')) {
    //   button.classList.remove('tag-choice-active'); // Le bouton est "tag-choice-active", on le transforme en "tag-choice"
    //   button.classList.add('tag-choice');
    // }
  }
  
  // Récupérer tous les boutons avec la classe "tag-choice"
  const buttons = document.querySelectorAll('.tag-choice');
  
  // On met tous ces tags dans un tableau
  let activeButtonsArray = [];
  
  // Ajouter un gestionnaire d'événements "click" à chaque bouton
  buttons.forEach(button => {
    button.addEventListener('click', handleTagChoiceClick);
  });
  
  // On va générer le contenu du tableau actif 
  function ListeDeBoutons() {

    // On récupère tous les boutons actifs avec la classe "tag-choice-active"
    // activeButtonsArray = document.querySelectorAll('.tag-choice-active');
  
    // activeButtonsArray.forEach(button => {
      
    // });

    // // On crée une liste à puces pour afficher les éléments
    // let MegaListe = document.createElement('ul');
    // // Parcourir le tableau actif et créer un élément de liste (li) pour chaque élément
    // activeButtonsArray.forEach(button => {
    //   let MegaListeItem = document.createElement('li');
    //   MegaListeItem.textContent = button.textContent; // On utilise le contenu du bouton comme texte de la liste
    //   MegaListe.appendChild(MegaListeItem); // On ajoute l'élément de liste à la liste à puce
    // });
  
    // // On récupère l'élément div dans lequel nous afficherons le contenu du tableau
    // let activeButtonsContainer = document.getElementById('active-buttons-container');
  
    // // On efface le contenu précédent du conteneur
    // activeButtonsContainer.innerHTML = '';
  
    // // On ajoute la liste à puces au conteneur
    // activeButtonsContainer.appendChild(MegaListe);

  }
  
  // On appelle la fonction pour générer le contenu d'un tableau actif initialement
  ListeDeBoutons();
  
  ////////////

// On crée une fonction qui va servir à afficher ou faire disparaitre certains "articles" grace à la searchbar.

function handleCategorySelection() {

  // Récupérer la balise select par son ID
  const selectElement = document.getElementById('categories');

  // Récupérer les options sélectionnées
  const selectedOptions = Array.from(selectElement.selectedOptions);

  // Créer un tableau pour stocker les valeurs sélectionnées 
  const selectedValues = selectedOptions.map(option => option.value);

  // Récupérer tous les articles dans la section mestags
  const articles = document.querySelectorAll('#mestags article');

  // Parcourir chaque article 
  articles.forEach(article => {

    // Récupérer chaque categorie de l'article (utiliser l'ID de l'article sans le préfixe "#")
    const category = article.id;

    // Vérifier si la categorie de l'article est incluse dans les valeurs sélectionnées 
    if (selectedValues.includes (category)) {
      article.style.display = 'block';
      } else {
        // Sinon, masquer l'article 
      article.style.display = 'none';
      }
  });
}

  // Ajouter un gestionnaire d'événements "change" à la balise select avec l'ID "categories"

  document.getElementById('categories').addEventListener('change', handleCategorySelection);


  function handleSearch() {
    // Récupérer la valeur saisie dans la barre de recherche
    const searchString = document.getElementById('tagsearch').value.toLowerCase();
    // Récupérer tous les titres d'article (éléments h2) dans la section mestags
    const articleTitles = document.querySelectorAll('#mestags article h2');
    // Parcourir chaque titre d'article
    articleTitles.forEach(title => {
      // Récupérer le texte du titre d'article 
      const titleText = title.textContent.toLowerCase();
      // Vérifier si le texte du titre d'article contient la chaîne de caractères saisie dans la recherche
      if (titleText.includes(searchString)) {
        // Si le titre d'article contient la chaîne de caractères saisie, afficher l'article parent
        title.parentElement.style.display = 'block';
      } else {
        // Sinon masquer l'article parent
        title.parentElement.style.display = "none";
      }
    });
  }
  
  // Ajouter un gestionnaire d'événements "input" à la barre de recherche avec l'ID "tagsearch"
  document.getElementById('tagsearch').addEventListener('input', handleSearch);
  
  // récupère le bouton "btn-tags-save" (si présent)
  let btnTags = document.getElementById('btn-tags-save');

  // si on l'a terouvé
  if (btnTags) {

    // ajout de l'évènement click sur le bouton
    btnTags.addEventListener('click', (e) => {

      // console.log(tagsChoices);
      let jsonOutput = JSON.stringify(tagsChoices);

      fetch('/mestags/save/' + jsonOutput)
      .then(response => {
        
        if (response.status == 200) {
          //document.location.replace('/route_e_lancer'); // Jean-Serge
          // window.location.href = '/dashboard'; // Romain
          // Apparemment ça fait quasiment pareil mais ça marche pas
          return response.text();
        }
      })
      .then(json => {
        console.log(JSON.parse(json));
        
      })


    });


  }

});