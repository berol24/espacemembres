<?php require 'index.php'; ?>


<?php
// devis_liste.php : Affichage des devis
include 'include/header.php';

// session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

$user_id = $_SESSION['id'];
$pdo = new PDO('mysql:host=localhost;dbname=fruistore;charset=utf8mb4', 'root', '');

// Suppression d'un devis (et ses détails)
if (isset($_GET['suppr']) && is_numeric($_GET['suppr'])) {
    $stmt = $pdo->prepare('DELETE FROM devis_details WHERE id_devis = ?');
    $stmt->execute([$_GET['suppr']]);
    
    $stmt = $pdo->prepare('DELETE FROM devis WHERE id = ? AND id_user = ?');
    $stmt->execute([$_GET['suppr'], $user_id]);
    header('Location: devis_liste.php');
    exit;
}

// Liste des devis
$stmt = $pdo->prepare('SELECT d.id, d.date_devis, d.total_ht, d.total_ttc, c.nom, c.prenom, c.telephone
                       FROM devis d JOIN clients c ON d.id_client = c.id
                       WHERE d.id_user = ? ORDER BY d.date_devis DESC');
$stmt->execute([$user_id]);
$devis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Devis</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f0f8ff; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #d9edf7; }
        .btn-create{ background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; margin: 10px 0; border-radius: 5px; }
        .btn-download { background: #007bff; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; margin-right: 5px; }
        .btn-whatsapp { background: #25D366; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; margin-right: 5px; }
        .btn-delete { background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>
<h1>Mes Devis</h1>
<a href="devis_nouveau.php" class="btn-create">Créer un nouveau devis</a>
<table>
    <thead>
        <tr>
            <th>ID</th><th>Date</th><th>Client</th><th>Total HT</th><th>Total TTC</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($devis as $d): ?>
        <tr>
            <td><?= $d['id'] ?></td>
            <td><?= $d['date_devis'] ?></td>
            <td><?= htmlspecialchars($d['prenom'] . ' ' . $d['nom']) ?></td>
            <td><?= number_format($d['total_ht'], 2, ',', ' ') ?> €</td>
            <td><?= number_format($d['total_ttc'], 2, ',', ' ') ?> €</td>
            <td>
                <a href="generate_pdf.php?id=<?= $d['id'] ?>" class="btn-download" target="_blank" download>PDF</a>
                <?php
                $pdfUrl = urlencode("https://" . $_SERVER['HTTP_HOST'] . "/generate_pdf.php?id=" . $d['id']);
                $whatsappMessage = urlencode("Voici votre devis : ");
                $whatsappLink = "https://api.whatsapp.com/send?phone=" . $d['telephone'] . "&text=" . $whatsappMessage . $pdfUrl;
                ?>
                <a href="<?= $whatsappLink ?>" class="btn-whatsapp" target="_blank">WhatsApp</a>
                <a href="?suppr=<?= $d['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer ce devis ?');">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
