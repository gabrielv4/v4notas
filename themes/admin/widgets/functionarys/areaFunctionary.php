<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/functionarys/sidebar.php"); ?>

<section class="dash_content_app">
        <?php if(!$functionary):?>
        <header class="dash_content_app_header">
            <h2 class="icon-plus-circle">Adicionar</h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/functionarys/areaFunctionary"); ?>" method="post" enctype="multipart/form-data">
                <!--ACTION SPOOFING-->
                <input type="hidden" name="action" value="create"/>

                <label class="label">
                    <span class="legend">*Nome:</span>
                    <input type="text" name="first_name" placeholder="Digite o nome do funcionário" required/>
                </label>

                <label class="label">
                    <span class="legend">*Sobrenome:</span>
                    <input type="text" name="last_name" placeholder="Digite o sobrenome do funcionário" required/>
                </label>

                <label class="label">
                    <span class="legend">*E-mail:</span>
                    <input type="email" name="email" placeholder="Digite o email do funcionário" required/>
                </label>

                <label class="label">
                    <span class="legend">*Senha:</span>
                    <input type="password" name="password" placeholder="Digite a senha do funcionário" required/>
                </label>

                <label class="label">
                    <span class="legend">*Confirmar Senha:</span>
                    <input type="password" name="confirm_pass" placeholder="Confimar senha" required/>
                </label>

                <div class="al-right">
                    <button class="btn btn-green">Adicionar <i class="bi bi-plus-circle"></i></button>
                </div>
            </form>
        </div>

        <?php else:?>
            <header class="dash_content_app_header">
            <h2 class=""><i class="bi bi-arrow-clockwise"></i> Atualizar</h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/functionarys/areaFunctionary/$functionary->id"); ?>" method="post" enctype="multipart/form-data">
                <!--ACTION SPOOFING-->
                <input type="hidden" name="action" value="update"/>

                <label class="label">
                    <span class="legend">*Nome:</span>
                    <input type="text" name="first_name" value="<?=$functionary->first_name?>" placeholder="Digite o nome do funcionário" required/>
                </label>

                <label class="label">
                    <span class="legend">*Sobrenome:</span>
                    <input type="text" name="last_name" value="<?=$functionary->last_name?>" placeholder="Digite o sobrenome do funcionário" required/>
                </label>

                <label class="label">
                    <span class="legend">*E-mail:</span>
                    <input type="email" name="email" value="<?=$functionary->email?>" placeholder="Digite o email do funcionário" required/>
                </label>

                <label class="label">
                    <span class="legend">*Senha:</span>
                    <input type="password" name="password" placeholder="Digite a senha do funcionário" />
                </label>

                <label class="label">
                    <span class="legend">*Confirmar Senha:</span>
                    <input type="password" name="confirm_pass" placeholder="Confimar senha" />
                </label>

                <div class="al-right">
                    <button class="btn btn-green">Atualizar <i class="bi bi-arrow-clockwise"></i></button>
                </div>
            </form>
        </div>

        <?php endif;?>
</section>