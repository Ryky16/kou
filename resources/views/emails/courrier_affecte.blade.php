<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
    <title>Courrier Affecté - Réf : {{ $courrier->reference }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container"> 
    <h1>📩 Nouveau Courrier Affecté</h1>
        <p>Bonjour,</p>
        <p>Un nouveau courrier vous a été affecté par le Secrétaire Municipal de la Mairie de Ziguinchor. Voici les détails :</p>
        <ul>
            <li><strong>Référence :</strong> {{ $courrier->reference }}</li>
            <li><strong>Objet :</strong> {{ $courrier->objet }}</li>
            <li><strong>Contenu :</strong> {{ $courrier->contenu }}</li>
            <li><strong>Date de réception :</strong> {{ \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') }}</li>
        </ul>
        <p>📎 Merci de vérifier les pièces jointes pour plus de détails.</p>
        <p>Cordialement,</p>
        <p><strong>Secrétaire Municipal</strong><br>Mairie de Ziguinchor</p>
    </div>
    
    <!--h1>📩 Nouveau Courrier Affecté</h1>
    <p>Bonjour,</p>
    <p>Un nouveau courrier vous a été affecté par le Secrétaire Municipal de la Mairie de Ziguinchor. Voici les détails :</p>
    <ul>
        <li><strong>Référence :</strong> {{ $courrier->reference }}</li>
        <li><strong>Objet :</strong> {{ $courrier->objet }}</li>
        <li><strong>Contenu :</strong> {{ $courrier->contenu }}</li>
        <li><strong>Date de réception :</strong> {{ $courrier->date_reception }}</li>
    </ul>
    <p>Merci de vérifier les pièces jointes pour plus de détails.</p>
    <p>Cordialement,</p>
    <p><strong>Secrétaire Municipal</strong><br>Mairie de Ziguinchor</p-->
</body>
</html>