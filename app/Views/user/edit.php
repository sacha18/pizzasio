<form action="/Users/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($u) ? "Nouvel utilisateur" : "Edition de " . $u['username'] ?>
                </h2>
                <?php
                if (isset($u) && $u['id'] != 1) {
                ?>
                    <div class="card-toolbar">

                        <a href="/Users/delete?id=<?= $u['id'] ?>" class="btn btn-sm btn-danger swal2-confirm" 
                        data-bs-toggle="tooltip"
                        data-bs-title="Supprimer l'utilisateur"
                        text-swal2="Voulez-vous vraiment supprimé le compte <?php $u['username']; ?>"
                        >
                            <i class="fa-solid fa-user-slash">
                              
                            </i>
                        </a>


                    </div>

            </div>
        <?php
                }
        ?>
        <div class="card-body">
            <?php
            if (isset($u)) {
            ?>
                <input type="hidden" name="id" value="<?= $u['id'] ?>" />
            <?php
            }
            ?>
            <div class="mb-3 row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input for="username" required id="username" type="text" class="form-control<?= isset($u) ? "-plaintext" : ''; ?>" name="username" value="<?= isset($u) ? $u['username'] : ''; ?>" <?= isset($u) ? 'readonly' : ''; ?>>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input for="email" required id="email" type="text" class="form-control<?= isset($u) ? "-plaintext" : ''; ?>" name="email" value="<?= isset($u) ? $u['email'] : ''; ?>" <?= isset($u) ? 'readonly' : ''; ?>>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Mot de passe</label>
                <div class="col-sm-10">
                    <input for="password" id="password" type="password" class="form-control" <?= isset($u) ? '' : 'required' ?> name="password">
                </div>
            </div>
            <div class="row mb-3">
                <label for="admin" class="col-sm-2 col-form-label">Admin ?</label>
                <div class="form-check form-switch form-check-custom form-check-solid col-sm-10">
                    <input class="form-check-input" type="checkbox" value="" id="admin" name="admin" <?= (isset($u) && $u['admin'] == true)  ? 'checked' : '' ?> />
                </div>
                <div class="row mb-3">
                    <label for="active" class="col-sm-2 col-form-label">Actif ?</label>
                    <div class="form-check form-switch form-check-custom form-check-solid col-sm-10">
                        <input class="form-check-input" type="checkbox" value="" id="active" name="active" <?= (isset($u) && $u['admin'] == true)  ? 'checked' : '' ?> />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" name="type" value="<?= isset($u)  ? 'update' : 'insert' ?>" class="btn btn-primary">Valider</button>
            </div>

        </div>
        </div>
</form>