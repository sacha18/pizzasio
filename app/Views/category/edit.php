<form action="<?= site_url('/Category/save') ?>" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($cat) ? "Nouvelle catégorie" : "Édition de " . $cat['name'] ?>
                </h2>
                <?php if (isset($cat)) { ?>
                    <div class="card-toolbar">
                        <a href="<?= site_url('/Category/delete?id=' . $cat['id']) ?>"
                           class="btn btn-sm btn-danger swal2-confirm" data-bs-toggle="tooltip"
                           data-bs-title="Supprimer la catégorie"
                           text-swal2="Voulez-vous vraiment supprimer la catégorie <?= $cat['name']; ?>">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <?php if (isset($cat)) { ?>
                    <input type="hidden" name="id" value="<?= $cat['id'] ?>"/>
                <?php } ?>
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Catégorie</label>
                    <div class="col-sm-10">
                        <input id="name" required type="text" class="form-control" name="name"
                               value="<?= isset($cat) ? $cat['name'] : ''; ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="step" class="col-sm-2 col-form-label">Étape</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="step">
                            <?php foreach ($steps as $step) { ?>
                                <option value="<?= $step['id']; ?>" <?= (isset($cat) && $cat['step'] == $step['id']) ? 'selected' : ''; ?>>
                                    <?= $step['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" name="type" value="<?= isset($cat) ? 'update' : 'insert' ?>"
                        class="btn btn-primary">Valider
                </button>
            </div>
        </div>
    </div>
</form>
