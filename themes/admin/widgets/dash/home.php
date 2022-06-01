<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/dash/sidebar.php"); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-home">Dash - Notas Fiscais</h2>
        <form action="<?= url("/admin/dash/home"); ?>" method="post" class="app_search_form">
            <input type="text" name="s" value="<?= $search; ?>" placeholder="Pesquisar Nfse:">
            <button class="icon-search icon-notext"></button>
        </form>
    </header>

    <div class="dash_content_app_box">
        <section>
            <div class="app_blog_home">
                <?php if (empty($nfse)) : ?>

                    <div class="message info icon-info">Ainda não existem notas cadastrados.</div>
                <?php else : ?>

                    <table class="table">
                        <tr>
                            <thead>
                            <th>Cliente</th>
                            <th>CNPJ</th>
                            <th>Status</th>
                            <th>Nota</th>
                            <th>Data de Envio</th>
                            <th>Cancelar</th>

                            </thead>
                        </tr>
                        <tbody>
                        <?php foreach ($nfse as $invoice) : ?>
                            <tr>
                                <td><?= $invoice->name_client ?></td>
                                <td><?= $invoice->client()->cnpj ?></td>
                                <td>
                                    <?=$invoice->status == 'autorizado' ? "<b class='mt-2 text-success d-block' ><i class='bi bi-check-lg'></i> Nota Fiscal Emitida</b>" :
                                        ($invoice->status == 'processando_autorizacao' ? "<b class='mt-2 d-block text-info'><i class='bi bi-arrow-clockwise'></i> Processando NFSe</b>" :
                                            ($invoice->status == 'erro_autorizacao' ? "<a class='mt-2 text-danger modalNotification linkNotification' data-error='$invoice->error' href='#' id='$invoice->id'><i class='bi bi-x-lg'></i> <b>Erro ao emitir NFSe</b></a>" : ($invoice->status == 'cancelada' ? "<b class='mt-2 d-block text-warning'><i class='bi bi-exclamation-triangle-fill'></i> Nota cancelada</b>" : "<b class='mt-2 d-block text-warning'>Nota Fiscal Pendente</b>")))?>
                                </td>

                                <td><a class="btn btn-default" <?=$invoice->link == '' ? "style='pointer-events: none;'" : ''?> href="<?=$invoice->link?>" target="_blank"> Nota</a></td>
                                <td><?= date_fmt($invoice->send_at) ?></td>
                                <td> <a class="icon-trash-o btn btn-red modalNfse" id="<?=$invoice->invoice_code?>">Cancelar</a></td>
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

<!--JANELAS MODAIS-->

<!--Cancelamento de nota-->
<div id="modalNfse" class="modal-container">
    <div class="modal-content">
        <button class="fechar">X</button>
        <h2 class="subtitulo">Cancelamento de Nota</h2>
        <br>
        <div class="content-info">
            <p><strong>Nome: </strong> <span class="invoice_name_client"></span></p>
            <p><strong>CNPJ: </strong> <span class="invoice_cnpj_client"></span></p>
            <p><strong>Emissão: </strong> <span class="invoice_date_nfse"></span></p>
        </div>
        <br>
        <form action="<?=url('/admin/nfse/cancelamento')?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="invoice_code" id="invoice_code" >
            <fieldset class="form-model">
                <textarea name="justification" id="justification" placeholder="Informe a justificativa para o cancelamento" class="textarea-model"></textarea>
            </fieldset>
            <fieldset class="fieldset_model">
                <button class="btn-question btn-no">Confirmar cancelamento</button>
            </fieldset>
        </form>
    </div>
</div>


<!--Motificação Erro-->
<div id="modalNotification" class="modal-container">
    <div class="modal-content">
        <button class="fechar">X</button>
        <span class="showError"></span>
    </div>
</div>

