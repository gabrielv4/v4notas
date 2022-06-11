// Campos de TEXTO

// Nome do StakeHoder
let nameStakeholder = document.querySelector('#name_stakeholder');
let whriteNameStakeholder = document.querySelector('.write_name_stakeholder');

if (document.body.contains(nameStakeholder)) {
    if (nameStakeholder.value == 0) {
        whriteNameStakeholder.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        whriteNameStakeholder.innerHTML = nameStakeholder.value;
    }
    nameStakeholder.addEventListener('keyup', () => {
        whriteNameStakeholder.innerHTML = nameStakeholder.value;
    });


// Telefone do StakeHoder
    let phoneStakeholder = document.querySelector('#phone_stakeholder');
    let writePhoneStakeholder = document.querySelector('.write_phone_stakeholder');

    if (phoneStakeholder.value == 0) {
        writePhoneStakeholder.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writePhoneStakeholder.innerHTML = phoneStakeholder.value;
    }
    phoneStakeholder.addEventListener('keyup', () => {
        writePhoneStakeholder.innerHTML = phoneStakeholder.value;
    });


// E-mail do StakeHoder
    let emailStakeholder = document.querySelector('#email_stakeholder');
    let writeEmailStakeholder = document.querySelector('.write_email_stakeholder');

    if (emailStakeholder.value == 0) {
        writeEmailStakeholder.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeEmailStakeholder.innerHTML = emailStakeholder.value;
    }
    emailStakeholder.addEventListener('keyup', () => {
        writeEmailStakeholder.innerHTML = emailStakeholder.value;
    });


// Responsavel Financeiro
    let financialName = document.querySelector('#financial_name');
    let writeFinancialName = document.querySelector('.write_financial_name');

    if (financialName.value == 0) {
        writeFinancialName.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeFinancialName.innerHTML = financialName.value;
    }
    financialName.addEventListener('keyup', () => {
        writeFinancialName.innerHTML = financialName.value;
    });


// Email Financeiro
    let emailFinancial = document.querySelector('#email_financial');
    let writeEmailFinancial = document.querySelector('.write_email_financial');

    if (emailFinancial.value == 0) {
        writeEmailFinancial.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeEmailFinancial.innerHTML = emailFinancial.value;
    }
    emailFinancial.addEventListener('keyup', () => {
        writeEmailFinancial.innerHTML = emailFinancial.value;
    });


// Razão Social
    let companyName = document.querySelector('#company_name');
    let writeCompanyName = document.querySelector('.write_company_name');

    if (companyName.value == 0) {
        writeCompanyName.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCompanyName.innerHTML = companyName.value;
    }
    companyName.addEventListener('keyup', () => {
        writeCompanyName.innerHTML = companyName.value;
    });


// CNPJ
    let cnpjCompany = document.querySelector('#company_cnpj');
    let writeCnpjCompany = document.querySelector('.write_company_cnpj');

    if (cnpjCompany.value == 0) {
        writeCnpjCompany.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCnpjCompany.innerHTML = cnpjCompany.value;
    }
    cnpjCompany.addEventListener('keyup', () => {
        writeCnpjCompany.innerHTML = cnpjCompany.value;
    });

// Socio Diretor
    let managingPartner = document.querySelector('#managing_partner');
    let writeManagingPartner = document.querySelector('.write_managing_partner');

    if (managingPartner.value == 0) {
        writeManagingPartner.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeManagingPartner.innerHTML = managingPartner.value;
    }
    managingPartner.addEventListener('keyup', () => {
        writeManagingPartner.innerHTML = managingPartner.value;
    });


    let checkAddress = document.querySelector(".check_address");

// CEP da empresa
    let companyCep = document.querySelector('#company_cep');
    let writeCompanyCep = document.querySelector('.write_company_cep');

    if (companyCep.value == 0) {
        writeCompanyCep.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCompanyCep.innerHTML = companyCep.value;
    }
    companyCep.addEventListener('keyup', () => {
        writeCompanyCep.innerHTML = companyCep.value;
    });


// Cidade da empresa
    let companyCity = document.querySelector('#company_city');
    let writeCompanyCity = document.querySelector('.write_company_city');

    checkAddress.addEventListener('click', () => {
        if (companyCity.value == 0) {
            writeCompanyCity.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
        } else {
            writeCompanyCity.innerHTML = companyCity.value;
        }
        companyCity.addEventListener('keyup', () => {
            writeCompanyCity.innerHTML = companyCity.value;
        });
    });

    if (companyCity.value == 0) {
        writeCompanyCity.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCompanyCity.innerHTML = companyCity.value;
    }
    companyCity.addEventListener('keyup', () => {
        writeCompanyCity.innerHTML = companyCity.value;
    });


// UF da empresa
    let companyUf = document.querySelector('#company_uf');
    let writeCompanyUf = document.querySelector('.write_company_uf');

    checkAddress.addEventListener('click', () => {
        if (companyUf.value == 0) {
            writeCompanyUf.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
        } else {
            writeCompanyUf.innerHTML = companyUf.value;
        }
        companyUf.addEventListener('keyup', () => {
            writeCompanyUf.innerHTML = companyUf.value;
        });
    })

    if (companyUf.value == 0) {
        writeCompanyUf.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCompanyUf.innerHTML = companyUf.value;
    }
    companyUf.addEventListener('keyup', () => {
        writeCompanyUf.innerHTML = companyUf.value;
    });


// Bairro da empresa
    let companyDistrict = document.querySelector('#company_district');
    let writeCompanyDistrict = document.querySelector('.write_company_district');

    checkAddress.addEventListener('click', () => {
        if (companyDistrict.value == 0) {
            writeCompanyDistrict.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
        } else {
            writeCompanyDistrict.innerHTML = companyDistrict.value;
        }
        companyDistrict.addEventListener('keyup', () => {
            writeCompanyDistrict.innerHTML = companyDistrict.value;
        });
    })

    if (companyDistrict.value == 0) {
        writeCompanyDistrict.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCompanyDistrict.innerHTML = companyDistrict.value;
    }
    companyDistrict.addEventListener('keyup', () => {
        writeCompanyDistrict.innerHTML = companyDistrict.value;
    });


// Rua da empresa
    let companyStreet = document.querySelector('#company_street');
    let writeCompanyStreet = document.querySelector('.write_company_street');


    checkAddress.addEventListener('click', () => {
        if (companyStreet.value == 0) {
            writeCompanyStreet.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
        } else {
            writeCompanyStreet.innerHTML = companyStreet.value;
        }
        companyDistrict.addEventListener('keyup', () => {
            writeCompanyStreet.innerHTML = companyStreet.value;
        });
    })

    if (companyStreet.value == 0) {
        writeCompanyStreet.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCompanyStreet.innerHTML = companyStreet.value;
    }
    companyDistrict.addEventListener('keyup', () => {
        writeCompanyStreet.innerHTML = companyStreet.value;
    });


// Numero da empresa
    let companyNumber = document.querySelector('#company_number');
    let writeCompanyNumber = document.querySelector('.write_company_number');

    checkAddress.addEventListener('click', () => {
        if (companyNumber.value == 0) {
            writeCompanyNumber.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
        } else {
            writeCompanyNumber.innerHTML = companyNumber.value;
        }
        companyDistrict.addEventListener('keyup', () => {
            writeCompanyNumber.innerHTML = companyNumber.value;
        });
    })

    if (companyNumber.value == 0) {
        writeCompanyNumber.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCompanyNumber.innerHTML = companyNumber.value;
    }
    companyDistrict.addEventListener('keyup', () => {
        writeCompanyNumber.innerHTML = companyNumber.value;
    });

// Complemento da empresa
    let companyComplement = document.querySelector('#company_complement');
    let writeCompanyComplement = document.querySelector('.write_company_complement');

    checkAddress.addEventListener('click', () => {
        if (companyComplement.value == 0) {
            writeCompanyComplement.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
        } else {
            writeCompanyComplement.innerHTML = companyComplement.value;
        }
        companyDistrict.addEventListener('keyup', () => {
            writeCompanyComplement.innerHTML = companyComplement.value;
        });
    })

    if (companyComplement.value == 0) {
        writeCompanyComplement.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeCompanyComplement.innerHTML = companyComplement.value;
    }
    companyDistrict.addEventListener('keyup', () => {
        writeCompanyComplement.innerHTML = companyComplement.value;
    });


// Cidade da Empresa
// let companyCep = document.querySelector('#company_cep');
// let companyCity = document.querySelector('#company_city');
// let writeCompanyCity = document.querySelector('.write_company_city');
// let companyUf = document.querySelector('#company_uf');
// let checkAddress = document.querySelector(".check_address");
//
// checkAddress.addEventListener('click', ()=>{
//     if(companyCity.value == 0){
//         writeCompanyCity.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
//     }else if(document.body.contains(companyUf)) {
//         writeCompanyCity.innerHTML = companyCity.value + '-' + companyUf.value;
//     } else {
//         writeCompanyCity.innerHTML = companyCity.value;
//     }
//     companyCity.addEventListener('keyup', ()=>{
//         writeCompanyCity.innerHTML = companyCity.value;
//     });
// });
//
// if(companyCity.value == 0){
//     writeCompanyCity.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
// } else if(document.body.contains(companyUf)){
//     writeCompanyCity.innerHTML = companyCity.value+ '-' + companyUf.value;
// } else {
//     writeCompanyCity.innerHTML = companyCity.value;
// }
// companyCity.addEventListener('keyup', ()=>{
//     writeCompanyCity.innerHTML = companyCity.value;
// });
//
// // Endereço Empresa
// let companyDistrict = document.querySelector('#company_district');
// let companyStreet = document.querySelector('#company_street');
// let companyComplement = document.querySelector('#company_complement');
//
// let writeCompanyAddress = document.querySelector('.write_company_address');
//
// checkAddress.addEventListener('click', ()=>{
//     if(companyDistrict.value == 0){
//         writeCompanyAddress.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
//     } else if(document.body.contains(companyStreet)){
//         writeCompanyAddress.innerHTML = companyDistrict.value+', '+companyStreet.value+', '+companyComplement.value+', '+companyCep.value
//     } else{
//         writeCompanyAddress.innerHTML = companyDistrict.value;
//     }
//     companyDistrict.addEventListener('keyup', ()=>{
//         writeCompanyAddress.innerHTML = companyDistrict.value;
//     });
// });

// if(companyDistrict.value == 0){
//     writeCompanyAddress.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
// } else if(document.body.contains(companyStreet)){
//     writeCompanyAddress.innerHTML = companyDistrict.value+', '+companyStreet.value+', '+companyComplement.value+', '+companyCep.value
// } else{
//     writeCompanyAddress.innerHTML = companyDistrict.value;
// }
// companyDistrict.addEventListener('keyup', ()=>{
//     writeCompanyAddress.innerHTML = companyDistrict.value;
// });


// Nome do Projeto
    let nameProject = document.querySelector('#name_project');
    let writeNameProject = document.querySelector('.write_name_project');

    if (nameProject.value == 0) {
        writeNameProject.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeNameProject.innerHTML = nameProject.value;
    }
    nameProject.addEventListener('keyup', () => {
        writeNameProject.innerHTML = nameProject.value;
    });

// Acessor do Projeto
    let advisor = document.querySelector('#advisor');
    let writeAdvisor = document.querySelector('.write_advisor');

    if (advisor.value == 0) {
        writeAdvisor.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeAdvisor.innerHTML = advisor.value;
    }
    advisor.addEventListener('keyup', () => {
        writeAdvisor.innerHTML = advisor.value;
    });

// Incio do Projeto
    let startProject = document.querySelector('#start_project');
    let writeStartProject = document.querySelector('.write_start_project');

    if (startProject.value == 0) {
        writeStartProject.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeStartProject.innerHTML = convertDateBr(startProject.value);
    }
    startProject.addEventListener('input', () => {
        writeStartProject.innerHTML = convertDateBr(startProject.value);
    });


// Origim do Projeto
    let origin = document.querySelector('#origin');
    let writeOrigin = document.querySelector('.write_origin');

    if (origin.value == 0) {
        writeOrigin.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeOrigin.innerHTML = origin.value;
    }
    origin.addEventListener('keyup', () => {
        writeOrigin.innerHTML = origin.value;
    });

// Primeiro Pagamento
    let firstPayment = document.querySelector('#first_payment');
    let writeFirstPayment = document.querySelector('.write_first_payment');

    if (firstPayment.value == 0) {
        writeFirstPayment.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeFirstPayment.innerHTML = convertDateBr(firstPayment.value);
    }
    firstPayment.addEventListener('input', () => {
        writeFirstPayment.innerHTML = convertDateBr(firstPayment.value);
    });


// Duração do contrato
    let contractDuration = document.querySelector('#contract_duration');
    let writeContractDuration = document.querySelector('.write_contract_duration');

    if (contractDuration.value == 0) {
        writeContractDuration.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeContractDuration.innerHTML = convertDateBr(contractDuration.value);
    }
    contractDuration.addEventListener('input', () => {
        writeContractDuration.innerHTML = convertDateBr(contractDuration.value);
    });

// Dia do Pagamento
    let payDay = document.querySelector('#pay_day');
    let writePayDay = document.querySelector('.write_pay_day');

    if (payDay.value == 0) {
        writePayDay.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writePayDay.innerHTML = payDay.value;
    }
    payDay.addEventListener('keyup', () => {
        writePayDay.innerHTML = payDay.value;
    });

// Valor do Fee
    let feeValue = document.querySelector('#fee_value');
    let writeFeeValue = document.querySelector('.write_fee_value');

    if (feeValue.value == 0) {
        writeFeeValue.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeFeeValue.innerHTML = feeValue.value;
    }
    feeValue.addEventListener('keyup', () => {
        writeFeeValue.innerHTML = feeValue.value;
    });


    // Dia de gerar a nota
    let invoiceDay = document.querySelector('#invoice_day');
    let writeInvoiceDay = document.querySelector('.write_invoice_day');

    if (invoiceDay.value == 0) {
        writeInvoiceDay.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeInvoiceDay.innerHTML = invoiceDay.value;
    }
    invoiceDay.addEventListener('keyup', () => {
        writeInvoiceDay.innerHTML = invoiceDay.value;
    });

    // Dia de gerar a nota
    let invoiceDescription = document.querySelector('#invoice_description');
    let writeInvoiceDescription = document.querySelector('.write_invoice_description');

    if (invoiceDescription.value == 0) {
        writeInvoiceDescription.innerHTML = '<b style="color:#cf2b1e;font-style: italic;">Não preenchido</b>';
    } else {
        writeInvoiceDescription.innerHTML = invoiceDescription.value;
    }
    invoiceDescription.addEventListener('keyup', () => {
        writeInvoiceDescription.innerHTML = invoiceDescription.value;
    });
}