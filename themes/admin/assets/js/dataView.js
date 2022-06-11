const navDataView = document.querySelector(".navDataView");
const closeDataView = document.querySelector(".closeDataView");
const callDataView = document.querySelectorAll(".callDataView");
const customDataView = document.querySelector(".customDataView");

callDataView.forEach((e)=>{
    e.addEventListener('click', ()=>{

        if(navDataView.classList.contains("showDataView")){
            navDataView.classList.remove("showDataView");
            customDataView.classList.add("removeDataView");


        }else{
            navDataView.classList.add("showDataView");
            customDataView.classList.remove("removeDataView");

        }
    });
})


closeDataView.addEventListener('click', ()=>{
    navDataView.classList.add("showDataView");
    customDataView.classList.remove("removeDataView");

});



$(document).on('click', '.callDataView', function () {
    var userId = $(this).attr("id")
    var url_client = $(this).attr('data-url')
    if(userId !== ""){
        var dados_client = {
            userId: userId
        };
        $.get(url_client+'/admin/clientAllData/'+userId, dados_client, function(retorna){
            $("#templateDataView").html(retorna)

        })
    }
})
