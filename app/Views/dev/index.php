<a href="#" class="btn btn-primary" id="btn-add">Ajouter</a>
<form action="/dev/result" method="post">
    <select class="form-select " name="" id="categ">
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
    <input type="text" name="" id="">
    <div id="emplacement">
    </div>
    <button class="btn btn-danger" type="submit">Valider</button>
</form>

<input type="text" name="" id="">
<script>
    $(document).ready(function() {
        $("#btn-add").on('click', function() {
            const id_categ = $("#categ").val()
            $.ajax({
                url: '/Dev/AjaxIngredients',
                type: 'GET',
                data: {
                    idCateg: id_categ
                },
                success: function(data) {
                    let select = `<select class="form-select" name="ingredients[]">`

                    data.forEach(ing => {
                        var option = "<option value='" + ing.id + "'>" + ing.name + "</option>"
                        select += option
                    })
                    select += "</select>"
                    $("#emplacement").append(select)

                },
                error: function(hxr, status, error) {
                    console.log(error);
                }
            })

        })
    })
</script>