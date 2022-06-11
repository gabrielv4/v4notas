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
                            <th>Nome do Projeto</th>
                            <th>StakeHolder</th>

                            <th>Dia do Pagamento</th>
                            <th>Assessor</th>
                            <th>Status</th>
                            <th>Ações</th>
                            </thead>
                        </tr>
                        <tbody>
                        <?php foreach ($clients as $client) : ?>
                            <tr>

                                <td><a class="link_text" href="<?=url('/admin/clients/nfse/'.$client->id)?>"><?= $client->name_project ?></a></td>
                                <td><?= $client->name_stakeholder ?></td>

                                <td><?=$client->pay_day?></td>
                                <td><?= $client->advisor ?></td>
                                <td class="<?= $client->status == 'ativo' ? 'ativo' : 'desativo'?>"><?= $client->status?></td>

                                <td>
                                    <a title="Editar" href="<?=url('admin/clients/areaClient/'.$client->id.'')?>"><i class="icon-pencil"></i></a>
                                    <a title="Excluir" href="#"data-post="<?= url("admin/clients/areaClient"); ?>"
                                       data-action="delete"
                                       data-confirm="Tem certeza que deseja deletar este cliente?"
                                       data-client_id="<?= $client->id; ?>"><i class="icon-trash-o"></i></a>

                                    <a href="#" data-url="<?=url()?>" class="callDataView" id="<?=$client->id?>" title="Verificar usuario"><i class="icon-user"></i></a>
                                </td>
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

<!--Gerar nota fiscal-->
<div id="modalNfseSend" class="modal-container">
    <div class="modal-content">
        <button class="fechar">X</button>
        <h2 class="subtitulo">Gerar de Nota</h2>
        <br>
        <div class="content-info" id="templeteModal">

        </div>
        <br>
        <form action="<?=url('/admin/nfse/add')?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="client_id" id="client_id"/>
            <fieldset class="form-model">
                <input type="text" name="invoice_value" placeholder="Digite o valor da nota"/>
                <input type="date" name="invoice_date" value="<?=date('Y-m-d')?>"/>
                <textarea name="service" required id="service" placeholder="Informações sobre o serviço prestado" class="textarea-model"></textarea>
            </fieldset>
            <fieldset class="fieldset_model">
                <button class="modal-button btn-yes" id="modal-button">Confirmar Envio</button>
            </fieldset>
        </form>
    </div>
</div>


<!--Ver usuario-->
<div id="modalUser" class="modal-container">
    <div class="modal-content">
        <button class="fechar">X</button>
        <h2 class="subtitulo">Dados do usuario</h2>
        <br>
        <div class="content-info" id="templeteModalUser">

        </div>

    </div>
</div>


