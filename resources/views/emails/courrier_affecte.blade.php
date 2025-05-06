<!DOCTYPE html>
<html>
<head>
    <title>Nouveau Courrier Affecté</title>
</head>
<body>
    <h1>📩 Nouveau Courrier Affecté</h1>
    <p>Bonjour,</p>
    <p>Un nouveau courrier vous a été affecté. Voici les détails :</p>

    <ul>
        <li><strong>Référence :</strong> {{ $reference }}</li>
        <li><strong>Objet :</strong> {{ $objet }}</li>
        <li><strong>Contenu :</strong> {{ $contenu }}</li>
        <li><strong>Date de réception :</strong> {{ $date_reception }}</li>
    </ul>

    <p>Merci de vérifier votre boîte de réception pour plus de détails.</p>
    <p>Cordialement,</p>
    <p><strong>Secrétariat Municipal</strong></p>
</body>
</html>