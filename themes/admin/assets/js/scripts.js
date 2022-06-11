// JQUERY INIT

$(function () {
    getCep('.getcep');
    var ajaxResponseBaseTime = 3;
    var ajaxResponseRequestError = "<div class='message error icon-warning'>Desculpe mas não foi possível processar sua requisição...</div>";

    // MOBILE MENU

    $(".mobile_menu").click(function (e) {
        e.preventDefault();

        var menu = $(".dash_sidebar");
        menu.animate({right: 0}, 200, function (e) {
            $("body").css("overflow", "hidden");
        });

        menu.one("mouseleave", function () {
            $(this).animate({right: '-260'}, 200, function (e) {
                $("body").css("overflow", "auto");
            });
        });
    });

    //NOTIFICATION CENTER

    function notificationsCount() {
        var center = $(".notification_center_open");
        $.post(center.data("count"), function (response) {
            if (response.count) {
                center.html(response.count);
            } else {
                center.html("0");
            }
        }, "json");
    }

    function notificationHtml(link, image, notify, date) {
        return '<div data-notificationlink="' + link + '" class="notification_center_item radius transition">\n' +
            '    <div class="image">\n' +
            '        <img class="rounded" src="' + image + '"/>\n' +
            '    </div>\n' +
            '    <div class="info">\n' +
            '        <p class="title">' + notify + '</p>\n' +
            '        <p class="time icon-clock-o">' + date + '</p>\n' +
            '    </div>\n' +
            '</div>';
    }

    notificationsCount();

    setInterval(function () {
        notificationsCount();
    }, 1000 * 50);

    $(".notification_center_open").click(function (e) {
        e.preventDefault();

        var notify = $(this).data("notify");
        var center = $(".notification_center");

        $.post(notify, function (response) {
            if (response.message) {
                ajaxMessage(response.message, ajaxResponseBaseTime);
            }

            var centerHtml = "";
            if (response.notifications) {
                $.each(response.notifications, function (e, notify) {
                    centerHtml += notificationHtml(notify.link, notify.image, notify.title, notify.created_at);
                });

                center.html(centerHtml);

                center.css("display", "block").animate({right: 0}, 200, function (e) {
                    $("body").css("overflow", "hidden");
                });
            }
        }, "json");

        center.one("mouseleave", function () {
            $(this).animate({right: '-320'}, 200, function (e) {
                $("body").css("overflow", "auto");
                $(this).css("display", "none");
            });
        });

        notificationsCount();
    });

    $(".notification_center").on("click", "[data-notificationlink]", function () {
        window.location.href = $(this).data("notificationlink");
    });

    //DATA SET

    $("[data-post]").click(function (e) {
        e.preventDefault();

        var clicked = $(this);
        var data = clicked.data();
        var load = $(".ajax_load");

        if (data.confirm) {
            var deleteConfirm = confirm(data.confirm);
            if (!deleteConfirm) {
                return;
            }
        }

        $.ajax({
            url: data.post,
            type: "POST",
            data: data,
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    load.fadeOut(200);
                }

                //reload
                if (response.reload) {
                    window.location.reload();
                } else {
                    load.fadeOut(200);
                }

                //message
                if (response.message) {
                    ajaxMessage(response.message, ajaxResponseBaseTime);
                }
            },
            error: function () {
                ajaxMessage(ajaxResponseRequestError, 5);
                load.fadeOut();
            }
        });
    });

    //FORMS

    $("form:not('.ajax_off')").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var load = $(".ajax_load");

        if (typeof tinyMCE !== 'undefined') {
            tinyMCE.triggerSave();
        }

        form.ajaxSubmit({
            url: form.attr("action"),
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                load.fadeIn(200).css("display", "flex");
            },
            uploadProgress: function (event, position, total, completed) {
                var loaded = completed;
                var load_title = $(".ajax_load_box_title");
                load_title.text("Enviando (" + loaded + "%)");

                if (completed >= 100) {
                    load_title.text("Aguarde, carregando...");
                }
            },
            success: function (response) {
                //redirect
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    form.find("input[type='file']").val(null);
                    load.fadeOut(200);
                }

                //reload
                if (response.reload) {
                    window.location.reload();
                } else {
                    load.fadeOut(200);
                }

                //message
                if (response.message) {
                    ajaxMessage(response.message, ajaxResponseBaseTime);
                }

                //image by fsphp mce upload
                if (response.mce_image) {
                    $('.mce_upload').fadeOut(200);
                    tinyMCE.activeEditor.insertContent(response.mce_image);
                }
            },
            complete: function () {
                if (form.data("reset") === true) {
                    form.trigger("reset");
                }
            },
            error: function () {
                ajaxMessage(ajaxResponseRequestError, 5);
                load.fadeOut();
            }
        });
    });

    // AJAX RESPONSE

    function ajaxMessage(message, time) {
        var ajaxMessage = $(message);

        ajaxMessage.append("<div class='message_time'></div>");
        ajaxMessage.find(".message_time").animate({"width": "100%"}, time * 1000, function () {
            $(this).parents(".message").fadeOut(200);
        });

        $(".ajax_response").append(ajaxMessage);
        ajaxMessage.effect("bounce");
    }

    // AJAX RESPONSE MONITOR

    $(".ajax_response .message").each(function (e, m) {
        ajaxMessage(m, ajaxResponseBaseTime += 1);
    });

    // AJAX MESSAGE CLOSE ON CLICK

    $(".ajax_response").on("click", ".message", function (e) {
        $(this).effect("bounce").fadeOut(1);
    });

    // MAKS

    $(".mask-date").mask('00/00/0000');
    $(".mask-datetime").mask('00/00/0000 00:00');
    $(".mask-month").mask('00/0000', {reverse: true});
    $(".mask-doc").mask('000.000.000-00', {reverse: true});
    $(".mask-cnpj").mask('00.000.000/0001-00', {reverse: false});
    $(".mask-phone").mask('(00) 0 0000-0000', {reverse: false});
    $(".mask-card").mask('0000  0000  0000  0000', {reverse: true});
    $(".mask-money").mask('000.000.000.000.000,00', {reverse: true, placeholder: "0,00"});
});

// TINYMCE INIT

tinyMCE.init({
    selector: "textarea.mce",
    language: 'pt_BR',
    menubar: false,
    theme: "modern",
    height: 132,
    skin: 'light',
    entity_encoding: "raw",
    theme_advanced_resizing: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor media"
    ],
    toolbar: "styleselect | pastetext | removeformat |  bold | italic | underline | strikethrough | bullist | numlist | alignleft | aligncenter | alignright |  link | unlink | fsphpimage | code | fullscreen",
    style_formats: [
        {title: 'Normal', block: 'p'},
        {title: 'Titulo 3', block: 'h3'},
        {title: 'Titulo 4', block: 'h4'},
        {title: 'Titulo 5', block: 'h5'},
        {title: 'Código', block: 'pre', classes: 'brush: php;'}
    ],
    link_class_list: [
        {title: 'None', value: ''},
        {title: 'Blue CTA', value: 'btn btn_cta_blue'},
        {title: 'Green CTA', value: 'btn btn_cta_green'},
        {title: 'Yellow CTA', value: 'btn btn_cta_yellow'},
        {title: 'Red CTA', value: 'btn btn_cta_red'}
    ],
    setup: function (editor) {
        editor.addButton('fsphpimage', {
            title: 'Enviar Imagem',
            icon: 'image',
            onclick: function () {
                $('.mce_upload').fadeIn(200, function (e) {
                    $("body").click(function (e) {
                        if ($(e.target).attr("class") === "mce_upload") {
                            $('.mce_upload').fadeOut(200);
                        }
                    });
                }).css("display", "flex");
            }
        });
    },
    link_title: false,
    target_list: false,
    theme_advanced_blockformats: "h1,h2,h3,h4,h5,p,pre",
    media_dimensions: false,
    media_poster: false,
    media_alt_source: false,
    media_embed: false,
    extended_valid_elements: "a[href|target=_blank|rel|class]",
    imagemanager_insert_template: '<img src="{$url}" title="{$title}" alt="{$title}" />',
    image_dimensions: false,
    relative_urls: false,
    remove_script_host: false,
    paste_as_text: true
});

// Step form

const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        formStepsNum++;
        updateFormSteps();
        updateProgressbar();
    });
});

prevBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        formStepsNum--;
        updateFormSteps();
        updateProgressbar();
    });
});

function updateFormSteps() {
    formSteps.forEach((formStep) => {
        formStep.classList.contains("form-step-active") &&
        formStep.classList.remove("form-step-active");
    });

    formSteps[formStepsNum].classList.add("form-step-active");
}

function updateProgressbar() {
    progressSteps.forEach((progressStep, idx) => {
        if (idx < formStepsNum + 1) {
            progressStep.classList.add("progress-step-active");
        } else {
            progressStep.classList.remove("progress-step-active");
        }
    });

    const progressActive = document.querySelectorAll(".progress-step-active");

    progress.style.width =
        ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}


// Colocando o CEP
function getCep(a) {
    if (a.length) {
        $(a).on('change', function () {
            const cep = $(this).val().replace('-', '').replace('.', '');
            if (cep.length === 8) {
                $.get("https://viacep.com.br/ws/" + cep + "/json", function (data) {
                    if (!data.erro) {
                        $('.js-district').val(data.bairro);
                        $('.js-street').val(data.logradouro);
                        $('.js-city').val(data.localidade);
                        $('.js-uf').val(data.uf);
                        $('.js-complement').val(data.complemento);
                    }
                }, 'json');
            }
        });
    }
}

//Convertendo data

function convertDateBr(dateStr){
    return dateStr.split('-').reverse().join('/');
}

//checkbox
$(document).ready(function() {
    $('.status').on('click', function() {
        let id = $(this).attr('data-id');
        let url = $(this).attr('data-url');
        let enabled = $(this).is(':checked');
        console.log(id);
        console.log(enabled);
        $.ajax({
            url: url+"/admin/clients/status/"+id+'/'+enabled,
            method: "POST",
            dataType: "applicatin/json",
            data: {
                "id": id,
                "enabled": enabled
            },
            success: function(data) {
                console.log("Deu certo");
            },
            error: function(err) {
                console.log(this.url);
            }
        });
    });
});


$(document).ready(function() {
    $('.generateInvoice').on('click', function() {
        let idUserInvoice = $(this).attr('data-id');
        let urlUserInvoice = $(this).attr('data-url');
        let enabledUserInvoice = $(this).is(':checked');
        console.log(idUserInvoice);
        console.log(enabledUserInvoice);
        $.ajax({
            url: urlUserInvoice+"/admin/clients/statusGenerateInvoice/"+idUserInvoice+'/'+enabledUserInvoice,
            method: "POST",
            dataType: "applicatin/json",
            data: {
                "id": idUserInvoice,
                "enabled": enabledUserInvoice
            },
            success: function(data) {
                console.log("Deu certo");
            },
            error: function(err) {
                console.log(this.url);
            }
        });
    });
});







