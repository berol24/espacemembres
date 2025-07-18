<?php require 'index.php'; ?>
<?php
// devis_liste.php : Affichage des devis
include 'include/header.php';


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
  
    <link rel="stylesheet" href="/css/devis_liste.css">
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
            <td style="padding: 10px; text-align: center;">
                <a href="generate_pdf.php?id=<?= $d['id'] ?>" class="btn-download" target="_blank" download style="margin-right: 15px; display: inline-block;">PDF</a>
                <?php
                $pdfUrl = urlencode("https://" . $_SERVER['HTTP_HOST'] . "/generate_pdf.php?id=" . $d['id']);
                $whatsappMessage = urlencode("Bonjour, voici votre devis généré par NielsenIQ : ");
                $whatsappLink = "https://api.whatsapp.com/send?phone=" . $d['telephone'] . "&text=" . $whatsappMessage . $pdfUrl;
                ?>
                <a href="<?= $whatsappLink ?>" target="_blank" style="margin: 0 15px; display: inline-block;">
                    <img src="./images/whatsapp.png" alt="whatsapp_icon" style="width: 30px; height: 30px; vertical-align: middle; border-radius: 50%;">
                </a>
                <a href="?suppr=<?= $d['id'] ?>" onclick="return confirm('Supprimer ce devis ?');" style="margin-left: 15px; display: inline-block;">
                    <img src="./images/delete.png" alt="delete_icon" style="width: 30px; height: 30px; vertical-align: middle; border-radius: 50%;">
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
