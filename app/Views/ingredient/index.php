<div class="container">
    <div class="card">
        <div class="card-header">

                <h2 class="card-title">Liste des Ingredients</h2>
                <div class="card-toolbar">

                    <a href="/Ingredient/edit/new" class="btn btn-primary">Nouvel Ingredient</a>
                </div>
        </div>
        <div class="card-body">
            <table id="allIngredientTable" class="table table-hover ">
                <thead>
                    <tr class="text-start text-gray400 fw-blod fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>Ingrédient</th>
                        <th>Stock</th>
                        <th>Prix</th>
                        <th>Bio</th>
                        <th>Vegan</th>
                        <th>Catégorie</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var dataTable = $('#allIngredientTable').DataTable({
            "language": {
                "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
            },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "/Ingredient/SearchIngredient",
                "type": "POST"
            },
            "columns": [
                {
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "stock"
                },
                {
                    "data": "price"
                },

                {
                    "data": "bio",
                    "render": function(data) {
                        return (data === "1" ? 'Oui' : 'Non');
                    }
                },
                {
                    "data": "vegan",
                    "render": function(data) {
                        return (data === "1" ? 'Oui' : 'Non');
                    }
                },
                {
                    "data": "id_category"
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<a href="/Ingredient/edit/${row.id}"><i class="fa-solid fa-pencil me-4"></i>Éditer</a>`;
                    }
                },

            ],

            "columnDefs": [{
                    "searchable": false,
                    "targets": [3, 4, 5]
                } // Désactiver la recherche pour les colonnes non pertinentes
            ],
            "order": [
                [0, "asc"]

            ]

        });

    });
</script>