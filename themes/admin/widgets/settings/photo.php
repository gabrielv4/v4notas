<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/settings/sidebar.php"); ?>

<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class=""><i class="bi bi-gear-fill"></i> Atualizar foto</h2>
    </header>

    <article class="dash_sidebar_user">
        <?php
        $photo = admin()->photo();
        $userPhoto = ($photo ? image($photo, 300, 300) : theme("/assets/images/avatar.jpg", CONF_VIEW_ADMIN));
        ?>
        <div><img class="dash_sidebar_user_thumb" src="<?= $userPhoto; ?>" alt="" title="" /></div>
        <form action="<?= url("/admin/settings/deletePhoto/" . admin()->id . ""); ?>" method="post">
            <input type="text" name="photo" value="" hidden/>
            <button class="btn btn-red">Retirar foto</button>
        </form>
    </article>

    <div class="dash_content_app_box">
        <form class="app_form" action="<?= url("/admin/settings/updatePhoto/" . admin()->id . ""); ?>" method="post" enctype="multipart/form-data">
            <label class="label">
                <span class="legend">Foto de Perfil:</span>
                <input type="file" name="photo" placeholder="Uma imagem de perfil" />
            </label>

            <a href="<?= url("/admin/settings/home") ?>" class="btn btn-blue">Alterar dados</a>

            <div class="al-right">
                <button class="btn btn-green">Atualizar <i class="bi bi-arrow-clockwise"></i></button>
            </div>
        </form>

    </div>

</section>