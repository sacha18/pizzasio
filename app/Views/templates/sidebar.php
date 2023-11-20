<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
  <!--begin::Logo-->
  <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
    <!--begin::Logo image-->
    <a href="/">
        <img alt="Logo" src="/assets/media/logos/color-logo-no-bg.svg" class="h-30px app-sidebar-logo-default">
    </a>
    <!--end::Logo image-->
    <!--begin::Sidebar toggle-->
    <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-sm h-30px w-30px rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
      <i class="ki-duotone ki-double-left fs-2 rotate-180">
        <span class="path1"></span>
        <span class="path2"></span>
      </i>
    </div>
    <!--end::Sidebar toggle-->
  </div>
  <!--end::Logo-->
  <!--begin::sidebar menu-->
  <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
      <!--begin::Menu-->
      <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
        <?php
        foreach ($menus as $km => $menu) {
            if (isset($menu['admin']) && ! $user->isAdmin()) { continue; } 
            if (! isset($menu['subs'])) { ?>
            <div class="menu-item">
              <!--begin:Menu link-->
              <a class="menu-link <?= ($localmenu === $km ? 'active' : '') ?>" href="<?= $menu['url'] ?>">
                <span class="menu-bullet">
                  <?php
                    if (isset($menu['icon'])) {
                        echo $menu['icon'];
                    } else { ?><span class="bullet bullet-dot"></span><?php } ?>
                </span>
                <span class="menu-title"><?= $menu['title'] ?></span>
              </a>
              <!--end:Menu link-->
            </div>
          <?php } else { ?>
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion" aria-expanded="true" >
              <!--begin:Menu link-->
              <span class="menu-link <?= ($localmenu === $km ? 'active' : '') ?>">
                <span class="menu-icon">
                  <?php
                    if (isset($menu['icon'])) {
                        echo $menu['icon'];
                    } else { ?><i class="ki-duotone ki-category fs-2">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                    </i><?php } ?>
                </span>
                <span class="menu-title"><?= $menu['title'] ?></span>
                <span class="menu-arrow"></span>
              </span>
              <?php if (isset($menu['subs'])) { ?>
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion <?php if (array_key_exists($localmenu, $menu['subs'])) {
                    echo 'show';
                } ?>">
                  <!--begin:Menu item-->
                  <?php foreach ($menu['subs'] as $ksm => $smenu) { ?>
                    <div class="menu-item <?php if ($localmenu === $ksm) {
                        echo 'active';
                    } ?>">
                      <!--begin:Menu link-->
                      <a class="menu-link <?= ($localmenu === $ksm ? 'active' : '') ?>" href="<?= $smenu['url'] ?>">
                        <span class="menu-bullet">
                          <?php
                            if (isset($smenu['icon'])) {
                                echo $smenu['icon'];
                            } else { ?><span class="bullet bullet-dot"></span><?php } ?>
                        </span>
                        <span class="menu-title"><?= $smenu['title'] ?></span>
                      </a>
                      <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
        <?php }
          } ?>
        <!--end::Menu-->
      </div>
      <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <hr />
        <div class="text-center text-gray-600">Version : <?= $version = getenv('APP_VERSION') !== false ? getenv('APP_VERSION') : 'dev'; ?>
        <br><img class="mx-auto w-50px"
                 src="/assets/media/logos/dokimedia.png" alt=""/>
        </div>
    </div>
    <!--end::Footer-->
  </div>
  <!--end::Sidebar-->
</div>
<style>
    [data-kt-app-layout=dark-sidebar] .app-sidebar {
        <?php if ($version == "local-docker") {
            echo "background-color : #000000 !important;";
        } elseif (getenv('STORE_FILE') == "development"){
            echo "background-color : #830000 !important;";
        } elseif (getenv('STORE_FILE') == "staging"){
            echo "background-color : #2c0083 !important;";
        } ?>
    }
</style>