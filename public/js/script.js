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

//sidebar

document.addEventListener("DOMContentLoaded", function () {
    const sidebarLinks = document.querySelectorAll(".sidebar-link");

    sidebarLinks.forEach(link => {
        link.addEventListener("click", function () {
            sidebarLinks.forEach(l => l.classList.remove("bg-green-600"));
            this.classList.add("bg-green-600");
        });
    });
});


            //create.blade.php

document.addEventListener("DOMContentLoaded", function() {
    let fileInput = document.getElementById("file-input");
    let fileList = document.getElementById("file-list");
    let courrierForm = document.getElementById("courrier-form");

    // 🎯 Gestion de l'affichage des fichiers sélectionnés
    if (fileInput) {
        fileInput.addEventListener("change", function() {
            fileList.innerHTML = "";
            for (let file of fileInput.files) {
                let li = document.createElement("li");
                li.textContent = file.name;
                fileList.appendChild(li);
            }
        });
    }

    // 🚀 Validation du formulaire avant envoi
    if (courrierForm) {
        courrierForm.addEventListener("submit", function(event) {
            let reference = document.querySelector("[name='reference_expediteur']").value.trim();
            let objet = document.querySelector("[name='objet']").value.trim();
            let expediteur = document.querySelector("[name='expediteur']").value.trim();

            if (reference === "" || objet === "" || expediteur === "") {
                alert("❌ Veuillez remplir tous les champs obligatoires !");
                event.preventDefault(); // Empêcher l'envoi du formulaire
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".affecter-btn").forEach(button => {
        button.addEventListener("click", function() {
            let courrierId = this.getAttribute("data-id");

            fetch(`/courriers/affecter/${courrierId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Courrier affecté avec succès !");
                    location.reload(); // Rafraîchir la page pour voir les changements
                }
            })
            .catch(error => console.error("Erreur:", error));
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const destinataireSelect = document.getElementById('destinataire_id');
    const emailField = document.getElementById('email-destinataire');

    if (destinataireSelect && emailField) {
        destinataireSelect.addEventListener('change', function() {
            // Afficher seulement si "autre administration" est sélectionné
            if (this.value === 'autre') {
                emailField.style.display = 'block';
            } else {
                emailField.style.display = 'none';
            }
        });
        
        // Déclencher l'événement au chargement pour l'état initial
        destinataireSelect.dispatchEvent(new Event('change'));
    }
});