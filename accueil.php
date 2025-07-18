  <?php include "index.php" ?>
  <!DOCTYPE html>
  <html lang="fr">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Génération de devis - Fruistore</title>
      <style>
          body {
              font-family: Arial, sans-serif;
              line-height: 1.6;
              background-color: #f9f9f9;
              margin: 0;
              padding: 40px;
          }
          .container {
              max-width: 800px;
              background: #fff;
              padding: 30px;
              margin: auto;
              border-radius: 8px;
              box-shadow: 0 0 8px rgba(0,0,0,0.1);
              text-align: center;
          }
          h1,h3 {
              color: #2D6DF6;
              margin-bottom: 30px;
          }
          .features {
              display: grid;
              grid-template-columns: repeat(2, 1fr);
              gap: 20px;
              margin: 30px 0;
          }
          .feature-card {
              background: #f5f5f5;
              padding: 20px;
              border-radius: 5px;
          }
          .cta-button {
              display: inline-block;
              background: #2D6DF6;
              color: white;
              padding: 15px 30px;
              text-decoration: none;
              border-radius: 5px;
              margin-top: 20px;
              transition: background 0.3s;
          }
          .cta-button:hover {
              background: #2D6DF6;
              opacity: 0.9;
          }
      </style>
  </head>
  <body>

  <div class="container">
      <h1>Génération de Devis pour la Vente de Fruits</h1>

      <p>Créez rapidement et simplement vos devis personnalisés pour la vente de fruits frais.</p>

      <div class="features">
          <div class="feature-card">
              <h3>Calcul Automatique</h3>
              <p>Prix HT et TTC calculés instantanément</p>
          </div>
          <div class="feature-card">
              <h3>Gestion Simplifiée</h3>
              <p>Historique et suivi des devis centralisés</p>
          </div>
          <div class="feature-card">
              <h3>Gain de Temps</h3>
              <p>Interface intuitive et rapide</p>
          </div>
          <div class="feature-card">
              <h3>Personnalisation</h3>
              <p>Adaptez vos devis selon vos besoins</p>
          </div>
      </div>

      <a href="devis_nouveau.php" class="cta-button">Créer un devis</a>
  </div>

  </body>
  </html>
