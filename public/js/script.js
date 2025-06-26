document.addEventListener("DOMContentLoaded", function () {
    // 🎨 Boutons : changement de couleur au survol
    document.querySelectorAll(".btn").forEach(button => {
        button.addEventListener("mouseenter", () => {
            button.style.backgroundColor = "#2F855A";
        });
        button.addEventListener("mouseleave", () => {
            button.style.backgroundColor = "#38A169";
        });
    });

    // ⏳ Loader (chargement de la page)
    const loader = document.getElementById("loader");
    const content = document.getElementById("content");
    if (loader && content) {
        setTimeout(() => {
            loader.style.display = "none";
            content.classList.remove("hidden");
        }, 2000);
    }

    // 🧩 Sélection des rôles (ex : Admin, Agent, etc.)
    document.querySelectorAll('.block').forEach(card => {
        card.addEventListener('click', function () {
            const role = this.querySelector('p')?.textContent.trim();
            if (role) alert(`Vous avez sélectionné le rôle : ${role}`);
        });
    });

    // 📚 Sidebar : surbrillance sur lien actif
    document.querySelectorAll(".sidebar-link").forEach(link => {
        link.addEventListener("click", function () {
            document.querySelectorAll(".sidebar-link").forEach(l => l.classList.remove("bg-green-600"));
            this.classList.add("bg-green-600");
        });
    });

    // 📎 Upload de fichiers dans le formulaire de courrier
    const fileInput = document.getElementById("file-input");
    const fileList = document.getElementById("file-list");
    if (fileInput && fileList) {
        fileInput.addEventListener("change", () => {
            fileList.innerHTML = "";
            Array.from(fileInput.files).forEach(file => {
                const li = document.createElement("li");
                li.textContent = file.name;
                fileList.appendChild(li);
            });
        });
    }

    // 🧾 Validation du formulaire de courrier
    const courrierForm = document.getElementById("courrier-form");
    if (courrierForm) {
        courrierForm.addEventListener("submit", function (event) {
            const reference = document.querySelector("[name='reference_expediteur']")?.value.trim();
            const objet = document.querySelector("[name='objet']")?.value.trim();
            const expediteur = document.querySelector("[name='expediteur']")?.value.trim();

            if (!reference || !objet || !expediteur) {
                alert("❌ Veuillez remplir tous les champs obligatoires !");
                event.preventDefault();
            }
        });
    }

    // ✅ Affectation de courriers (AJAX)
    document.querySelectorAll(".affecter-btn").forEach(button => {
        button.addEventListener("click", function () {
            const courrierId = this.getAttribute("data-id");
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

            fetch(`/courriers/affecter/${courrierId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Courrier affecté avec succès !");
                    location.reload();
                }
            })
            .catch(error => console.error("Erreur:", error));
        });
    });

    // 📬 Destinataire : afficher champ email et pré-remplir si possible
    const destinataireSelect = document.getElementById('destinataire_id');
    const emailField = document.getElementById('email-destinataire');
    const emailInput = document.getElementById('email_destinataire');

    if (destinataireSelect && emailField && emailInput) {
        destinataireSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            if (this.value !== '') {
                emailField.classList.remove('hidden');
                if (this.value === 'autre') {
                    emailInput.value = '';
                } else {
                    emailInput.value = selected.getAttribute('data-email') || '';
                }
                emailInput.required = true;
                emailInput.focus();
            } else {
                emailField.classList.add('hidden');
                emailInput.value = '';
                emailInput.required = false;
            }
        });

        // Afficher le champ si une valeur est déjà sélectionnée au chargement
        if (destinataireSelect.value !== '') {
            emailField.classList.remove('hidden');
            emailInput.required = true;
        }
    }

    // 📤 Type de destinataire : agent, service ou email
    const destinataireType = document.getElementById('destinataire_type');
    const agentField = document.getElementById('agent_field');
    const serviceField = document.getElementById('service_field');

    if (destinataireType && agentField && serviceField && emailField && emailInput) {
        destinataireType.addEventListener('change', function () {
            const type = this.value;
            agentField.style.display = type === 'agent' ? 'block' : 'none';
            serviceField.style.display = type === 'service' ? 'block' : 'none';
            emailField.style.display = type !== '' ? 'block' : 'none';
            emailInput.required = type !== '';
        });
    }

    // 📧 Mise à jour automatique de l'email selon agent sélectionné
    const agentSelect = document.getElementById('destinataire_id_agent');
    if (agentSelect && emailInput) {
        agentSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const email = selectedOption.getAttribute('data-email');
            emailInput.value = email || '';
        });
    }

    // ⌛ Affichage du loader au moment de soumettre un formulaire
    const form = document.querySelector('form');
    const loading = document.getElementById('loading');
    if (form && loading) {
        form.addEventListener('submit', function () {
            loading.style.display = 'flex';
        });
    }

    // 📨 Afficher champ email quand un destinataire est sélectionné
    const emailDiv = document.getElementById('email-destinataire');
    if (destinataireSelect && emailDiv) {
        destinataireSelect.addEventListener('change', function () {
            emailDiv.style.display = this.value ? 'block' : 'none';
        });
    }
});

// Place ces fonctions EN DEHORS du DOMContentLoaded !
function openAffectationModal(id, ref) {
    document.getElementById('courrier_id').value = id;
    document.getElementById('courrier_reference').textContent = ref;
    document.getElementById('affectModal').classList.remove('hidden');
}

function closeAffectationModal() {
    document.getElementById('affectModal').classList.add('hidden');
    document.getElementById('affectForm').reset();
}

function hideGroups() {
    ['agents_group', 'services_group', 'email_group'].forEach(id => {
        document.getElementById(id).classList.add('hidden');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('destinataire_type').addEventListener('change', function () {
        hideGroups();
        const val = this.value;
        if (val === 'agent') document.getElementById('agents_group').classList.remove('hidden');
        else if (val === 'service') document.getElementById('services_group').classList.remove('hidden');
        else if (val === 'email') document.getElementById('email_group').classList.remove('hidden');
    });
});
