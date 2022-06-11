<?php $v->layout("_admin"); ?>
<?php $v->insert("widgets/admins/sidebar.php"); ?>

<section class="dash_content_app">
        <?php if(empty($client)):?>
        <header class="dash_content_app_header">
            <h2 class="icon-plus-circle">Adicionar Cliente</h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/clients/areaClient"); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden"  value="create" name="action">
                <!-- Progress bar -->
                <div class="progressbar">
                    <div class="progress" id="progress"></div>

                    <div class="progress-step progress-step-active" data-title="Responsaveis"></div>
                    <div class="progress-step" data-title="Empresa"></div>
                    <div class="progress-step" data-title="Pagamentos"></div>
                    <div class="progress-step" data-title="Enredereço"></div>
                    <div class="progress-step" data-title="Projeto"></div>
                    <div class="progress-step" data-title="Finalizar"></div>
                </div>

                <!-- Steps -->
                <div class="form-step form-step-active">
                    <label class="label">
                        <span class="legend">*Nome StakeHolder:</span>
                        <input type="text" name="name_stakeholder" id="name_stakeholder" placeholder="Nome do StakeHolder" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Telefone StakeHolder:</span>
                        <input type="text" name="phone_stakeholder" id="phone_stakeholder" class="mask-phone" placeholder="Telefone do StakeHolder" required />
                    </label>

                    <label class="label">
                        <span class="legend">*E-mail StakeHolder:</span>
                        <input type="email" name="email_stakeholder" id="email_stakeholder" placeholder="Email do StakeHolder" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Responsavel Financeiro:</span>
                        <input type="text" name="financial_name" id="financial_name" placeholder="Nome do responsavel financeiro" required />
                    </label>

                    <label class="label">
                        <span class="legend">*E-mail Responsavel financeiro:</span>
                        <input type="email" name="financial_email" id="email_financial" placeholder="Email do responsavel financeiro" required />
                    </label>

                    <div class="btns-group">

                        <a href="#" class="btn btn-next">Proximo </a>
                    </div>
                </div>


                <div class="form-step">
                    <label class="label">
                        <span class="legend">*Razão Social:</span>
                        <input type="text" name="company_name" id="company_name" placeholder="Razão Social da empresa" required />
                    </label>

                    <label class="label">
                        <span class="legend">*CNPJ:</span>
                        <input type="text" name="cnpj" id="company_cnpj" class="mask-cnpj" placeholder="CNPJ da empresa" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Sócio Direitor:</span>
                        <input type="text" name="managing_partner" id="managing_partner" placeholder="Sócio diretor" required />
                    </label>

                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <a href="#" class="btn btn-next">Proximo </a>
                    </div>
                </div>


                <div class="form-step">

                    <label class="label">
                        <span class="legend">*Primeiro Pagamento:</span>
                        <input type="date" name="first_payment" id="first_payment" placeholder="Data do primeiro pagamento" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Vigencia do Contrato:</span>
                        <input type="date" name="contract_duration" id="contract_duration" placeholder="Vigencia do Contrato" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Dia do pagamento:</span>
                        <input type="text" name="pay_day" id="pay_day" placeholder="Dia do pagamento" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Dia para receber a nota:</span>
                        <input type="text" name="invoice_day" id="invoice_day" placeholder="Coloque o dia em que o cliente receberá a nota fiscal" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Valor do Fee:</span>
                        <input type="text" name="fee_value" id="fee_value" placeholder="Valor do Fee" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Descrição da nota:</span>
                        <textarea id="invoice_description" placeholder="Coloque aqui a descrição da nota" name="invoice_description"></textarea>
                    </label>

                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <a href="#" class="btn btn-next">Proximo</a>
                    </div>
                </div>


                <div class="form-step">
                    <label class="label">
                        <span class="legend">*CEP:</span>
                        <input type="text" name="cep" id="company_cep" class="getcep" name="zipcode" placeholder="Digite o CEP" data-mask="00000-000" placeholder="CEP da Empresa" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Cidade:</span>
                        <input type="text" name="city" class="js-city"  id="company_city" placeholder="Ex. São Paulo" required />
                    </label>

                    <label class="label">
                        <span class="legend">*UF:</span>
                        <input type="text" name="uf" class="js-uf" id="company_uf"  maxlength="2" placeholder="Ex. SP" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Bairro:</span>
                        <input type="text" name="district" class="js-district" id="company_district"  placeholder="Ex. Centro" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Rua:</span>
                        <input type="text" name="street" class="js-street" id="company_street"  placeholder="Digite a rua" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Número:</span>
                        <input type="text" name="number" id="company_number" placeholder="Ex. 200" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Completomento:</span>
                        <input type="text" name="complement" class="js-complement" id="company_complement" id="complement" placeholder="Ex. ao lado da escola" />
                    </label>

                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <a href="#" class="btn btn-next check_address">Proximo</a>
                    </div>
                </div>

                <div class="form-step">
                    <label class="label">
                        <span class="legend">*Nome do Projeto:</span>
                        <input type="text" name="name_project" id="name_project" placeholder="Nome do Projeto" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Acessor reponsavel:</span>
                        <input type="text" name="advisor" id="advisor" placeholder="Acessor Responsavel" required />
                    </label>

                    <label class="label">
                        <span class="legend">*inicio do Projeto :</span>
                        <input type="date" name="start_project" id="start_project" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Origem:</span>
                        <input type="text" name="origin" id="origin" placeholder="Origem" required />
                    </label>
                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <a href="#" class="btn btn-next ">Proximo</a>
                    </div>
                </div>




                <div class="form-step ">

                    <div class="review_form">
                        <h3>1. Reponsaveis</h3>
                        <div class="data_form">
                            <label><b>Nome StakeHolder: </b> <p class="write_name_stakeholder"></p></label>
                            <label><b>Telefone StakeHolder: </b> <p class="write_phone_stakeholder"></p></label>
                            <label><b>E-mail StakeHolder: </b> <p class="write_email_stakeholder"></p></label>
                        </div>

                        <div class="data_form">
                            <label><b>Responsavel financeiro: </b> <p class="write_financial_name"></p></label>
                            <label><b>E-mail financeiro: </b> <p class="write_email_financial"></p></label>
                            <label for=""></label>
                            <label for=""></label>
                        </div>

                    </div>

                    <hr/>

                    <div class="review_form">
                        <h3>2. Empresa</h3>
                        <div class="data_form">
                            <label><b>Razão Social: </b> <p class="write_company_name"></p></label>
                            <label><b>CNPJ: </b> <p class="write_company_cnpj"></p></label>
                            <label><b>Sócio Direitor: </b> <p class="write_managing_partner"></p></label>
                        </div>

                    </div>

                    <hr/>

                    <div class="review_form">
                        <h3>3. Endereço</h3>
                        <div class="data_form">
                            <label><b>CEP: </b> <p class="write_company_cep"></p></label>
                            <label><b>Cidade: </b> <p class="write_company_city"></p></label>
                            <label><b>UF: </b> <p class="write_company_uf"></p></label>
                        </div>

                        <div class="data_form">
                            <label><b>Bairro: </b> <p class="write_company_district"></p></label>
                            <label><b>Rua: </b> <p class="write_company_street"></p></label>
                            <label><b>Número: </b> <p class="write_company_number"></p></label>
                            <label><b>Complemento: </b> <p class="write_company_complement"></p></label>
                        </div>
                    </div>

                    <hr/>

                    <div class="review_form">
                        <h3>4. Projeto</h3>
                        <div class="data_form">
                            <label><b>Nome do Projeto: </b> <p class="write_name_project"></p></label>
                            <label><b>Acessor: </b> <p class="write_advisor"></p></label>
                            <label><b>Inicio: </b> <p class="write_start_project"></p></label>
                            <label><b>Origim: </b> <p class="write_origin"></p></label>
                        </div>
                    </div>

                    <hr/>

                    <div class="review_form">
                        <h3>4. Datas</h3>
                        <div class="data_form">
                            <label><b>Primeiro Pagamento: </b> <p class="write_first_payment"></p></label>
                            <label><b>Duração do Contrato: </b> <p class="write_contract_duration"></p></label>
                            <label><b>Dia do Pagamento: </b> <p class="write_pay_day"></p></label>
                        </div>

                        <div class="data_form">
                            <label><b>Dia do para receber a nota: </b> <p class="write_invoice_day"></p></label>
                            <label><b>Valor do Fee: </b> <p class="write_fee_value"></p></label>
                            <label><b>Descrição da nota: </b> <p class="write_invoice_description"></p></label>
                        </div>
                    </div>

                    <hr/>

                    <div class="btns-group finish-step">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <input type="submit" class="button-step-finish" value="Finalizar ✔">
                    </div>

                </div>


            </form>
        </div>

        <?php else:?>
            <header class="dash_content_app_header">
            <h2 class=""><i class="bi bi-arrow-clockwise"></i> Atualizar Cliente</h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/admin/clients/areaClient/{$client->id}"); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden"  value="update" name="action">
                <!-- Progress bar -->
                <div class="progressbar">
                    <div class="progress" id="progress"></div>

                    <div class="progress-step progress-step-active" data-title="Responsaveis"></div>
                    <div class="progress-step" data-title="Empresa"></div>
                    <div class="progress-step" data-title="Enredereço"></div>
                    <div class="progress-step" data-title="Projeto"></div>
                    <div class="progress-step" data-title="Datas"></div>
                    <div class="progress-step" data-title="Finalizar"></div>
                </div>

                <!-- Steps -->
                <div class="form-step form-step-active">
                    <label class="label">
                        <span class="legend">*Nome StakeHolder:</span>
                        <input type="text" name="name_stakeholder" value="<?=$client->name_stakeholder?>" id="name_stakeholder" placeholder="Nome da StakeHolder" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Telefone StakeHolder:</span>
                        <input type="text" name="phone_stakeholder" value="<?=$client->phone_stakeholder?>" id="phone_stakeholder" value="<?=$client->phone_stakeholder?>" class="mask-phone" placeholder="Telefone do StakeHolder" required />
                    </label>

                    <label class="label">
                        <span class="legend">*E-mail StakeHolder:</span>
                        <input type="email" name="email_stakeholder" value="<?=$client->email_stakeholder?>"  id="email_stakeholder" placeholder="Email do StakeHolder" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Responsavel financeiro:</span>
                        <input type="text" name="financial_name" value="<?=$client->financial_name?>" id="financial_name" placeholder="Nome do responsavel financeiro" required />
                    </label>

                    <label class="label">
                        <span class="legend">*E-mail Responsavel financeiro:</span>
                        <input type="email" name="financial_email" value="<?=$client->financial_email?>" id="email_financial" placeholder="Email do responsavel financeiro" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Status:</span>
                        <label class="switch switch-danger">
                            <input id="switch1" data-id="<?=$client->id?>" data-url="<?=url()?>" class="status" <?=$client->status == 'ativo' ? 'checked' : ''?> type="checkbox" />
                            <span class="switch-slider"></span>
                        </label>
                    </label>

                    <div class="btns-group">

                        <a href="#" class="btn btn-next">Proximo </a>
                    </div>
                </div>


                <div class="form-step">
                    <label class="label">
                        <span class="legend">*Razão Social:</span>
                        <input type="text" name="company_name" value="<?=$client->company_name?>" id="company_name" placeholder="Razão Social da empresa" required />
                    </label>

                    <label class="label">
                        <span class="legend">*CNPJ:</span>
                        <input type="text" name="cnpj" value="<?=$client->cnpj?>" id="company_cnpj" class="mask-cnpj" placeholder="CNPJ da empresa" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Sócio Direitor:</span>
                        <input type="text" name="managing_partner" value="<?=$client->managing_partner?>" id="managing_partner" placeholder="Sócio diretor" required />
                    </label>

                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <a href="#" class="btn btn-next">Proximo </a>
                    </div>
                </div>


                <div class="form-step">
                    <label class="label">
                        <span class="legend">*CEP:</span>
                        <input type="text" name="cep" value="<?=$client->cep?>" id="company_cep" class="getcep" name="zipcode" placeholder="Digite o CEP" data-mask="00000-000" placeholder="CEP da Empresa" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Cidade:</span>
                        <input type="text" name="city" value="<?=$client->city?>" class="js-city"  id="company_city" placeholder="Ex. São Paulo" required />
                    </label>

                    <label class="label">
                        <span class="legend">*UF:</span>
                        <input type="text" name="uf" value="<?=$client->uf?>" class="js-uf" id="company_uf"  maxlength="2" placeholder="Ex. SP" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Bairro:</span>
                        <input type="text" value="<?=$client->district?>" name="district" class="js-district" id="company_district"  placeholder="Ex. Centro" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Rua:</span>
                        <input type="text" value="<?=$client->street?>" name="street" class="js-street" id="company_street"  placeholder="Digite a rua" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Número:</span>
                        <input type="text" value="<?=$client->number?>" name="number" id="company_number" placeholder="Ex. 200" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Completomento:</span>
                        <input type="text" value="<?=$client->complement?>" name="complement" class="js-complement" id="company_complement" id="complement" placeholder="Ex. ao lado da escola"  />
                    </label>

                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <a href="#" class="btn btn-next check_address">Proximo</a>
                    </div>
                </div>
                <div class="form-step">
                    <label class="label">
                        <span class="legend">*Nome do Projeto:</span>
                        <input type="text" name="name_project" value="<?=$client->name_project?>" id="name_project" placeholder="Nome do Projeto" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Assessor responsavel:</span>
                        <input type="text" name="advisor" value="<?=$client->advisor?>" id="advisor" placeholder="Assessor responsavel" required />
                    </label>

                    <label class="label">
                        <span class="legend">*inicio do Projeto :</span>
                        <input type="date" name="start_project" value="<?=$client->start_project?>" id="start_project" placeholder="Acessor Responsavel" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Origem:</span>
                        <input type="text" name="origin" value="<?=$client->origin?>" id="origin" placeholder="Origem" required />
                    </label>
                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <a href="#" class="btn btn-next">Proximo</a>
                    </div>
                </div>

                <div class="form-step">

                    <label class="label">
                        <span class="legend">*Primeiro Pagamento:</span>
                        <input type="date" name="first_payment" value="<?=$client->first_payment?>" id="first_payment" placeholder="Data do primeiro pagamento" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Vigencia do Contrato:</span>
                        <input type="date" name="contract_duration" value="<?=$client->contract_duration?>" id="contract_duration" placeholder="Vigencia do Contrato" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Dia do pagamento:</span>
                        <input type="text" name="pay_day" id="pay_day" value="<?=$client->pay_day?>" placeholder="Dia do pagamento" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Valor do Fee:</span>
                        <input type="text" name="fee_value" id="fee_value" value="<?=$client->fee_value?>" placeholder="Valor do Fee" required />
                    </label>

                    <div class="btns-group">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <a href="#" class="btn btn-next">Proximo</a>
                    </div>
                </div>


                <div class="form-step ">

                    <div class="review_form">
                        <h3>1. Reponsaveis</h3>
                        <div class="data_form">
                            <label><b>Nome StakeHolder: </b> <p class="write_name_stakeholder"></p></label>
                            <label><b>Telefone StakeHolder: </b> <p class="write_phone_stakeholder"></p></label>
                            <label><b>E-mail StakeHolder: </b> <p class="write_email_stakeholder"></p></label>
                        </div>

                        <div class="data_form">
                            <label><b>Responsavel financeiro: </b> <p class="write_financial_name"></p></label>
                            <label><b>E-mail financeiro: </b> <p class="write_email_financial"></p></label>
                            <label for=""></label>
                            <label for=""></label>
                        </div>

                    </div>

                    <hr/>

                    <div class="review_form">
                        <h3>2. Empresa</h3>
                        <div class="data_form">
                            <label><b>Razão Social: </b> <p class="write_company_name"></p></label>
                            <label><b>CNPJ: </b> <p class="write_company_cnpj"></p></label>
                            <label><b>Sócio Direitor: </b> <p class="write_managing_partner"></p></label>
                        </div>

                    </div>

                    <hr/>

                    <div class="review_form">
                        <h3>3. Endereço</h3>
                        <div class="data_form">
                            <label><b>CEP: </b> <p class="write_company_cep"></p></label>
                            <label><b>Cidade: </b> <p class="write_company_city"></p></label>
                            <label><b>UF: </b> <p class="write_company_uf"></p></label>
                        </div>

                        <div class="data_form">
                            <label><b>Bairro: </b> <p class="write_company_district"></p></label>
                            <label><b>Rua: </b> <p class="write_company_street"></p></label>
                            <label><b>Número: </b> <p class="write_company_number"></p></label>
                            <label><b>Complemento: </b> <p class="write_company_complement"></p></label>
                        </div>
                    </div>

                    <hr/>

                    <div class="review_form">
                        <h3>4. Projeto</h3>
                        <div class="data_form">
                            <label><b>Nome do Projeto: </b> <p class="write_name_project"></p></label>
                            <label><b>Acessor: </b> <p class="write_advisor"></p></label>
                            <label><b>Inicio: </b> <p class="write_start_project"></p></label>
                            <label><b>Origim: </b> <p class="write_origin"></p></label>
                        </div>
                    </div>

                    <hr/>

                    <div class="review_form">
                        <h3>4. Datas</h3>
                        <div class="data_form">
                            <label><b>Primeiro Pagamento: </b> <p class="write_first_payment"></p></label>
                            <label><b>Duração do Contrato: </b> <p class="write_contract_duration"></p></label>
                            <label><b>Dia do Pagamento: </b> <p class="write_pay_day"></p></label>
                            <label><b>Valor do Fee: </b> <p class="write_fee_value"></p></label>
                        </div>
                    </div>

                    <hr/>

                    <div class="btns-group finish-step">
                        <a href="#" class="btn btn-prev">Anterior</a>
                        <input type="submit" class="button-step-finish" value="Atualizar ✔">
                    </div>

                </div>


            </form>
        </div>

        <?php endif;?>
</section>
