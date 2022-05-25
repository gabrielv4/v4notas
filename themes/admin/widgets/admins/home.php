<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/admins/sidebar.php"); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2><i class="bi bi-person-circle"></i> Admins / <a href="<?=url('admin/admins/areaAdmin')?>"><button class="button-default">Adicionar</button></a></h2>

        <form action="<?= url("/admin/admins/home"); ?>" method="post" class="app_search_form">
            <input type="text" name="s" value="<?= $search; ?>" placeholder="Pesquisar Admin:">
            <button class="icon-search icon-notext"></button>
        </form>

    </header>
    <div class="dash_content_app_box">
    <section>
            <div class="app_blog_home">
                <?php if (!$admins) : ?>
                    <div class="message info icon-info">Ainda não existem admins cadastrados.</div>
                <?php else : ?>
                    
                    <table class="table">
                        <tr>
                            <thead>
                                <th>Nome Completo</th>
                                <th>Email</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </thead>
                        </tr>
                        <tbody>
                            <?php foreach ($admins as $admin) : ?>
                                <tr>

                                    <td><?= $admin->first_name ?> <?= $admin->last_name ?></td>
                                    <td><?= $admin->email ?></td>
                                    <td><a class="icon-pencil btn btn-blue" href="<?=url('admin/admins/areaAdmin/'.$admin->id.'')?>">Editar</a></td>

                                    <td> <a class="icon-trash-o btn btn-red" title="" href="#"
                                   data-post="<?= url("admin/admins/areaAdmin"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem certeza que deseja deletar esse admin?"
                                   data-admin_id="<?= $admin->id; ?>">Deletar</a></td>


                                </tr>
                                <?php endforeach; ?>

                            </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <?= $paginator; ?>
        </section>
    </div>
</section>