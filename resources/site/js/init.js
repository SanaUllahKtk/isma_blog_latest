"use strict";

Notiflix.Loading.init({
    zindex: 999999,
});
Notiflix.Block.init({
    zindex: 9999999,
});

Notiflix.Confirm.init({
    zindex: 99999999,
    plainText: false,
});

Notiflix.Notify.init({
    zindex: 99999999,
    position: "right-bottom",
    cssAnimation: true,
    cssAnimationDuration: 400,
    cssAnimationStyle: "zoom",
});

Notiflix.Report.init({
    zindex: 999999999,
    plainText: false,
    width: "auto",
    className: "custom-notiflix-report",
    svgSize: "0px",
});

const notify = Notiflix.Notify;

/*
|--------------------------------------------------------------------------
| Supplementary functions
|--------------------------------------------------------------------------
|
| These functions are used from anywhere in the application as supplementary
|
*/

const notificationManager = (type = "info", message = "No Message") => {
    switch (type) {
        case "success":
            Notiflix.Notify.success(message);
            break;
        case "failure":
            Notiflix.Notify.failure(message);
            break;
        case "warning":
            Notiflix.Notify.warning(message);
            break;
        case "info":
            Notiflix.Notify.info(message);
            break;
        default:
            Notiflix.Notify.info(message);
            break;
    }
};

const rebound = async ({
    form = null,
    data = null,
    method = "POST",
    url = null,
    refresh = false,
    reset = true,
    reload = false,
    redirect = null,
    block = "empty",
    beforeSendCallback = null,
    successCallback = null,
    errorCallback = null,
    completeCallback = null,
    notification = true,
    logging = true,
    returnData = false,
    processData = false,
    appendData = false,
}) => {
    if (form === null && data === null) {
        throw new Error("No form or data provided in rebound()");
    }
    if (url === null) {
        throw new Error("No url provided in rebound()");
    }
    let form_data;
    if (form !== null) {
        const formData = $(form)[0];
        form_data = new FormData(formData);
    }

    if (appendData) {
        for (const key in appendData) {
            form_data.append(key, appendData[key]);
        }
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url,
        method: method,
        data: data ?? form_data,
        processData: processData,
        contentType: processData ? "application/x-www-form-urlencoded" : false,
        beforeSend: function () {
            if (block) {
                block !== "empty"
                    ? Notiflix.Block.hourglass(block)
                    : Notiflix.Loading.hourglass();
            }
            if (beforeSendCallback !== null) {
                beforeSendCallback.apply(null, arguments);
            }
        },
        success: function (response) {
            logging ? console.log(response) : null;
            if (block) {
                block !== "empty"
                    ? Notiflix.Block.remove(block)
                    : Notiflix.Loading.remove();
            }
            if (reset) {
                if (form) {
                    $(form)
                        .find("input")
                        .each(function () {
                            $(this).val("").trigger("change");
                        });
                }
            }

            if (reload) {
                location.reload();
            }
            if (notification) {
                notificationManager(response.status, response.message);
            }
            refresh || response.refresh ? location.reload() : null;
            if (
                redirect !== null ||
                (response.redirect !== null && response.redirect !== undefined)
            ) {
                window.location.href = redirect ?? response.redirect;
            }
            if (successCallback !== null) {
                successCallback.apply(null, arguments);
            }

            if (returnData) {
                return response;
            }
            if (form) {
                $(form)
                    .find(".is-invalid")
                    .each(function () {
                        $(this).removeClass("is-invalid");
                    });
            }
            return true;
        },
        error: function (xhr, status, error) {
            logging ? console.error(xhr) : null;
            //   console.log(xhr);
            if (block) {
                block !== "empty"
                    ? Notiflix.Block.remove(block)
                    : Notiflix.Loading.remove();
            }
            if (errorCallback !== null) {
                errorCallback.apply(null, xhr);
            }
            if (xhr.status == 422) {
                $(form)
                    .find(".is-invalid")
                    .each(function () {
                        $(this).removeClass("is-invalid");
                    });
                $.each(xhr.responseJSON.errors, function (key, item) {
                    notify.failure(item[0]);
                    logging ? console.error(xhr) : null;
                    $(form).find(`[name=${key}]`).addClass("is-invalid");
                });
            } else if (xhr.status == 500) {
                notify.failure(error);
            } else {
                notify.failure(error);
            }
            return false;
        },
        complete: (response) => {
            // console.log("complete", response);
            if (block) {
                if (block !== "empty") {
                    Notiflix.Block.remove(block);
                } else {
                    Notiflix.Loading.remove();
                }
            }
            if (completeCallback !== null) {
                completeCallback.apply(null, response);
            }
        },
    });
};

window.validateRequired = (form) => {
    let required = $(form).find("[required]");
    let error = false;
    let first_required = null;
    required.each(function () {
        if ($(this).val() == "" || $(this).val() == null) {
            console.log($(this));
            //check if has tagify class
            if ($(this).hasClass("tagify")) {
                return;
            }
            error = true;
            if (first_required == null) {
                first_required = $(this);
            }
            $(this).addClass("is-invalid");
            $(this)
                .closest(".form-group")
                .find(".dropdown-toggle")
                .addClass("invalid-select");
            $(this)
                .closest(".form-group")
                .find(".dashboard-profile-photo")
                .addClass("invalid-uploader");
        } else {
            $(this).removeClass("is-invalid");
            $(this)
                .closest(".form-group")
                .find(".dropdown-toggle ")
                .removeClass("invalid-select");
            $(this)
                .closest(".form-group")
                .find(".dashboard-profile-photo")
                .removeClass("invalid-uploader");
        }
    });
    if (error) {
        first_required.focus();
        $("html, body").animate(
            {
                scrollTop: first_required.offset().top - 100,
            },
            200
        );
    }

    return error;
};

$(document).on("keyup change", "form input,select,textarea", function () {
    //check if required
    if (!$(this).attr("required")) {
        return;
    }
    if ($(this).val()) {
        if ($(this).is("input")) {
            $(this).removeClass("is-invalid");
        } else if ($(this).is("select")) {
            $(this)
                .closest(".form-group")
                .find(".select2-selection")
                .css("border", "1px solid #ced4da");
        } else if ($(this).is("textarea")) {
            $(this).removeClass("is-invalid");
        }
    } else {
        if ($(this).is("input")) {
            $(this).addClass("is-invalid");
        } else if ($(this).is("select")) {
            $(this)
                .closest(".form-group")
                .find(".select2-selection")
                .css("border", "1px solid red");
        } else if ($(this).is("textarea")) {
            $(this).addClass("is-invalid");
        }
    }
});

$(document).on("change", "[data-like-toggle]", function () {
    const id = $(this).data("like-toggle");
    const checkbox = $(this);

    $(this).prop("disabled", true);

    const url = window.location.origin + "/like/job";
    rebound({
        url: url,
        method: "POST",
        processData: true,
        block: false,
        data: {
            id: id,
        },
        successCallback: (response) => {
            console.log(response);
        },
        completeCallback: (response) => {
            $(checkbox).prop("disabled", false);
        },
    });
});

$(document).on("click", "[data-view-onclick]", function () {
    const html = $(this).html();
    console.log(html);
    Notiflix.Report.info("Image", html, "Ok");
});


