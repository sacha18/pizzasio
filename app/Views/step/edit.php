<form action="/Step/save" method="POST">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <?= !isset($step) ? "Nouvel étape" : "Edition de " . $step['name'] ?>
                </h2>
                <?php
                if (isset($step)) {
                ?>
                    <div class="card-toolbar">

                        <a href="/Step/delete?id=<?= $step['id'] ?>" class="btn btn-sm btn-danger swal2-confirm" 
                        data-bs-toggle="tooltip"
                        data-bs-title="Supprimer l'étape"
                        text-swal2="Voulez-vous vraiment supprimé l'étape <?php $step['name']; ?>"
                        >
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
            if (isset($step)) {
            ?>
                <input type="hidden" name="id" value="<?= $step['id'] ?>" />
            <?php
            }
            ?>
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">Étape</label>
                <div class="col-sm-10">
                    <input for="name" required id="name" type="text" class="form-control" name="name" value="<?= isset($step) ? $step['name'] : ''; ?>" >
                </div>
            </div>
            <div class="mb-3 row">
                <label for="order" class="col-sm-2 col-form-label">Ordre</label>
                <div class="col-sm-10">
                    <input for="order" required id="order" type="text" class="form-control" name="order" value="<?= isset($step) ? $step['order'] : ''; ?>" >
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" name="type" value="<?= isset($step)  ? 'update' : 'insert' ?>" class="btn btn-primary">Valider</button>
            </div>
            </div>
        </div>
        </div>
</form>