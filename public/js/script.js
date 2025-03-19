document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".btn");
    
    buttons.forEach(button => {
        button.addEventListener("mouseenter", () => {
            button.style.backgroundColor = "#2F855A";  // Changer la couleur au survol
        });

        button.addEventListener("mouseleave", () => {
            button.style.backgroundColor = "#38A169";  // Revenir à la couleur d'origine
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        document.getElementById("loader").style.display = "none";
        document.getElementById("content").classList.remove("hidden");
    }, 2000); // Temps de chargement simulé
});

// script.js
document.addEventListener('DOMContentLoaded', function () {
    const roleCards = document.querySelectorAll('.block');

    roleCards.forEach(card => {
        card.addEventListener('click', function () {
            const role = this.querySelector('p').textContent.trim();
            alert(`Vous avez sélectionné le rôle : ${role}`);
            // Redirection ou autre logique ici
        });
    });
});