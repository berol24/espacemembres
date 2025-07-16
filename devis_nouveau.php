
<?php require 'index.php'; ?>
<?php

// devis_nouveau.php : Création d'un devis avec choix des fruits et prix automatique
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
$message = '';

// Liste des fruits et leurs prix unitaires (à adapter selon votre base réelle)
$fruits = [
    'Ananas' => 8,
    'Mangue' => 2.5,
    'Banane' => 6,
    'Papaye' => 7.5,
    'Pastèque' => 9,
    'Orange' => 6,
    'Pomme' => 7,
    'Citron' => 4,
    'Fraise' => 1.2,
    'Raisin' => 1.5,
    'Poire' => 8,
    'Kiwi' => 11,
    'Avocat' => 9,
    'Noix de coco' => 10,
    'Goyave' => 7.5,
    'Fruit du dragon' => 5,
    'Grenade' => 9.5,
    'Mandarine' => 5.5,
    'Pamplemousse' => 8.5,
    'Fruit de la passion' => 12
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO clients (nom, prenom, adresse, email, telephone) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([
        $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['email'], $_POST['telephone']
    ]);
    $client_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare('INSERT INTO devis (id_user, id_client, date_devis, total_ht, total_ttc, statut) VALUES (?, ?, NOW(), ?, ?, ?)');
    $stmt->execute([$user_id, $client_id, $_POST['total_ht'], $_POST['total_ttc'], 'en attente']);
    $devis_id = $pdo->lastInsertId();

    $designations = $_POST['designation'];
    $quantites = $_POST['quantite'];
    $pu = $_POST['pu'];
    $tvas = $_POST['tva'];

    for ($i = 0; $i < count($designations); $i++) {
        if (!empty($designations[$i]) && $quantites[$i] > 0) {
            $stmt = $pdo->prepare('INSERT INTO devis_details (id_devis, designation, quantite, prix_unitaire, tva) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([
                $devis_id,
                $designations[$i],
                (int)$quantites[$i],
                (float)$pu[$i],
                (float)$tvas[$i]
            ]);
        }
    }


    $message = "<div style='background-color: #dff0d8; color: #3c763d; padding: 15px; margin: 20px 0; border: 1px solid #d6e9c6; border-radius: 4px; text-align: center;'>
        Devis généré avec succès. 
    </div>";
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau Devis</title>
    <style>
        body { font-family: Arial; background: #f0f8ff; margin: 30px; }
        label, input, button, select { display: block; margin: 10px 0; }
        table { width: 100%; margin-top: 15px; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .totaux { font-weight: bold; margin-top: 20px; }
        .btn-liste { background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; margin: 10px 0; border-radius: 5px; }

    </style>
    <script>
        const prixFruits = {
    'Ananas' : 8,
    'Mangue' : 2.5,
    'Banane' : 6,
    'Papaye' : 7.5,
    'Pastèque' : 9,
    'Orange' : 6,
    'Pomme' : 7,
    'Citron' : 4,
    'Fraise' : 1.2,
    'Raisin' : 1.5,
    'Poire' : 8,
    'Kiwi' : 11,
    'Avocat' : 9,
    'Noix de coco' : 10,
    'Goyave' : 7.5,
    'Fruit du dragon' : 5,
    'Grenade' : 9.5,
    'Mandarine' : 5.5,
    'Pamplemousse' : 8.5,
    'Fruit de la passion' : 12
        };

        function mettreAJourPrix(select) {
            const fruit = select.value;
            const tr = select.closest('tr');
            const inputPU = tr.querySelector('input[name="pu[]"]');
            if (fruit in prixFruits) {
                inputPU.value = prixFruits[fruit];
                majTotaux();
            }
        }

        function ajouterLigne() {
            const tr = document.createElement('tr');
            let options = "";
            for (let fruit in prixFruits) {
                options += `<option value="${fruit}">${fruit}</option>`;
            }
            tr.innerHTML = `<td><select style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" name="designation[]" onchange="mettreAJourPrix(this)">${options}</select></td>
                <td><input style="width: 80px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" name="quantite[]" type="number" value="1" min="1" onchange="majTotaux()"></td>
                <td><input  style="width: 100px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; background-color: #f5f5f5;" name="pu[]" type="number" value="0" min="0" step="0.01" readonly></td>
                <td><input style="width: 80px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" name="tva[]" type="number" value="20" min="0" step="0.01" onchange="majTotaux()"></td>
                <td style="padding: 8px; font-weight: bold;" class="sous-total">0.00</td>
                <td><button style="background-color: #ff4444; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;" type="button" onclick="this.closest('tr').remove();majTotaux();">X</button></td>`;
            document.getElementById('lignes').appendChild(tr);
            mettreAJourPrix(tr.querySelector('select'));
        }

        function majTotaux() {
            let total_ht = 0, total_ttc = 0;
            document.querySelectorAll('#lignes tr').forEach(tr => {
                let q = tr.querySelector('input[name="quantite[]"]');
                let pu = tr.querySelector('input[name="pu[]"]');
                let tva = tr.querySelector('input[name="tva[]"]');
                let sous_total = tr.querySelector('.sous-total');
                if (q && pu && tva && sous_total) {
                    let ht = q.value * pu.value;
                    let ttc = ht * (1 + tva.value / 100);
                    sous_total.textContent = ttc.toFixed(2);
                    total_ht += Number(ht);
                    total_ttc += Number(ttc);
                }
            });
            document.getElementById('total_ht').value = total_ht.toFixed(2);
            document.getElementById('total_ttc').value = total_ttc.toFixed(2);
            document.getElementById('affichage_total_ht').textContent = total_ht.toFixed(2);
            document.getElementById('affichage_total_ttc').textContent = total_ttc.toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', () => {
            majTotaux();
            document.querySelectorAll('select[name="designation[]"]').forEach(sel => mettreAJourPrix(sel));
        });
    </script>
</head>
<body>
<h1 style="text-align: center;">Créer un Devis</h1>


<a href="devis_liste.php" class="btn-liste" style="display: inline-block; background-color: #007bff; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; margin: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: background-color 0.3s ease;">Voir la liste des devis</a>
<?= $message ?>

<form method="post">
    <fieldset>
        <legend>Client</legend>
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 15px;">
            <label style="width: 48%;">Nom: <input type="text" name="nom" required style="width: 90%; height: 30px; padding: 5px; margin-top: 5px;"></label>
            <label style="width: 48%;">Prénom: <input type="text" name="prenom" style="width: 90%; height: 30px; padding: 5px; margin-top: 5px;"></label>
            <label style="width: 48%;">Adresse: <input type="text" name="adresse" style="width: 90%; height: 30px; padding: 5px; margin-top: 5px;"></label>
            <label style="width: 48%;">Email: <input type="email" name="email" style="width: 90%; height: 30px; padding: 5px; margin-top: 5px;"></label>
            <label style="width: 48%;">Téléphone: <input type="text" name="telephone" style="width: 90%; height: 30px; padding: 5px; margin-top: 5px;"></label>
        </div>
    </fieldset>

    <fieldset style="padding: 20px; margin: 20px 0;">
        <legend style="font-size: 1.2em; font-weight: bold; color: #333;">Produits</legend>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f5f5f5;">
                    <th style="padding: 12px; text-align: left;">Désignation</th>
                    <th style="padding: 12px; text-align: left;">Quantité</th>
                    <th style="padding: 12px; text-align: left;">P.U</th>
                    <th style="padding: 12px; text-align: left;">TVA</th>
                    <th style="padding: 12px; text-align: left;">Total</th>
                    <th style="padding: 12px;"></th>
                </tr>
            </thead>
            <tbody id="lignes">
                <tr>
                    <td>
                        <select name="designation[]" onchange="mettreAJourPrix(this)" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <?php foreach ($fruits as $fruit => $prix): ?>
                                <option value="<?= $fruit ?>"><?= $fruit ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input name="quantite[]" type="number" value="1" min="1" onchange="majTotaux()" style="width: 80px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></td>
                    <td><input name="pu[]" type="number" value="<?= reset($fruits) ?>" min="0" step="0.01" readonly style="width: 100px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; background-color: #f5f5f5;"></td>
                    <td><input name="tva[]" type="number" value="20" min="0" step="0.01" onchange="majTotaux()" style="width: 80px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></td>
                    <td class="sous-total" style="padding: 8px; font-weight: bold;">0.00</td>
                    <td><button type="button" onclick="this.closest('tr').remove();majTotaux();" style="background-color: #ff4444; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">X</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" onclick="ajouterLigne()" style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-bottom: 20px;">Ajouter une ligne</button>
        <div class="totaux" style="background-color: #f8f9fa; padding: 20px; border-radius: 4px;">
            <p style="font-size: 1.1em; margin: 10px 0;">Total HT: <span id="affichage_total_ht" style="font-weight: bold;">0.00</span> €</p>
            <p style="font-size: 1.1em; margin: 10px 0;">Total TTC: <span id="affichage_total_ttc" style="font-weight: bold;">0.00</span> €</p>
        </div>
        <input type="hidden" id="total_ht" name="total_ht" value="0">
        <input type="hidden" id="total_ttc" name="total_ttc" value="0">
    </fieldset>
    <button type="submit" style="background-color: #4CAF50; color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; font-size: 16px; margin: 20px 20px ; transition: background-color 0.3s;">Générer le devis</button>
</form>
</body>
</html>
