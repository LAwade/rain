<!DOCTYPE html>
<html lang="en">

<head>
    <?php include __DIR__ . '/header.php'; ?>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= CONF_URL_BASE ?>"><?= CONF_NAME_SYSTEM ?></a>

        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <div class="input-group">
            <div class="input-group-append"></div>
        </div>

        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="<?= CONF_URL_BASE ?>store/cart" id="alertsDropdown" aria-expanded="false">
                    <i class="fas fa-shopping-cart"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter" id="badge_count_shop"><?= count((array) session()->data(CONF_SESSION_CART)) ?></span>
                </a>
                
            </li>
        </ul>

        &nbsp;
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?= CONF_URL_BASE . 'home/changepassword' ?>">Change Password</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= CONF_URL_BASE . 'index/logoff' ?>">Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">MENUS</div>
                        <a class="nav-link" href="<?= CONF_URL_BASE . 'home/index' ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <?php
                        $session_menu = (array) session()->data(CONF_SESSION_MENU);

                        if ($session_menu) {
                            $menu = "";
                            $heading = "";
                            $menus = "";
                            foreach ($session_menu as $value) {
                                $x++;
                                if ($value->name != $menu) {
                                    $name_menu = str_replace(" ", "", $value->name);
                                    $menus .= ($x > 1 ? "</nav></div>" : '');

                                    $menus .= "<a class=\"nav-link collapsed\" href=\"#\" data-toggle=\"collapse\" data-target=\"#collapse{$name_menu}\" aria-expanded=\"false\" aria-controls=\"collapse{$name_menu}\">
                                                            <div class=\"sb-nav-link-icon\">
                                                                <i class=\"{$value->icon}\"></i> 
                                                            </div>
                                                            {$value->name}
                                                            <div class=\"sb-sidenav-collapse-arrow\">
                                                                <i class=\"fas fa-angle-down\"></i>
                                                            </div>
                                                        </a>";
                                    $menus .= "<div id=\"collapse{$name_menu}\" class=\"collapse\" aria-labelledby=\"headingOne\" data-parent=\"#sidenavAccordion\">
                                                        <nav class=\"sb-sidenav-menu-nested nav\">";
                                    $menu = $value->name;
                                }
                                $menus .= "<a class=\"nav-link\" href=" . CONF_URL_BASE . $value->path . ">{$value->name_page}</a>";
                            }
                            echo $menus . "</nav></div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div><?= session()->data(CONF_SESSION_LOGIN)->name ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="row">
                        <?php $this->view($view, $data); ?>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; <?= date('Y') ?> - <?= CONF_NAME_SYSTEM ?> <img src="<?= CONF_URL_BASE ?>public/img/main/more/br.png"> | Developer <a href="https://github.com/LAwade">Lucas Awade </a> | Version: <?= CONF_VERSION_CURRENT ?></div>

                    </div>
                </div>
            </footer>
        </div>
    </div>
    <?php include __DIR__ . '/js.php'; ?>
</body>

</html>