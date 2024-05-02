<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Liste des Commandes</h2>
        </div>
        <div class="card-body">
            <table id="allCommandeTable" class="table table-hover ">
                <thead>
                <tr class="text-start text-gray400 fw-blod fs-7 text-uppercase gs-0">
                    <th>ID_commande</th>
                    <th>Date commande</th>
                    <th>ID_client</th>
                    <th>total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalCommande">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Détails de la commande</h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <p>Long modal body text goes here.</p>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="closeBtn">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.view', function(e) {
        // Récupérer les valeurs des attributs data-idClient et data-idCommande
        var idClient = $(this).attr('data-idClient');
        var idCommande = $(this).attr('data-idCommande');

        // Vérifier si les valeurs sont définies
        if (idClient && idCommande) {
            // Effectuer la requête Ajax
            $.ajax({
                url: "<?= site_url('/Commande/AjaxCommandeContent') ?>",
                type: "GET",
                data: {
                    idClient: idClient,
                    idCommande: idCommande
                },
                success: function(data) {
                    console.log(data);
                    var modal = new bootstrap.Modal(document.getElementById('modalCommande'))
                    modal.toggle()
                    var content = `<h4>Commande n°${data.commande.id_commande}</h4>`
                    $('#closeBtn').before(`<h4>Total : ${data.commande.total_commande}€</h4>`)
                    data.ligne_commande.forEach(pizza => {
                        content +=
                            `<div class="card">
                                <img src="${pizza.image}" class="card-img-top" alt="PIZZA">
                                <div class="card-body">
                                  <h5 class="card-title">${pizza.name}</h5>
                                  <p class="card-text">Prix : <strong>${pizza.price_commande}€</strong></p>
                                </div>
                            </div>`
                    })

                    $('.modal-body').html(content);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })
        } else {
            console.log("Les valeurs de idClient ou idCommande sont undefined ou vides.");
        }
    });


    $(document).ready(function() {
        $('#modalCommande').on('hidden.bs.modal', function (e) {
            $('#closeBtn').prev().remove(); // Supprime l'élément avant le bouton Close
        });
        var dataTable = $('#allCommandeTable').DataTable({
            "language": {
                "url": '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
            },
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 50,
            "ajax": {
                "url": "<?= site_url('/Commande/SearchCommande') ?>",
                "type": "POST"
            },
            "columns": [
                { "data": "id_commande" },
                { "data": "date_commande" },
                { "data": "id_client" },
                { "data": "total_commande" },
                { "data": "id_commande",
                    "sortable": false,
                    "render": function(data, type, row) {
                        return `<i class="fa-solid fa-eye me-4 view" data-idClient="${row.id_client}" data-idCommande="${row.id_commande}"></i>`;
                    }},
            ],
            "order": [
                [0, "asc"]
            ]
        });
    });
</script>
