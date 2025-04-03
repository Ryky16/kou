<x-app-layout>
    <div class="container">
        <h2 class="mb-4">📌 Affecter un Courrier</h2>

        {{-- Formulaire pour affecter un courrier --}}
        <div class="card">
            <div class="card-header bg-primary">
                ✉️ Nouveau Courrier à Affecter
            </div>
            <div class="card-body">
                <form action="{{ route('courriers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="reference_expediteur" class="fw-bold">Référence du courrier</label>
                            <input type="text" name="reference_expediteur" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="expediteur" class="fw-bold">Expéditeur</label>
                            <select name="expediteur_id" class="form-control" required>
                                <option value="">Sélectionner un expéditeur</option>
                                @foreach ($expediteurs as $expediteur)
                                    <option value="{{ $expediteur->id }}">{{ $expediteur->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="destinataire" class="fw-bold">Destinataire</label>
                            <select name="destinataire_id" class="form-control" required>
                                <option value="">Sélectionner un destinataire</option>
                                @foreach ($destinataires as $destinataire)
                                    <option value="{{ $destinataire->id }}">{{ $destinataire->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="objet" class="fw-bold">Objet du courrier</label>
                            <input type="text" name="objet" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="fw-bold">Type de courrier</label>
                            <select name="type" class="form-control">
                                <option value="entrant">Entrant</option>
                                <option value="sortant">Sortant</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="description" class="fw-bold">Contenu</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="pieces_jointes" class="fw-bold">📂 Ajouter des pièces jointes</label>
                            <input type="file" name="pieces_jointes[]" class="form-control" multiple>
                            <small class="text-muted">Formats acceptés : PDF, Word, Excel, Images</small>
                        </div>
                        <div class="col-md-6">
                            <label for="priorite" class="fw-bold">Priorité</label>
                            <select name="priorite" class="form-control">
                                <option value="basse">Basse</option>
                                <option value="normale" selected>Normale</option>
                                <option value="élevée">Élevée</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-4 w-100">📩 Envoyer le courrier</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
