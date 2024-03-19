<?php
// Définition des informations sur chaque API dans un tableau $apis
$apis = [
  [
    "name" => "Login",
    "id_element" => "login",
    "endpoint" => "Login",
    "type" => "GET",
    "description" => "Afin de pouvoir se connecter à distance via le login il faut utiliser l'url suivante",
    "params" => ["email" => "string", "password" => "string"],
    "exemple_params" => "?email=admin@admin.fr&password=toto",
    "json_reussite" => '{"id_user":"1"}',
    "json_error" => '[{"error":"User not found."},{"error":"Password incorrect","auth_attempt":1}]'
  ],
  [
    "name" => "getAllPizza",
    "id_element" => "all-pizza",
    "endpoint" => "AllPizza",
    "type" => "GET",
    "description" => "Pour récupérer toute les informations relatives aux pizzas",
    "json_reussite" => '[{"id":"3","name":"Peperoni","active":"0","base":"25","dough":"19","price":"0"},{"id":"2","name":"AA","active":"0","base":"27","dough":"20","price":"0"}]',
    "json_error" => '{"error":"No pizza."}'
  ],
  [
    "name" => "getPizza",
    "id_element" => "pizza",
    "endpoint" => "Pizza",
    "type" => "GET",
    "description" => "Pour récuperer les informations d'une seule pizza",
    "params" => ["id" => "int"],
    "exemple_params" => "?id=2",
    "json_reussite" => '{"id":"2","name":"Calzone","active":"0","base":"27","dough":"20","price":"0"}',
    "json_error" => '{"error":"Pizza not found."}'
  ],
];

?>
<div class="row">
  <div class="col-4">
    <!-- Liste des API -->
    <div class="card sticky-top">
      <div class="card-header">
        <h2 class="card-title">Liste des API</h2>
      </div>
      <div class="card-body">
        <div id="list-api" class="list-group affix">
          <?php foreach ($apis as $api) : ?>
            <!-- Affichage des noms d'API comme liens -->
            <a class="list-group-item list-group-item-action" href="#list-item-<?= $api["id_element"]; ?>"><?= $api["name"]; ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-8">
    <!-- Informations sur l'utilisation -->
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Informations sur l'utilisation</h2>
      </div>
      <div class="card-body">
        <h4 id="list-item-utilisation">Utilisation</h4>
        <div class="mb-4">
          <p>Pour contacter l'api il faut utiliser : </p>
          <!-- Message d'utilisation de l'API -->
          <div class="alert alert-primary"><b><?= base_url(); ?>Api/{objet}</b></div>
        </div>
      </div>
    </div>
    <!-- Détails des API -->
    <?php foreach ($apis as $api) : ?>
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Liste des API</h2>
        </div>
        <div class="card-body">
          <div data-bs-spy="scroll" data-bs-target="#list-api" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
            <h4 id="list-item-<?= $api['id_element']; ?>"><?= $api['name']; ?> <span class="badge text-bg-danger"><?= $api['type']; ?></span></h4>
            <div class="mb-4">
              <p><?= $api['description']; ?></p>
              <p>Afin de pouvoir se connecter à distance via le login il faut utiliser l'url suivante :</p>
              <!-- Affichage de l'endpoint de l'API -->
              <div class="alert alert-primary"><b><?= base_url(); ?>Api/<?= $api['endpoint']; ?><?= (isset($api['params'])) ? '{params}' : null; ?> </b></div>
              <!-- Affichage des paramètres attendus de l'API, s'il y en a -->
              <?php if (isset($api['params'])) : ?>
                <p>Paramètres attendu : </p>
                <div class="alert alert-warning text-primary">
                  <?php foreach ($api['params'] as $key => $val) : ?>
                    <!-- Affichage des paramètres attendus -->
                    <b><?= $key; ?></b> : <?= $val; ?><br>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <p>Exemple : </p>
              <!-- Affichage d'un exemple d'utilisation de l'API -->
              <div class="alert alert-info"><?= base_url(); ?>Api/<b><?= $api['endpoint']; ?><?= (isset($api['exemple_params'])) ? $api['exemple_params'] : null; ?></b></div>
              <p>Résultat attendu : </p>
              <!-- Appel de la fonction pour afficher les résultats attendus -->
              <?php afficher_resultat($api['id_element'], $api['json_reussite'], $api['json_error']); ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php
  // Fonction pour afficher les résultats attendus
  function afficher_resultat($id_element, $json_reussite, $json_error)
  {
    // Encodage et décodage JSON pour rendre les données jolies
    $json_reussite = json_encode(json_decode($json_reussite), JSON_PRETTY_PRINT);
    $json_error = json_encode(json_decode($json_error), JSON_PRETTY_PRINT);
  ?>
    <nav>
      <div class="nav nav-pills nav-fill mb-1" id="nav-tab-result-<?= $id_element; ?>" role="tablist">
        <button class="nav-link active" id="nav-result-<?= $id_element; ?>-success-tab" data-bs-toggle="tab" data-bs-target="#nav-result-<?= $id_element; ?>-success" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Réussite</button>
        <button class="nav-link" id="nav-result-<?= $id_element; ?>-error-tab" data-bs-toggle="tab" data-bs-target="#nav-result-<?= $id_element; ?>-error" type="button" role="tab" aria-controls="nav-result-<?= $id_element; ?>-error" aria-selected="false">Erreur</button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <!-- Onglet pour les résultats de succès -->
      <div class="tab-pane fade show active text-bg-succes" id="nav-result-<?= $id_element; ?>-success" role="tabpanel" aria-labelledby="nav-result-<?= $id_element; ?>-success-tab" tabindex="0">
        <!-- Affichage des résultats de succès au format JSON -->
        <div class="alert alert-success">
          <pre><?= $json_reussite; ?></pre>
        </div>
      </div>
      <!-- Onglet pour les résultats d'erreur -->
      <div class="tab-pane fade text-bg-error" id="nav-result-<?= $id_element; ?>-error" role="tabpanel" aria-labelledby="nav-result-<?= $id_element; ?>-error-tab" tabindex="0">
        <!-- Affichage des résultats d'erreur au format JSON -->
        <div class="alert alert-danger">
          <pre><?= $json_error; ?></pre>
        </div>
      </div>
    </div>
  <?php } ?>