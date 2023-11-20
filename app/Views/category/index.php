<div class="container">
    <div class="card">
        <div class="card-header">

                <h2 class="card-title">Liste des Catégorie</h2>
                <div class="card-toolbar">

                    <a href="/Category/edit/new" class="btn btn-primary">Nouvelle catégorie</a>
                </div>
        </div>
        <div class="card-body">
            <table id="allCategoryTable" class="table table-hover ">
                <thead>
                    <tr class="text-start text-gray400 fw-blod fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>Catégorie</th>
                        <th>icon</th>
                        <th>Etape</th>
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
        var dataTable = $('#allCategoryTable').DataTable({
            "language": {
                "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
            },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "/Category/SearchCategory",
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
                    "data": "icon"
                },
                {
                    "data": "id_step"
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<a href="/Category/edit/${row.id}"><i class="fa-solid fa-pencil me-4"></i>Éditer</a>`;
                    }
                },

            ],


            "order": [
                [0, "asc"]

            ]

        });

    });
</script>