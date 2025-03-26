<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".affecter-btn").click(function() {
            let courrierId = $(this).data("id");

            if(confirm("Voulez-vous vraiment affecter ce courrier ?")) {
                $.ajax({
                    url: "{{ route('courrier.affecter') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        courrier_id: courrierId
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload(); // Actualiser pour voir le changement
                        }
                    }
                });
            }
        });
    });
</script>
