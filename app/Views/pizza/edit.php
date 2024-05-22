<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <?= !isset($pizza) ? "Nouvelle Pizza" : "Edition de " . $pizza['name'] ?>
            </h2>
        </div>
        <div class="card-body">
            <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row"
                 id="kt_stepper_example_vertical">
                <div class="d-flex flex-row-auto w-100 w-lg-300px">
                    <?php $counter = 1; ?>
                    <div class="stepper-nav flex-center">
                        <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
                            <div class="stepper-wrapper d-flex align-items-center">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number"><?= $counter++; ?></span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Nom</h3>
                                </div>
                            </div>
                            <div class="stepper-line h-40px"></div>
                        </div>
                        <!-- Ajoutez dynamiquement les étapes ici -->
                        <?php foreach ($steps as $s): ?>
                            <!--begin::Step-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number"><?= $counter++; ?></span>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            <?= $s['name']; ?>
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step-->
                        <?php endforeach; ?>
                        <div class="stepper-item me-5" data-kt-stepper-element="nav">
                            <div class="stepper-wrapper d-flex align-items-center">
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number"><?= $counter++; ?></span>
                                </div>
                                <div class="stepper-label">
                                    <h3 class="stepper-title">Image</h3>
                                </div>
                            </div>
                            <div class="h-40px"></div>
                        </div>
                    </div>
                </div>
                <div class="flex-row-fluid">
                    <form class="form w-lg-500px mx-auto"
                          action="<?= site_url(
                              isset($pizza) ?
                                  '/pizza/editedresult' : '/pizza/result') ?>"
                          method="post"
                          novalidate="novalidate">
                        <?php
                        if (isset($pizza)) {
                            ?>
                            <input type="hidden" value="<?= $pizza['id'] ?>" name="id">
                        <?php } ?>
                        <div class="mb-5 flex-column current" data-kt-stepper-element="content">
                            <label class="form-label">Nom</label>
                            <div class="fv-row mb-10">
                                <input type="text" class="form-control form-control-solid" name="name"
                                       placeholder="Reine"
                                       value="<?= (isset($pizza) && $pizza['name']) ? $pizza['name'] : '' ?>"/>
                            </div>
                        </div>
                        <!-- Ajoutez dynamiquement les étapes ici -->
                        <div class="mb-5 flex-column" data-kt-stepper-element="content">
                            <label class="form-label">Pâte</label>
                            <select class="form-select form-select-solid selectIngredient"
                                    data-old-price="0"
                                    name="dough">
                                <?php foreach ($pate as $p) { ?>
                                    <option <?= (isset($pizza) && ($pizza['dough'] == $p['id'])) ? 'selected' : '' ?>
                                            value="<?= $p['id']; ?>"
                                            data-id="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>">
                                        <?= $p['name'] . ' ' . '(+ ' . $p['price'] . ' €)'; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-5 flex-column" data-kt-stepper-element="content">
                            <label class="form-label">Base</label>
                            <select class="form-select form-select-solid selectIngredient"
                                    name="base"
                                    data-old-price="0">
                                <?php foreach ($base as $b) { ?>
                                    <option <?= (isset($pizza) && ($pizza['base'] == $b['id'])) ? 'selected' : '' ?>
                                            value="<?= $b['id']; ?>" data-price="<?= $b['price'] ?>"
                                            data-id="<?= $b['id'] ?>"
                                            data-price="<?= $b['price'] ?>">
                                        <?= $b['name'] . ' ' . '(+ ' . $b['price'] . ' €)'; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-5 flex-column" data-kt-stepper-element="content">
                            <label class="form-label">Ingrédients</label>
                            <?php
                            if (isset($pizza)) {
                                ?>
                                <div>
                                    <?php
                                    foreach ($pizza_ing as $p_ing) {
                                        ?>
                                        <div class="btn btn-sm btn-outline me-4 mb-4 position-relative col-3 gap-1 gy-2"
                                             data-id="<?= $p_ing->id ?>" data-price="<?= $p_ing->price ?>">
                                            <?= $p_ing->name; ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger removeOldIngredient">
                                                X
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="d-flex flex-row py-5">
                                <select class="form-select me-4" id="categ">
                                    <?php foreach ($categories as $cat) {
                                        if ($cat['id'] == 10 || $cat['id'] == 13) {
                                            continue;
                                        }
                                        ?>
                                        <option value="<?= $cat['id']; ?>">
                                            <?= $cat['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <a href="#" class="btn btn-success " id="btn-add">Ajouter</a>
                            </div>
                            <div id="emplacement"></div>
                        </div>
                        <div class="mb-5 flex-column" data-kt-stepper-element="content">
                            <label class="form-label">Image de la pizza</label>
                            <input type="text" class="form-control form-control-solid" name="img_url"
                                   value="<?= (isset($pizza) && $pizza['img_url']) ? $pizza['img_url'] : '' ?>"/>
                        </div>
                        <div class="d-flex flex-stack justify-content-between align-items-baseline">
                            <button type="button" class="btn btn-secondary" data-kt-stepper-action="previous">
                                Retour
                            </button>
                            <p class="fs-6">Prix de la pizza : <span
                                        id="prixtotal"><?= !isset($old_price) ? 0 : $old_price ?></span>€</p>
                            <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                Continuer
                            </button>
                            <button type="submit" class="btn btn-primary" data-kt-stepper-action="submit">
                                <span class="indicator-label"><?= !isset($pizza) ? "Créer" : "Modifier"; ?></span>
                                <span class="indicator-progress">Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <div id="ing_supprimer"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var element = document.querySelector("#kt_stepper_example_vertical");
        if (element) {
            var stepper = new KTStepper(element);
            stepper.on("kt.stepper.next", function (stepper) {
                stepper.goNext();
            });
            stepper.on("kt.stepper.previous", function (stepper) {
                stepper.goPrevious();
            });
        }
        $(document).on('change', '.selectIngredient', function () {
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
        $(document).on('click', '.removeOldIngredient', function () {
            removeOldPizzaIngredients(this, 'ing_suppr[]')
        })
        $(document).on('click', '#removeIngredient', function () {
            var prix = parseFloat($(this).closest('.d-flex').find('select').find('option:selected').data('price'))
            var ancienPrix = parseFloat($("#prixtotal").html())
            $(this).closest('.d-flex').remove()
            $("#prixtotal").html((ancienPrix - prix).toFixed(2))
        })
        $("#btn-add").on('click', function (e) {
            e.preventDefault()
            const id_categ = $("#categ").val()
            $.ajax({
                url: '<?= site_url('/Pizza/AjaxIngredients') ?>',
                type: 'GET',
                data: {
                    idCateg: id_categ
                },
                success: function (data) {
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
                error: function (hxr, status, error) {
                    console.log(error)
                }
            })
        })
    })
</script>
