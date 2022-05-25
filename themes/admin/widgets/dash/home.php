<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/dash/sidebar.php"); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-home">Dash</h2>
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
                            <th>Status</th>
                            <th>Nota</th>
                            <th>Data de Envio</th>
                            <th>Cancelar</th>

                            </thead>
                        </tr>
                        <tbody>
                        <?php foreach ($nfse as $invoice) : ?>
                            <tr>
                                <td><?= $invoice->client()->company_name ?></td>
                                <td><?= $invoice->status ?></td>
                                <td><a class="btn btn-default" href="<?= $invoice->link?>" target="_blank"> Nota</a></td>
                                <td><?= date_fmt($invoice->send_at) ?></td>
                                <td> <a class="icon-trash-o btn btn-red" title="" href="#"
                                        data-post="<?= url("admin/clients/areaClient"); ?>"
                                        data-action="delete"
                                        data-confirm="Tem certeza que deseja deletar esse cliente?"
                                        data-client_id="<?= $invoice->id; ?>">Cancelar</a></td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php endif; ?>
            </div>


        </section>
    </div>
</section>

