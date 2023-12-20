<form action="/Ingredient/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($ing) ? "Nouvel ingredient" : "Edition de " . $ing['name'] ?>
                </h2>
                <?php
                if (isset($ing)) {
                ?>
                    <div class="card-toolbar">

                        <a href="/Ingredient/delete?id=<?= $ing['id'] ?>" class="btn btn-sm btn-danger swal2-confirm" data-bs-toggle="tooltip" data-bs-title="Supprimer l'ingredient" text-swal2="Voulez-vous vraiment supprimé l'ingredient <?php $ing['name']; ?>">
                            <i class="fa-solid fa-trash">
                            </i>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="card-body">
                <?php
                if (isset($ing)) {
                ?>
                    <input type="hidden" name="id" value="<?= $ing['id'] ?>" />
                <?php
                }
                ?>
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Ingrédient</label>
                    <div class="col-sm-10">
                        <input for="name" id="name" type="text" class="form-control" name="name" value="<?= isset($ing) ? $ing['name'] : ''; ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                    <div class="col-sm-10">
                        <input for="stock" id="stock" type="text" class="form-control" name="stock" value="<?= isset($ing) ? $ing['stock'] : ''; ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="price" class="col-sm-2 col-form-label">Prix</label>
                    <div class="col-sm-10">
                        <input for="price" id="price" type="price" class="form-control" name="price" value="<?= isset($ing) ? $ing['price'] : ''; ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="category" class="col-sm-2 col-form-label">Categorie</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="id_category">
                            <?php
                            foreach ($categ as $c) {
                            ?>
                                <option value="<?= $c['id']; ?>">
                                    <?=
                                    (isset($ing) && $ing['id_category'] == $c['id'])  ?

                                        'selected' : '';
                                    ?>
                                    <?= $c['name']; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="bio" class="col-sm-2 col-form-label">Bio ?</label>
                    <div class="col-sm-10">

                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" id="bio" name="bio" <?= (isset($ing) && $ing['bio'] == true)  ? 'checked' : '' ?> />
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="vegan" class="col-sm-2 col-form-label">Vegan ?</label>
                    <div class="col-sm-10">

                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" id="vegan" name="vegan" <?= (isset($ing) && $ing['vegan'] == true)  ? 'checked' : '' ?> />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" name="type" value="<?= isset($ing)  ? 'update' : 'insert' ?>" class="btn btn-primary">Valider</button>
            </div>
        </div>
    </div>
</form>