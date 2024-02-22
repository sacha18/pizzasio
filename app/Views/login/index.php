<!DOCTYPE html>
<html lang="fr-FR" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Connexion : Pizza SIO</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= site_url('/assets/media/favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= site_url('/assets/media/favicons/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= site_url('/assets/media/favicons/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= site_url('/assets/media/favicons/site.webmanifest') ?>">
    <link rel="mask-icon" href="<?= site_url('/assets/media/favicons/safari-pinned-tab.svg') ?>" color="#30788d">
    <link rel="shortcut icon" href="<?= site_url('/assets/media/favicons/favicon.ico') ?>">
    <link rel="icon" type="image/svg+xml" href="<?= site_url('/assets/media/favicons/favicon.svg') ?>">
    <link rel="icon" type="image/png" href="<?= site_url('/assets/media/favicons/favicon.png') ?>">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="msapplication-config" content="<?= site_url('/assets/media/favicons/browserconfig.xml') ?>">
    <meta name="theme-color" content="#ffffff">


    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?= site_url('/assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= site_url('/assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>

    <!--begin::Javascript-->
    <script>
        var hostUrl = "<?= site_url('/assets/') ?>";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="<?= site_url('/assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= site_url('/assets/js/scripts.bundle.js') ?>"></script>
    <!--end::Global Javascript Bundle-->
    <script src="<?= site_url('/assets/js/pim.js') ?>"></script>
    <!--end::Javascript-->

</head>

<body id="kt_body" class="app-blank app-blank">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center" style="background-color: #225332" ;>
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center p-6 p-lg-10 w-100">
                    <!--begin::Image-->
                    <img class="d-lg-block mx-auto w-100px w-lg-100 w-xl-100" src="<?= site_url('/assets/media/logos/PizzaSioFullLogoWhite.svg') ?>" alt="" />
                    <!--end::Image-->
                </div>
                <!--end::Content-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10">
                        <!--begin::Form-->
                        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                            <!--begin::Wrapper-->
                            <div class="w-lg-500px p-10">
                                <!--begin::Form-->
                                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST">
                                    <!--begin::Heading-->
                                    <div class="text-center mb-11">
                                        <!--begin::Title-->
                                        <h1 class="text-dark fw-bolder mb-3">Se connecter</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--begin::Heading-->

                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-5">
                                        <!--begin::Email-->
                                        <input type="text" placeholder="Identifiant" name="email" autocomplete="off" class="form-control" required />
                                        <!--end::Email-->
                                    </div>
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-5">
                                        <!--begin::Password-->
                                        <input type="password" placeholder="Mot de passe" name="password" autocomplete="off" class="form-control" required />
                                        <!--end::Password-->
                                    </div>
                                    <!--end::Input group=-->

                                    <!--begin::Submit button-->
                                    <div class="d-grid mb-10">
                                        <button type="submit" id="kt_sign_in_submit" name="action" value="connect" class="btn btn-primary">
                                            <!--begin::Indicator label-->
                                            <span class="indicator-label">Connexion</span>
                                            <!--end::Indicator label-->
                                            <!--begin::Indicator progress-->
                                            <span class="indicator-progress">Veuillez patient
