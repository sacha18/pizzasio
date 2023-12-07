<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <?= !isset($pizza) ? "Nouvelle Pizza" : "Edition de " . $pizza['name'] ?>
            </h2>
        </div>
        <div class="card-body">
            <!--begin::Stepper-->
            <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="kt_stepper_example_vertical">
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
                                        Nom
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
                        <?php

                        use SebastianBergmann\CodeCoverage\Driver\Selector;

                        foreach ($steps as $s) :
                        ?>
                            <!--begin::Step-->
                            <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
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
                        <?php
                        endforeach;
                        ?>

                    </div>
                    <!--end::Nav-->
                </div>

                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Form-->
                    <form class="form w-lg-500px mx-auto" action="/pizza/result" method="post" novalidate="novalidate">
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
                                    <input type="text" class="form-control form-control-solid" name="name" value="<?= isset($pizza) ? $pizza['name'] : '' ?>" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                            </div>
                            <!--begin::Step Name-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Nom de la pâte</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid" name="pate">
                                        <?php
                                        foreach ($pate as $p) {
                                        ?>
                                            <option <?= (isset($pizza) && ($pizza['dough'] == $p['id'])) ? 'selected' : '' ?> value="<?= $p['id']; ?>">
                                                <?= $p['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                            </div>
                            <!--end::Group-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label">Nom de la base</label>
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid" name="base">
                                        <?php
                                        foreach ($base as $b) {
                                        ?>
                                            <option <?= (isset($pizza) && ($pizza['base'] == $p['id'])) ? 'selected' : '' ?> value="<?= $b['id']; ?>">
                                                <?= $b['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                            </div>
                            <!--end::Group-->
                            <div class="flex-column" data-kt-stepper-element="content">
                                <!--begin::Input group-->
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <!--end::Label-->

                                    <!--begin::Input-->

                                    <label class="form-label">Ingrédients</label>
                                    <?php if (isset($pizza)) {

                                        echo '<p class="fs-6">Ingrédient de la pizza</p>';
                                        foreach ($pizza_ing as $p_ing) {
                                    ?>


                                            <div class="btn btn-sm btn-outline me-4  position-relative">
                                                <?php
                                                echo $p_ing->name;
                                                ?>
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    X
                                                </span>
                                            </div>

                                    <?php }
                                    } ?>
                                    <div class="d-flex flex-row py-5">
                                        <select class="form-select me-4" name="ingredients" id="categ">
                                            <?php
                                            foreach ($categories as $cat) {
                                                if ($cat['id'] == 10 || $cat['id'] == 13) {
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
                                    <div id="emplacement">
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                        Back
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                                <div>
                                    <p class="fs-6">Prix de la pizza : <span id="pizza-price"></span></p>
                                </div>
                                <!--begin::Wrapper-->
                                <div>
                                    <button type="submit" class="btn btn-primary" data-kt-stepper-action="submit">
                                        <span class="indicator-label">
                                            Submit
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>

                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        Continue
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Stepper-->
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Stepper element
        var element = document.querySelector("#kt_stepper_example_vertical");

        // Initialize Stepper
        var stepper = new KTStepper(element);

        // Handle next step
        stepper.on("kt.stepper.next", function(stepper) {
            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function(stepper) {
            stepper.goPrevious(); // go previous step
        });

        if ($("#pizza-price").text() == '') {
            $("#pizza-price").text(0 + '€')
        }

        $("#emplacement").on('change', 'select', function() {
            var ancienPrix = 0;
            $("#emplacement select").each(function() {
                ancienPrix += parseFloat($(this).find('option:selected').data('price'))
            });
            var total = ancienPrix.toFixed(2)
            $("#pizza-price").text(total + '€')
        });

        $("#emplacement").on('click', '#removeIngredient', function(e) {
            e.preventDefault();

            $(this).closest('.d-flex').remove();

            var prix = parseFloat($(this).closest('.d-flex').find('select').find('option:selected').data('price'))
            var ancienPrix = parseFloat($("#pizza-price").text().replace('€', ''))
            var total = ancienPrix - prix

            total = total.toFixed(2)
            $("#pizza-price").text(total + '€')
        });

        $("#btn-add").on('click', function(e) {
            e.preventDefault()
            const id_categ = $("#categ").val()
            $.ajax({
                url: '/Pizza/AjaxIngredients',
                type: 'GET',
                data: {
                    idCateg: id_categ
                },
                success: function(data) {
                    let select = `<div class="d-flex flex-row "><select class="form-select mb-4 me-4" name="ingredients[]">`

                    data.forEach(ing => {
                        var option = `<option data-price="${ing.price}" value="${ing.id}">${ing.name} (+${ing.price})</option>`
                        select += option
                    })
                    const removeIngredient = `<i class="fa-solid fa-x" id="removeIngredient" role="button" ></i>`
                    select += `</select><div class="flex-col"><i class="fa-solid fa-pencil me-4" role="button"></i>${removeIngredient}</div></div>`

                    $("#emplacement").append(select)
                    $("#emplacement select").last().change()

                },
                error: function(hxr, status, error) {
                    console.log(error);
                }
            })




        })
    })
</script>