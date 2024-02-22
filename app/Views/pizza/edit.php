<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <?= !isset($pizza) ? "Nouvelle Pizza" : "Edition de " . $pizza['name'] ?>
            </h2>
        </div>
        <div class="card-body">
            <?php if (isset($pizza)) { ?>
                <div class="flex-row-fluid">
                    <form class="form w-lg-500px mx-auto" action="<?= site_url('/pizza/editedresult') ?>" method="post" novalidate="novalidate">
                        <input type="hidden" value="<?= $pizza['id'] ?>" name="id">
                        <div class="mb-5">
                            <div class="flex-column">
                                <div class="fv-row mb-10">
                                    <label class="form-label">Nom de la pizza</label>
                                    <input type="text" class="form-control form-control-solid" name="name" value="<?= $pizza['name'] ?>" />
                                </div>
                                <div class="fv-row mb-10">
                                    <label for="active" class="col-sm-2 col-form-label">Active ?</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" id="active" name="active" <?= ($pizza['active'] == true)  ? 'checked' : '' ?> />
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-10">
                                    <p class="fs-6">Pâte de la pizza</p>
                                    <?php
                                    foreach ($pate as $p) {
                                    ?>
                                        <?php if (($pizza['dough'] == $p['id'])) {
                                        ?>
                                            <div class="btn btn-sm btn-outline me-4  position-relative" data-id="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>">
                                                <?= $p['name']; ?>
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger removeDough">
                                                    X
                                                </span>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="fv-row mb-10">
                                    <p class="fs-6">Base de la pizza</p>
                                    <?php
                                    foreach ($base as $b) {
                                    ?>
                                        <?php if (($pizza['base'] == $b['id'])) {
                                        ?>
                                            <div class="btn btn-sm btn-outline me-4  position-relative" data-id="<?= $b['id'] ?>" data-price="<?= $b['price'] ?>">
                                                <?= $b['name']; ?>
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger removeBase">
                                                    X
                                                </span>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="fv-row mb-10">
                                    <p class="fs-6">Ingrédient de la pizza</p>
                                    <?php
                                    foreach ($pizza_ing as $p_ing) {
                                    ?>
                                        <div class="btn btn-sm btn-outline me-4 mb-4 position-relative col-3 gap-1 gy-2" data-id="<?= $p_ing->id ?>" data-price="<?= $p_ing->price ?>">
                                            <?= $p_ing->name; ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger removeOldIngredient">
                                                X
                                            </span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class=" d-flex flex-row py-5">
                                        <select class="form-select me-4" id="categ">
                                            <?php
                                            foreach ($categories as $cat) {
                                            ?>
                                                <option value="<?= $cat['id']; ?>">
                                                    <?= $cat['name']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <a href="#" class="btn btn-success " id="btn-add">Ajouter</a>
                                    </div>
                                    <div id="emplacement"></div>
                                </div>
                            </div>
                            <div class="d-flex flex-stack">
                                <div>
                                    <p class="fs-6">Prix de la pizza : <span id="prixtotal"><?= !isset($old_price) ? 0 : $old_price ?></span>€</p>
                                </div>
                                <div>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                    <button type="submit" class="btn btn-primary" data-kt-stepper-action="next">
                                        Modifier
                                    </button>
                                </div>
                            </div>
                            <div id="ing_supprimer"></div>
                        </div>
                    </form>
                </div>
            <?php } else { ?>
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="kt_stepper_example_vertical">
                    <div class="d-flex flex-row-auto w-100 w-lg-300px">
                        <div class="stepper-nav flex-center">
                            <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">Nom</h3>
                                    </div>
                                </div>
                                <div class="stepper-line h-40px"></div>
                            </div>
                            <?php
                            foreach ($steps as $s) :
                            ?>
                                <div class="stepper-item me-5" data-kt-stepper-element="nav">
                                    <div class="stepper-wrapper d-flex align-items-center">
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check fas fa-check"></i>
                                            <span class="stepper-number"><?= $s['order'] + 1; ?></span>
                                        </div>
                                        <div class="stepper-label">
                                            <h3 class="stepper-title"><?= $s['name']; ?></h3>
                                        </div>
                                    </div>
                                    <div class="stepper-line h-40px"></div>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <div class="flex-row-fluid">
                        <form class="form w-lg-500px mx-auto" action="<?= site_url('/pizza/result') ?>" method="post" novalidate="novalidate">
                            <div class="mb-5">
                                <div class="fv-row mb-10">
                                    <input type="text" class="form-control form-control-solid" name="name" value="<?= isset($pizza) ? $pizza['name'] : '' ?>" />
                                </div>
                            </div>
                            <div class="mb-5">
                                <select class="form-select form-select-solid selectIngredient" data-old-price="0" name="pate">
                                    <?php
                                    foreach ($pate as $p) {
                                    ?>
                                        <option <?= (isset($pizza) && ($pizza['dough'] == $p['id'])) ? 'selected' : '' ?> value="<?= $p['id']; ?>" data-price="<?= $p['price'] ?>">
                                            <?= $p['name'] . ' ' . '(+ ' . $p['price'] . ' €)'; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-5">
                                <select class="form-select form-select-solid selectIngredient" name="base" data-old-price="0">
                                    <?php
                                    foreach ($base as $b) {
                                    ?>
                                        <option <?= (isset($pizza) && ($pizza['base'] == $p['id'])) ? 'selected' : '' ?> value="<?= $b['id']; ?>" data-price="<?= $b['price'] ?>">
                                            <?= $b['name'] . ' ' . '(+ ' . $b['price'] . ' €)'; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Ingrédients</label>
                                <div class="d-flex flex-row py-5">
                                    <select class="form-select me-4" id="categ">
                                        <?php
                                        foreach ($categories as $cat) {
                                            if ((!isset($pizza)) && $cat['id'] == 10 || $cat['id'] == 13) {
                                                continue;
                                            }
                                        ?>
                                            <option value="<?= $cat['id']; ?>">
                                                <?= $cat['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <a href="#" class="btn btn-success " id="btn-add">Ajouter</a>
                                </div>
                                <div id="emplacement"></div>
                            </div>
                            <div class="d-flex flex-stack">
                                <div>
                                    <p class="fs-6">Prix de la pizza : <span id="prixtotal"><?= 0 ?></span>€</p>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary" data-kt-stepper-action="submit">
                                        <span class="indicator-label">
                                            Créer
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        Continuer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var element = document.querySelector("#kt_stepper_example_vertical");
        if (element) {
            var stepper = new KTStepper(element);
            stepper.on("kt.stepper.next", function(stepper) {
                stepper.goNext();
            });
            stepper.on("kt.stepper.previous", function(stepper) {
                stepper.goPrevious();
            });
        }
        $(document).on('change', '.selectIngredient', function() {
            var prix = parseFloat($("#prixtotal").html())
            var selectedPrice = parseFloat($(this).find('option:selected').data('price'))
            var oldPrice = parseFloat($(this).data('old-price'))
            $("#prixtotal").html((prix + selectedPrice - oldPrice).toFixed(2))
            $(this).data('old-price', selectedPrice)
        })
        const removeOldPizzaIngredients = (element, typeToRemove) => {
            var prix = parseFloat($(element).closest('.btn').data('price'))
            var ancienPrix = parseFloat($("#prixtotal").html())
            var id_supprimer = $(element).closest('.btn').data('id')
            $('#ing_supprimer').append(`<input type='hidden' value='${id_supprimer}' name='${typeToRemove}'>`)
            $(element).closest('.btn').remove();
            $("#prixtotal").html((ancienPrix - prix).toFixed(2))
        }
        $(document).on('click', '.removeOldIngredient', function() {
            removeOldPizzaIngredients(this, 'ing_suppr[]')
        })
        $(document).on('click', '.removeDough', function() {
            removeOldPizzaIngredients(this, 'dough_suppr')
        })
        $(document).on('click', '.removeBase', function() {
            removeOldPizzaIngredients(this, 'base_suppr')
        })
        $(document).on('click', '#removeIngredient', function() {
            var prix = parseFloat($(this).closest('.d-flex').find('select').find('option:selected').data('price'))
            var ancienPrix = parseFloat($("#prixtotal").html())
            $(this).closest('.d-flex').remove()
            $("#prixtotal").html((ancienPrix - prix).toFixed(2))
        })
        $("#btn-add").on('click', function(e) {
            e.preventDefault()
            const id_categ = $("#categ").val()
            $.ajax({
                url: '<?= site_url('/Pizza/AjaxIngredients') ?>',
                type: 'GET',
                data: {
                    idCateg: id_categ
                },
                success: function(data) {
                    const pateOubase = data[0].id_category === '10' && 'dough' || data[0].id_category === '13' && 'base'
                    let select = `<div class="d-flex flex-row align-items-center mb-4 "><select class="form-select mb-4 me-4 flex-grow-1 selectIngredient" data-old-price="0" name="${pateOubase || 'ingredients[]'}">`
                    data.forEach(ing => {
                        var option = `<option data-price="${ing.price}" value="${ing.id}">${ing.name} (+ ${ing.price})</option>`
                        select += option
                    })
                    select += `</select><div></div><i class="fa-solid fa-x" id="removeIngredient" role="button" ></i></div></div>`
                    $("#emplacement").append(select)
                    $("#emplacement .selectIngredient").last().change()
                },
                error: function(hxr, status, error) {
                    console.log(error)
                }
            })
        })
    })
</script>
