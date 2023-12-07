<div class="container">
    <div class="card">
        <div class="card-header">

                <h2 class="card-title">Liste des </h2>
                <div class="card-toolbar">

                    <a href="/Pizza/edit/new" class="btn btn-primary">Nouvelle pizza</a>
                </div>
        </div>
        <div class="card-body">
            <table id="allPizzaTable" class="table table-hover ">
                <thead>
                    <tr class="text-start text-gray400 fw-blod fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Active</th>
                        <th></th>
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
        var dataTable = $('#allPizzaTable').DataTable({
            "language": {
                "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
            },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "/Pizza/SearchPizza",
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
                    "data": "active",
                    "render": function(data) {
                        return (data === "1" ? 'Oui' : 'Non');
                    }
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<a href="/Pizza/edit/${row.id}"><i class="fa-solid fa-eye me-4"></i>Afficher</a>`;
                    }
                },
                {
                    "data": 'id',
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<a href="/Pizza/edit/${row.id}"><i class="fa-solid fa-pencil me-4"></i>Éditer</a>`;
                    }
                },

            ],


            "order": [
                [0, "asc"]

            ]

        });

    });
</script>