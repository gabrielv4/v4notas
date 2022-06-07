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
                            <th>Empresa</th>
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

                                <td><a class="link_text" href="<?=url('/admin/clients/nfse/'.$client->id)?>"><?= $client->company_name ?></a></td>
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
                                <td><a class="icon-folder btn btn-default modalNfseSend" id="<?=$client->id?>" href="#">Nota</a></td>

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


<div id="modalNfseSend" class="modal-container">
    <div class="modal-content">
        <button class="fechar">X</button>
        <h2 class="subtitulo">Enviar de Nota</h2>
        <br>
        <div class="content-info">
            <p><strong>Nome: </strong> <span class="invoice_name_client"></span></p>
            <p><strong>CNPJ: </strong> <span class="invoice_cnpj_client"></span></p>
            <p><strong>Emissão: </strong> <span class="invoice_date_nfse"></span></p>
        </div>
        <br>
        <form action="<?=url('/admin/nfse/add')?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="client_id" id="client_id" >
            <fieldset class="form-model">
                <textarea name="service" required id="service" placeholder="Informações sobre o serviço prestado" class="textarea-model"></textarea>
            </fieldset>
            <fieldset class="fieldset_model">
                <button class="modal-button btn-yes">Confirmar Envio</button>
            </fieldset>
        </form>
    </div>
</div>