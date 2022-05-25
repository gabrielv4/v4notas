<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/functionarys/sidebar.php"); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2><i class="bi bi-file-person"></i> Frente de Expedição / <a href="<?=url('admin/functionarys/areaFunctionary')?>"><button class="button-default">Adicionar</button></a></h2>

        <form action="<?= url("/admin/functionarys/home"); ?>" method="post" class="app_search_form">
            <input type="text" name="s" value="<?= $search; ?>" placeholder="Pesquisar Funcionário:">
            <button class="icon-search icon-notext"></button>
        </form>

    </header>
    <div class="dash_content_app_box">
        <section>
            <div class="app_blog_home">
                <?php if (!$functionarys) : ?>
                    <div class="message info icon-info">Ainda não existem frente cadastrados.</div>
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
                            <?php foreach ($functionarys as $functionary) : ?>
                                <tr>

                                    <td><?= $functionary->first_name ?> <?= $functionary->last_name ?></td>
                                    <td><?= $functionary->email ?></td>
                                    <td><a class="icon-pencil btn btn-blue" href="<?=url('admin/functionarys/areaFunctionary/'.$functionary->id.'')?>">editar</a></td>

                                    <td> <a class="icon-trash-o btn btn-red" title="" href="#"
                                   data-post="<?= url("admin/functionarys/areaFunctionary"); ?>"
                                   data-action="delete"
                                   data-confirm="Tem certeza que deseja deletar esse funcionário?"
                                   data-functionary_id="<?= $functionary->id; ?>">Deletar</a></td>

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