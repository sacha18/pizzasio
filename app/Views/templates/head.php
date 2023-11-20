<!DOCTYPE html>
<html lang="fr-FR" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title><?= $title ?></title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
      <?php
      $favicons_folder = "favicons";
      $version = getenv('APP_VERSION') !== false ? getenv('APP_VERSION') : 'dev';
      if (getenv('STORE_FILE') == "development"){
          $favicons_folder .= "_dev";
      } elseif (getenv('STORE_FILE') == "staging"){
          $favicons_folder .= "_staging";
      }
      ?>
    <link rel="icon" type="image/svg+xml" href="/assets/media/favicons/<?= $favicons_folder; ?>/favicon.svg">
    <link rel="icon" type="image/png" href="/assets/media/favicons/<?= $favicons_folder; ?>/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/media/favicons/<?= $favicons_folder; ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/media/favicons/<?= $favicons_folder; ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/media/favicons/<?= $favicons_folder; ?>/favicon-16x16.png">
    <link rel="manifest" href="/assets/media/favicons/<?= $favicons_folder; ?>/site.webmanifest">
    <link rel="mask-icon" href="/assets/media/favicons/<?= $favicons_folder; ?>/safari-pinned-tab.svg" color="#00204a">
    <link rel="shortcut icon" href="/assets/media/favicons/<?= $favicons_folder; ?>/favicon.ico">
    <meta name="msapplication-TileColor" content="#00204a">
    <meta name="msapplication-config" content="/assets/media/favicons/<?= $favicons_folder; ?>/browserconfig.xml">
    <meta name="theme-color" content="#00204a">

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>

    <!--begin::Javascript-->
    <script>var hostUrl = "/assets/";</script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
      <script src="/assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/assets/js/widgets.bundle.js"></script>
    <script src="/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/assets/js/custom/utilities/modals/create-campaign.js"></script>
    <script src="/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->

    <script src="/assets/js/pim.js"></script>

    <!--end::Javascript-->

  </head>

  <body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

      <!--begin::Theme mode setup on page load-->
    <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
    <!--end::Theme mode setup on page load-->


    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
      <!--begin::Page-->
      <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <?php if ($show_menu) {
            echo view('templates/header', ['breadcrumb' => $breadcrumb]);
        } ?>
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
          <?php if ($show_menu) {
              echo view('templates/sidebar', ['menus' => $menus, 'localmenu' => $localmenu]);
          } ?>
          <!--begin::Main-->
          <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
              <!--begin::Content-->
              <div id="kt_app_content" class="app-content flex-column-fluid mt-3">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">