<div class="container">
    <div class="row mb-3">
        <h1>Inscription</h1>
    </div>
    <div class="row mb-3">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?= FORM_URL ?>inscription">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="mail">E-mail</label>
                            <input name="mail" type="mail" id="mail" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">

                            <label for="password">Mot de passe</label>
                            <input name="password" type="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="nom">Nom</label>
                            <input name="nom" type="text" id="nom" class="form-control" required>
                        </div>
                        <div class="col-4">
                            <label for="prenom">Prenom</label>
                            <input name="prenom" type="text" id="prenom" class="form-control" required>
                        </div>
                        <div class="col-4">
                            <label for="telephone">Téléphone</label>
                            <input name="telephone" type="text" id="telephone" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3 mb-3">
                        <div class="col">
                            <label for="adresse">Adresse</label>
                            <input name="adresse" type="text" id="adresse" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3 mb-3">
                        <div class="col-6">
                            <label for="cp">Code Postal</label>
                            <input name="cp" type="text" id="cp" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="ville">Ville</label>
                            <input name="ville" type="text" id="ville" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="submit">S'inscrire</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>