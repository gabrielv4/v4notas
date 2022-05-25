<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/nfse/sidebar.php"); ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2><i class="bi bi-file-earmark-pdf"></i> Nota Fiscal <?=$doc->name_client?></h2>
    </header>
    <div class="dash_content_app_box">
        <section>

                <!-- NOTA FISCAL -->

                <?php if (!$doc->invoice) : ?>
                    <br />
                    <h2 style="text-align: center;">Nenhum arquivo encontrado
                        <br /><br />
                    </h2>

                <?php else : ?>
                    <div class="cards-area">
                        <?php foreach (json_decode($doc->invoice, true) as $key => $invoice) : ?>

                            <?php if (substr($invoice, -3) == "jpg" || substr($invoice, -4) == "jpeg" || substr($invoice, -3) == "png") : ?>

                                <div class="card-container">
                                    <div class="card-title">Nota Fiscal</div>
                                    <div class="card-image"><img src="<?= image($invoice, 200) ?>" alt="Nota Fiscal"></div>
                                    <div class="">
                                        <a href="<?= url('storage/' . $invoice) ?>" class="default-btn" target="_blank">Ver completo</a>
                                    </div>
                                </div>

                            <?php else : ?>
                                <div class="card-container">
                                    <div class="card-title">Nota Fiscal</div>
                                    <div class="card-image"><i class="bi bi-file-earmark-pdf pdf-file"></i></div>
                                    <div class="">
                                        <a href="<?= url('storage/' . $invoice) ?>" class="default-btn" target="_blank">Ver completo</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

        </section>
    </div>
</section>