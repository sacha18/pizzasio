<div class="container">
    <div class="row mb-3">
        <h1>Connexion</h1>
    </div>
    <div class="row mb-3">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?= FORM_URL ?>connexion">
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
                    <div class="row">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="submit">Se connecter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>