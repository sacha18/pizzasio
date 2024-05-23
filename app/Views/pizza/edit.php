<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <?= !isset($pizza) ? "Nouvelle Pizza" : "Edition de " . $pizza['name'] ?>
            </h2>
        </div>
        <div class="card-body">
            <!--begin::Stepper-->
            <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row"
                 id="kt_stepper_example_vertical">
                <!--begin::Aside-->
                <div class="d-flex flex-row-auto w-100 w-lg-300px">
                    <!--begin::Nav-->
                    <div class="stepper-nav flex-center">
                        <!--begin::Step-Name-->
                        <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Choix Nom
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Line-->
                            <div class="stepper-line h-40px"></div>
                            <!--end::Line-->
                        </div>
                        <!--end::Step-Name-->
                        <?php foreach ($steps as $s): ?>
                            <!--begin::Step-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number"><?= $s['order'] + 1; ?></span>
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
                            <!--begin::Wrapper-->
                            <div class="stepper-wrapper d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">5</span>
                                </div>
                                <!--end::Icon-->
                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Choix de l'url de l'image
                                    </h3>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                    </div>
                    <!--end::Nav-->
                </div>
                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Form-->
                    <form class="form w-lg-500px mx-auto" novalidate="novalidate"
                          action="<?= site_url(isset($pizza) ? "/Pizza/editedresult" : "/Pizza/result") ?>"
                          method="POST">
                        <input type="hidden" name="id" value="<?= isset($pizza['id']) ? $pizza['id'] : '' ?>">
                        <!--begin::Group-->
                        <div class="mb-5">
                            <!--begin::Step Name-->
                            <div class="flex-column current" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Nom de la pizza</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="name"
                                           placeholder="" value="<?= isset($pizza) ? $pizza['name'] : '' ?>"/>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Step Name-->
                            <!--begin::Step Pate-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Pâte de la pizza</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid selectIngredient" name="dough"
                                            data-old-price="0">
                                        <?php foreach ($pate as $pate) : ?>
                                            <option <?= (isset($pizza) && ($pizza['dough'] == $pate['id'])) ? 'selected' : '' ?>
                                                    value="<?= $pate['id']; ?>"
                                                    data-price="<?= $pate['price']; ?>"><?= $pate['name'] . " (+" . $pate['price'] . "€)" ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Step Pate-->
                            <!--begin::Step Base-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Base de la pizza</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid selectIngredient" name="base"
                                            data-old-price="0">
                                        <?php foreach ($base as $base) : ?>
                                            <option <?= (isset($pizza) && ($pizza['base'] == $base['id'])) ? 'selected' : '' ?>
                                                    value="<?= $base['id']; ?>"
                                                    data-price="<?= $base['price']; ?>"><?= $base['name'] . " (+" . $base['price'] . "€)" ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Step Base-->
                            <!--begin::Step Ingredient-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Ingredients de la pizza</label>
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
                                    <!--begin::Input-->
                                    <div class="d-flex flex-row">
                                        <select class="form-select mb-4 me-4" id="categ">
                                            <?php foreach ($categories as $cat) : ?>
                                                <?php if ($cat['id'] == 10 || $cat['id'] == 13) continue; ?>
                                                <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <a href="#" class="btn btn-success mb-4" id="btn-add">Ajouter</a>
                                    </div>
                                    <div id="emplacement"></div>
                                    <div id="ing_supprimer"></div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Step Ingredient-->
                            <!--begin::Step Image URL-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Url de l'image</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" name="img_url"
                                           placeholder="" value="<?= isset($pizza) ? $pizza['img_url'] : '' ?>"/>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Step Image URL-->
                        </div>
                        <!--end::Group-->
                        <!--begin::Actions-->
                        <div class="d-flex flex-stack justify-content-between align-items-baseline">
                            <!--begin::Wrapper-->
                            <button type="button" class="btn btn-light btn-active-light-primary"
                                    data-kt-stepper-action="previous">
                                Retour
                            </button>
                            <p class="fs-6">Prix de la pizza: <span id="prixtotal"><?= $old_price ?? 7 ?></span>€</p>
                            <button type="submit" class="btn btn-primary" data-kt-stepper-action="submit">
                                    <span class="indicator-label">
                                        Finir ma pizza
                                    </span>
                                <span class="indicator-progress">
                                        Patientez... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                Suivant
                            </button>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Stepper-->
        </div>
        <div class="card-footer"></div>
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
