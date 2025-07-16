<?php
// Inclure le fichier autoload de Composer
require __DIR__.'/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;


// Vérifier que l'ID du devis est passé en paramètre
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=fruistore;charset=utf8mb4', 'root', '');
    
    // Récupérer les informations du devis
    $stmt = $pdo->prepare('SELECT d.id, d.date_devis, d.total_ht, d.total_ttc, c.nom, c.prenom, c.telephone
                           FROM devis d
                           JOIN clients c ON d.id_client = c.id
                           WHERE d.id = ?');
    $stmt->execute([$id]);
    $devis = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer les articles du devis
    $stmt_articles = $pdo->prepare('SELECT dd.designation, dd.quantite, dd.prix_unitaire, (dd.quantite * dd.prix_unitaire) as sous_total
                                   FROM devis d
                                   JOIN devis_details dd ON d.id = dd.id_devis
                                   WHERE d.id = ?');
    $stmt_articles->execute([$id]);
    $articles = $stmt_articles->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si les données ont été trouvées
    if ($devis) {
        // Instancier Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Créer le contenu HTML pour le PDF
        $html = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    width: 100%;
                    padding: 20px;
                }
                .header {
                    background-color: #007bff;
                    color: white;
                    padding: 10px;
                    text-align: center;
                }
                .details {
                    margin: 20px 0;
                    padding: 20px;
                    background-color: #fff;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                }
                .details h2 {
                    margin-top: 0;
                    font-size: 18px;
                }
                .details table {
                    width: 100%;
                    margin-top: 10px;
                    border-collapse: collapse;
                }
                .details th, .details td {
                    padding: 10px;
                    border: 1px solid #ddd;
                    text-align: left;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    font-size: 12px;
                    color: #555;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Devis N°" . $devis['id'] . "</h1>
                    <p>Généré le : " . date('d/m/Y') . "</p>
                </div>

                <div class='details'>
                    <h2>Détails du Client</h2>
                    <table>
                        <tr>
                            <th>Client</th>
                            <td>" . htmlspecialchars($devis['prenom'] . ' ' . $devis['nom']) . "</td>
                        </tr>
                        <tr>
                            <th>Téléphone</th>
                            <td>" . htmlspecialchars($devis['telephone']) . "</td>
                        </tr>
                        <tr>
                            <th>Date de Devis</th>
                            <td>" . htmlspecialchars($devis['date_devis']) . "</td>
                        </tr>
                    </table>

                    <h2>Articles</h2>
                    <table>
                        <tr>
                            <th>Article</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Sous-total</th>
                        </tr>";
                        
        foreach($articles as $article) {
            $html .= "<tr>
                        <td>" . htmlspecialchars($article['designation']) . "</td>
                        <td>" . htmlspecialchars($article['quantite']) . "</td>
                        <td>" . number_format($article['prix_unitaire'], 2, ',', ' ') . " €</td>
                        <td>" . number_format($article['sous_total'], 2, ',', ' ') . " €</td>
                    </tr>";
        }

        $html .= "</table>

                    <table style='margin-top: 20px;'>
                        <tr>
                            <th>Total HT</th>
                            <td>" . number_format($devis['total_ht'], 2, ',', ' ') . " €</td>
                        </tr>
                        <tr>
                            <th>Total TTC</th>
                            <td>" . number_format($devis['total_ttc'], 2, ',', ' ') . " €</td>
                        </tr>
                    </table>
                </div>

                <div class='footer'>
                    <p>Merci de votre confiance !</p>
                </div>
            </div>
        </body>
        </html>";

        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // (Optionnel) Définir la taille de la page et l'orientation
        $dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF
        $dompdf->render();

        // Sortir le PDF dans le navigateur
        $dompdf->stream($devis['nom']."_".$devis['prenom']."_".'devis_' . $devis['id'] . '.pdf', ['Attachment' => false]);
    } else {
        echo "Devis non trouvé.";
    }
} else {
    echo "Aucun ID de devis fourni.";
}
?>