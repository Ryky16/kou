<!-- Écran de chargement -->
<div id="loading-overlay" style="
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: green;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    color: white;
">
    <img src="{{ asset('images/logo.png') }}" alt="Logo Mairie" style="width: 100px;">
    <p>Chargement en cours...</p>
    <div class="spinner"></div>
</div>

<style>
    .spinner {
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Afficher le chargement au chargement initial de la page
        document.getElementById("loading-overlay").style.display = "flex";
        
        setTimeout(() => {
            document.getElementById("loading-overlay").style.display = "none";
        }, 1500); // Disparaît après 1.5s

        // Ajouter l’effet de chargement aux liens de navigation
        const links = document.querySelectorAll("a");
        links.forEach(link => {
            link.addEventListener("click", function(event) {
                if (this.href.startsWith(window.location.origin) && !this.href.includes('#')) {
                    event.preventDefault();
                    document.getElementById("loading-overlay").style.display = "flex";
                    
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 1500); // Délai avant navigation
                }
            });
        });
    });
</script>
