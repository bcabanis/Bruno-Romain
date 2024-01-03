// categories.js

document.addEventListener('DOMContentLoaded', function() {
    const categoryButtons = document.querySelectorAll('.category-btn');
  
    categoryButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Récupérer l'élément de sous-catégorie associé au bouton cliqué
        const subCategory = button.nextElementSibling;
  
        // Afficher/masquer la sous-catégorie en utilisant la propriété "display"
        if (subCategory.style.display === 'none') {
          subCategory.style.display = 'block';
        } else {
          subCategory.style.display = 'none';
        }
      });
    });
  });
  

