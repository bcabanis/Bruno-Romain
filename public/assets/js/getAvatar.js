document.addEventListener("DOMContentLoaded", (e) => {
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
    button.classList.toggle("tag-choice-active");

    // ajoute l'item à la liste des tags ou l'en retire si besoin
    if (button.classList.contains("tag-choice-active")) {
      tagsChoices.push(button.textContent);
    } else {
      tagsChoices.splice(tagsChoices.indexOf(button.textContent), 1);
    }
  }

  // Récupérer tous les boutons avec la classe "tag-choice"
  const buttons = document.querySelectorAll(".tag-choice");

  // On met tous ces tags dans un tableau
  let activeButtonsArray = [];

  // Ajouter un gestionnaire d'événements "click" à chaque bouton
  buttons.forEach((button) => {
    button.addEventListener("click", handleTagChoiceClick);
  });

  // On crée une fonction qui va servir à afficher ou faire disparaitre certains "articles" grace à la searchbar.

  function handleCategorySelection() {
    // Récupérer la balise select par son ID
    const selectElement = document.getElementById("categories");

    // Récupérer les options sélectionnées
    const selectedOptions = Array.from(selectElement.selectedOptions);

    // Créer un tableau pour stocker les valeurs sélectionnées
    const selectedValues = selectedOptions.map((option) => option.value);

    // Récupérer tous les articles dans la section mestags
    const articles = document.querySelectorAll("#mestags article");

    // Parcourir chaque article
    articles.forEach((article) => {
      // Récupérer chaque categorie de l'article (utiliser l'ID de l'article sans le préfixe "#")
      const category = article.id;

      // Vérifier si la categorie de l'article est incluse dans les valeurs sélectionnées
      if (selectedValues.includes(category)) {
        article.style.display = "block";
      } else {
        // Sinon, masquer l'article
        article.style.display = "none";
      }
    });
  }

  // Ajouter un gestionnaire d'événements "change" à la balise select avec l'ID "categories"

  document
    .getElementById("categories")
    .addEventListener("change", handleCategorySelection);

  function handleSearch() {
    // Récupérer la valeur saisie dans la barre de recherche
    const searchString = document
      .getElementById("tagsearch")
      .value.toLowerCase();
    // Récupérer tous les titres d'article (éléments h2) dans la section mestags
    const articleTitles = document.querySelectorAll("#mestags article h2");
    // Parcourir chaque titre d'article
    articleTitles.forEach((title) => {
      // Récupérer le texte du titre d'article
      const titleText = title.textContent.toLowerCase();
      // Vérifier si le texte du titre d'article contient la chaîne de caractères saisie dans la recherche
      if (titleText.includes(searchString)) {
        // Si le titre d'article contient la chaîne de caractères saisie, afficher l'article parent
        title.parentElement.style.display = "block";
      } else {
        // Sinon masquer l'article parent
        title.parentElement.style.display = "none";
      }
    });
  }

  // Ajouter un gestionnaire d'événements "input" à la barre de recherche avec l'ID "tagsearch"
  document.getElementById("tagsearch").addEventListener("input", handleSearch);

  // récupère le bouton "btn-tags-save" (si présent)
  let btnTags = document.getElementById("btn-tags-save");

  // si on l'a terouvé
  if (btnTags) {
    // ajout de l'évènement click sur le bouton
    btnTags.addEventListener("click", (e) => {
      // console.log(tagsChoices);
      let jsonOutput = JSON.stringify(tagsChoices);

      fetch("/tags/save/" + jsonOutput)
        .then((response) => {
          if (response.status == 200) {
            //document.location.replace('/route_e_lancer');
            return response.text();
          }
        })
        .then((json) => {
          console.log(JSON.parse(json));
        });
    });
  }
});
