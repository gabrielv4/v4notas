/* Janelas Modais */

function iniciaModal(modalID){
    const modal = document.getElementById(modalID);
    if(modal){
        modal.classList.add('mostrar');
        modal.addEventListener('click',(e)=>{
            if(e.target.id == modalID || e.target.className == 'fechar' || e.target.className == 'link-button-modal' || e.target.className == 'btn-question btn-no' || e.target.className == 'btn-question btn-yes' || e.target.id == 'modal-button' ){
                modal.classList.remove('mostrar');
            }
        });
    }

}

//envio de notas
const modalNfseSend = document.querySelectorAll('.modalNfseSend');
modalNfseSend.forEach((e) => {
    e.addEventListener('click', function(botao) {
        var contentID = botao.target.id;
        document.getElementById('client_id').value = contentID
        document.querySelector('.invoice_name_client').innerHTML = e.parentNode.parentNode.childNodes[1].innerHTML;
        document.querySelector('.invoice_cnpj_client').innerHTML = e.parentNode.parentNode.childNodes[3].innerHTML;
        document.querySelector('.invoice_date_nfse').innerHTML = e.parentNode.parentNode.childNodes[9].innerHTML;
        iniciaModal("modalNfseSend", contentID);

    });
});


//cancelamento de notas
const modalNfse = document.querySelectorAll('.modalNfse');
modalNfse.forEach((e) => {
    e.addEventListener('click', function(botao) {
        var contentID = botao.target.id;
        document.getElementById('invoice_code').value = contentID
        document.querySelector('.invoice_name_client').innerHTML = e.parentNode.parentNode.childNodes[1].innerHTML;
        document.querySelector('.invoice_cnpj_client').innerHTML = e.parentNode.parentNode.childNodes[3].innerHTML;
        document.querySelector('.invoice_date_nfse').innerHTML = e.parentNode.parentNode.childNodes[11].innerHTML;
        iniciaModal("modalNfse", contentID);

    });
});


//Mostrar os erros das notas
// const modalNotification = document.querySelectorAll('.modalNotification');
// const showError = document.querySelector('.showError');
//
//
// modalNotification.forEach((e) => {
//     e.addEventListener('click', function(botao) {
//         var contentID = botao.target.id;
//
//         showError.innerHTML = e.dataset.error;
//         iniciaModal("modalNotification", contentID);
//
//
//     });
// })


    $(document).on('click', '.viewDataClient', function () {
        var user_id = $(this).attr("id")
        var url_user = $(this).attr('data-url')
        if(user_id !== ""){
            var dados_user = {
                user_id: user_id
            };
            $.get(url_user+'/admin/clientFind/'+user_id, dados_user, function(volta){
                $("#templeteModal").html(volta)
                $('#client_id') .val (user_id)
                iniciaModal("modalNfseSend", user_id);

            })
        }
    })


    $(document).on('click', '.viewData', function () {
        var invoice_code = $(this).attr("id")
        var url_invoice = $(this).attr('data-url')
        if(invoice_code !== ""){
            var dados = {
                invoice_code: invoice_code
            };
            $.post(url_invoice+'/admin/nfseFind/'+invoice_code, dados, function(retorna){
                $("#templeteModal").html(retorna)
                $('#invoice_code') .val (invoice_code)
                iniciaModal("modalNfse", invoice_code);

            })
        }
    })

    $(document).on('click', '.viewDataError', function () {
        var invoice_code = $(this).attr("id")
        var url_invoice = $(this).attr('data-url')
        if(invoice_code !== ""){
            var dados = {
                invoice_code: invoice_code
            };
            $.post(url_invoice+'/admin/nfseError/'+invoice_code, dados, function(retorna){

                $(".showError").html(retorna)
                $('#invoice_code') .val (invoice_code)
                iniciaModal("modalNotification", invoice_code);

            })
        }
    })







