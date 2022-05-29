<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/clients/sidebar.php"); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2><i class="bi bi-people"></i> Clientes / <a href="<?=url('admin/clients/areaClient')?>"><button class="button-default">Adicionar</button></a></h2>
        <form action="<?= url("/admin/clients/home"); ?>" method="post" class="app_search_form">
            <input type="text" name="s" value="<?= $search; ?>" placeholder="Pesquisar Cliente:">
            <button class="icon-search icon-notext"></button>
        </form>
    </header>
    <div class="dash_content_app_box">
        <section>
            <div class="app_blog_home">
                <?php if (empty($clients)) : ?>

                    <div class="message info icon-info">Ainda não existem clientes cadastrados.</div>
                <?php else : ?>
                    <table class="table">
                        <tr>
                            <thead>
                                <th>Projeto</th>
                                <th>StakeHolder</th>
                                <th>Email</th>
                                <th>Acessor</th>
                                <th>Status</th>
                                <th>Editar</th>
                                <th>Exlucir</th>
                                <th>Gerar Nota</th>
                            </thead>
                        </tr>
                        <tbody>
                            <?php foreach ($clients as $client) : ?>
                                <tr>

                                    <td><?= $client->name_project ?></td>
                                    <td><?= $client->name_stakeholder ?></td>
                                    <td><?= $client->email_stakeholder?></td>
                                    <td><?= $client->advisor ?></td>
                                    <td class="<?= $client->status == 'ativo' ? 'ativo' : 'desativo'?>"><?= $client->status?></td>

                                    <td><a class="icon-pencil btn btn-blue" href="<?=url('admin/clients/areaClient/'.$client->id.'')?>">Editar</a></td>

                                    <td> <a class="icon-trash-o btn btn-red" title="" href="#"
                                            data-post="<?= url("admin/clients/areaClient"); ?>"
                                            data-action="delete"
                                            data-confirm="Tem certeza que deseja deletar esse cliente?"
                                            data-client_id="<?= $client->id; ?>">Deletar</a></td>
                                    <td><a class="icon-folder btn btn-default" href="<?=url('/admin/nfse/'.$client->id)?>">Nota</a></td>

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