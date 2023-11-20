</div>
    </main>
      <!--begin::Page loading(append to body)-->
      <div class="page-loader flex-column bg-dark bg-opacity-25">
          <span class="spinner-border text-primary" role="status"></span>
          <span class="text-muted fs-6 fw-semibold mt-5">Traitement en cours...</span>
      </div>
      <!--end::Page loading-->
<?php if (isset($messages)) { ?>
    <script type="text/javascript">
        jQuery(function(){
            var messages = <?= json_encode($messages) ?>;
            messages.forEach(function(elem){
                toastr[elem.toast](elem.txt);
            });
        });
        $(document).ready(function() {
            // Événement de clic sur le lien
            $('.swal2-confirm').on('click', function(event) {
                event.preventDefault(); // Empêche le comportement de redirection par défaut
                // Affiche la boîte de dialogue SweetAlert2 pour la confirmation
                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: $(this).attr("text-swal2"),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Rediriger vers l'URL du lien si l'utilisateur clique sur "oui"
                        KTApp.showPageLoading();
                        window.location.href = $(this).attr('href');
                    }
                });
            });
        });
    </script>
<?php } ?>
  </body>
</html>