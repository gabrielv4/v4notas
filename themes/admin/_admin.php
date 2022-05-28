<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="stylesheet" href="<?= url("/shared/styles/boot.css"); ?>"/>
    <link rel="stylesheet" href="<?= url("/shared/styles/styles.css"); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/style.css", CONF_VIEW_ADMIN); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/modal.css", CONF_VIEW_ADMIN); ?>"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png", CONF_VIEW_ADMIN); ?>"/>
</head>
<body>

<div class="ajax_load" style="z-index: 999;">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<div class="ajax_response"><?= flash(); ?></div>

<div class="dash">
    <aside class="dash_sidebar">
        <article class="dash_sidebar_user">
            <?php
            $photo = admin()->photo();
            $userPhoto = ($photo ? image($photo, 300, 300) : theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
            ?>
            <div><img class="dash_sidebar_user_thumb" src="<?= $userPhoto; ?>" alt="" title=""/></div>
            <h3 class="dash_sidebar_user_name">
                <p style="color: #f2f2f2;"><?= admin()->fullName(); ?></p>
            </h3>
        </article>

        <ul class="dash_sidebar_nav">
            <?php
            $nav = function ($icon, $href, $title) use ($app) {
                $active = (explode("/", $app)[0] == explode("/", $href)[0] ? "active" : null);
                $url = url("/admin/{$href}");
                return "<li class=\"dash_sidebar_nav_li {$active}\"><a class=\"{$icon}\" href=\"{$url}\"> {$title}</a></li>";
            };
                echo $nav("bi bi-house-fill", "dash", "Dashboard");
                echo $nav("bi bi-people", "clients/home", "Clientes");
                echo $nav("bi bi-person-circle", "admins/home", "Admins");
                echo $nav("bi bi-gear-fill", "settings/home", "Configurações");
                echo $nav("sign-out on_mobile", "logoff", "Sair");
            ?>
        </ul>
    </aside>
    <section class="dash_content">
        <div class="dash_userbar">
            <div class="dash_userbar_box">
                <div class="dash_content_box">
                    <h1><a href="<?= url("/admin/dash"); ?>"><div class="container_img_logo"><img src="<?= theme("/assets/images/favicon.png", CONF_VIEW_ADMIN); ?>" alt="LOGO"> Painel<b>Admin</b></div></a></h1>
                    <div class="dash_userbar_box_bar">
                        <a class="no_mobile icon-sign-out" title="Sair" href="<?= url("/admin/logoff"); ?>">Sair</a>
                        <span class="icon-menu icon-notext mobile_menu transition"></span>
                    </div>
                </div>
            </div>

            <div class="notification_center"></div>
        </div>

        <div class="dash_content_box">
            <?= $v->section("content"); ?>
        </div>
    </section>
</div>

<script src="<?= url("/shared/scripts/jquery.min.js"); ?>"></script>
<script src="<?= url("/shared/scripts/jquery.form.js"); ?>"></script>
<script src="<?= url("/shared/scripts/jquery-ui.js"); ?>"></script>
<script src="<?= url("/shared/scripts/jquery.mask.js"); ?>"></script>
<script src="<?= url("/shared/scripts/tinymce/tinymce.min.js"); ?>"></script>
<script src="<?= theme("/assets/js/scripts.js", CONF_VIEW_ADMIN); ?>"></script>
<script src="<?= theme("/assets/js/base.js", CONF_VIEW_ADMIN); ?>"></script>
<script src="<?= theme("/assets/js/modal.js", CONF_VIEW_ADMIN); ?>"></script>

<?= $v->section("scripts"); ?>

</body>
</html>