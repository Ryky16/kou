<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Inclure automatiquement le token CSRF dans toutes les requêtes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $(".affecter-btn").click(function() {
            let courrierId = $(this).data("id");
            let button = $(this); // Stocker le bouton cliqué

            if (confirm("Voulez-vous vraiment affecter ce courrier ?")) {
                // Désactiver temporairement le bouton pour éviter le double clic
                button.prop("disabled", true);

                $.ajax({
                    url: "{{ route('courrier.affecter') }}",
                    type: "POST",
                    data: {
                        courrier_id: courrierId
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload(); // Actualiser pour voir le changement
                        }
                    },
                    error: function(xhr) {
                        alert("Une erreur est survenue lors de l'affectation.");
                        console.error(xhr.responseText);
                        // Réactiver le bouton en cas d'échec
                        button.prop("disabled", false);
                    }
                });
            }
        });
    });
</script>
