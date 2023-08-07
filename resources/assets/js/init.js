const isRtl = $("html").attr("data-textdirection") === "rtl";
var $textHeadingColor = '#5e5873';
var $strokeColor = '#ebe9f1';
var $labelColor = '#e7eef7';
var $avgSessionStrokeColor2 = '#ebf0f7';
var $budgetStrokeColor2 = '#dcdae3';
var $goalStrokeColor2 = '#51e5a8';
var $revenueStrokeColor2 = '#d0ccff';
var $textMutedColor = '#b9b9c3';
var $salesStrokeColor2 = '#3585c6';
var $white = '#fff';
var $earningsStrokeColor2 = '#28c76f66';
var $earningsStrokeColor3 = '#28c76f33';

function snb(type, head, text) {
    toastr[type](text, head, {
        closeButton: true,
        tapToDismiss: false,
        showMethod: "slideDown",
        hideMethod: "slideUp",
        timeOut: 2000,
        rtl: isRtl,
        progressBar: true,
    });
}

"use strict";

function setTheme(data) {
    const theme = $(data).children().attr('class');
    const type = theme.split(" ");
    const exp = (d => d.setFullYear(d.getFullYear() + 1))(new Date)
    document.cookie = (type[1] === 'feather-moon') ? 'theme=dark; expires=Thu, 01 Jan 2026 00:00:00 UTC; path=/' : 'theme=light; expires=Thu, 01 Jan 2026 00:00:00 UTC; path=/';
}

function initEditor({ editor = null }) {
    if ($('#' + editor) !== 'null') {
        new Quill('#' + editor + ' .editor', {
            bounds: '#' + editor + ' .editor',
            modules: {
                formula: true,
                syntax: true,
                toolbar: [
                    [
                        {
                            font: []
                        },
                        {
                            size: []
                        }
                    ],
                    ['bold', 'italic', 'underline', 'strike'],
                    [
                        {
                            color: []
                        },
                        {
                            background: []
                        }
                    ],
                    [
                        {
                            script: 'super'
                        },
                        {
                            script: 'sub'
                        }
                    ],
                    [
                        {
                            header: '1'
                        },
                        {
                            header: '2'
                        },
                        'blockquote',
                        'code-block'
                    ],
                    [
                        {
                            list: 'ordered'
                        },
                        {
                            list: 'bullet'
                        },
                        {
                            indent: '-1'
                        },
                        {
                            indent: '+1'
                        }
                    ],
                    [
                        'direction',
                        {
                            align: []
                        }
                    ],
                    ['link', 'image', 'video', 'formula'],
                    ['clean']
                ]
            },
            theme: 'snow'
        })
    }
}
function blockUI(message = null) {
    $.blockUI({
        message:
            message ?? '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Please wait...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
        css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0'
        },
        overlayCSS: {
            opacity: 0.5
        }
    });
}
function unblockUI(message = null) {
    $.blockUI({
        message:
            message ?? '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Please wait...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
        timeout: 1,
        css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0'
        },
        overlayCSS: {
            opacity: 0.5
        }
    });
}

function blockDiv(place, message = null) {
    var section = $(place);
    section.block({
        message: message ?? '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div>',
        css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0'
        },
        overlayCSS: {
            opacity: 0.5
        }
    });
}

function unblockDiv(place) {
    var section = $(place);
    section.block({
        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div>',
        timeout: 1,
        css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0'
        },
        overlayCSS: {
            opacity: 0.5
        }
    });
}
$(document).on('change', '.status-switch', function () {
    const id = $(this).val();
    const checked = $(this).prop('checked');
    const url = $(this).data('route');
    const This = $(this);
    let block = ".card";
    if (url == undefined) {
        snb('error', 'Error', 'Define route first');
        return false;
    }
    if ($(this).data('block') !== undefined) {
        block = $(this).closest($(this).data('block'));
    }
    blockDiv(block);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    const status = (Number(checked)) ? 'active' : 'inactive';
    $.ajax({
        type: "PUT",
        url: url,
        data: {
            id: id,
            status: status,
        },
        success: function (response) {
            unblockDiv(block);
            console.log(response);
            snb('success', response.header ?? 'Success', response.message ?? 'Status Changed');
            if (response.table) {
                if ($.fn.DataTable) {
                    $('#' + response.table).DataTable().ajax.reload();
                }
            }

        },
        error: function (xhr, status, error) {
            $(This).prop('checked', !checked);
            unblockDiv(block);
            console.log(error);
            if (xhr.status == 422) {
                $.each(xhr.responseJSON.errors, function (key, item) {
                    snb('error', 'Error', item[0]);
                    console.log(item);
                });
            } else if (xhr.status == 500) {
                snb('error', 'Error', error);
            } else {
                snb('error', 'Error', error);
            }

        }
    });
});

function validate(form) {
    if (form[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        form.addClass('was-validated');
        return false;
    }
    form.addClass('was-validated');
    return true;
}

const reboundForm = async function ({ selector = null, data = null, type = "POST", route = null, reset = true, reload = false, successCallback = null, errorCallback = null, loader = null }) {

    if (selector == null && data == null) {
        snb('error', 'Error', 'Please set the selector or data');
        return false
    }
    if (route == null) {
        snb('error', 'Error', 'Please set the route');
        return false
    }

    if (selector !== null) {
        var form = $(selector)[0];
        var formData = new FormData(form);
    }
    if (data !== null) {
        var formData = new FormData();

        $.each(data, function (key, value) {
            formData.append(key, value);
        });

    }
    const btn = $(selector).find('button[type="submit"]');
    const btn_text = $(btn).text();
    $(btn).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    blockUI(loader);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        type: type,
        url: route,
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            $(btn).html(btn_text);
            console.log(response);
            if (selector !== null) {
                $(selector).removeClass('was-validated');
                if (reset) {
                    $(selector)[0].reset();
                    $(selector).trigger("reset");
                    $(`form#${$(selector).attr('id')} select, form input[type=checkbox]`).trigger("change");
                    $(selector).find('.custom-file-label').html('Choose file');
                }

                $(selector).closest('.modal').modal('hide');
            }
            unblockUI();
            if (type == "get" || type == "GET") { } else {
                snb((response.type) ? response.type : 'success', response.header, response.message);
                if ($.fn.DataTable) {
                    $('#' + response.table).DataTable().ajax.reload();
                }
            }


            if (reload || response.reload) {
                location.reload();
            }

            if (successCallback !== null) {
                successCallback.apply(null, arguments);
            }

            if (type == "get" || type == "GET") {
                return response;
            }
            return true
        },
        error: function (xhr, status, error) {
            unblockUI();
            $(btn).html(btn_text);
            if (xhr.status == 422) {
                $.each(xhr.responseJSON.errors, function (key, item) {
                    snb('error', 'Error', item[0]);
                    console.log(item);
                });
            } else if (xhr.status == 500) {
                snb('error', 'Error500', error);
                // console.error(xhr.responseJSON.errors);
                report(xhr.responseJSON);
            } else {
                report(xhr.responseJSON);
                snb('error', 'Error', error);
                // console.error(xhr.responseJSON.errors);
            }


            if (errorCallback !== null) {
                errorCallback.apply(null, arguments);
            }

            return false;
        }
    });



}


$(document).on('click', '.view-on-click', function () {
    try {
        Swal.fire({
            html: '<img class="s-image" src="' + $(this).attr('src') + '"  alt="image"/>',
            showCloseButton: true,
            showCancelButton: false,
            showConfirmButton: false,
            width: '800px',
        });
    } catch (error) {
        console.log(error);
        snb('warning', 'Warning', 'Import Swal library');
    }

});
$(document).on('click', '.view-modal-data', function () {
    const btn = $(this);
    const btn_text = $(btn).text();
    $(btn).attr('disabled', true).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="ml-25 align-middle">Loading...</span>`
    );
    const school = $(this).data('id');
    const route = $(this).data('route');
    const modal = $(this).data('modal-id');
    if (route.length == 0) {
        snb('error', 'Error', 'Route cant be empty');
        $(btn).attr('disabled', false).html(btn_text);
        return false;
    }
    if ($('.modal').length == 0) {
        snb('warning', 'Warning', 'There is no modal to show data.');
        $(btn).attr('disabled', false).html(btn_text);
        return false;

    } else if ($(`#${modal}`).length == 0) {
        snb('warning', 'Modal not found', `The modal with id "${modal}" was not found.`);
        $(btn).attr('disabled', false).html(btn_text);
        return false;
    }
    $.ajax({
        type: "GET",
        url: route,
        data: "",
        success: function (response) {
            // console.log(response);
            $(`#${modal} .modal-body`).html(response);
            $(`#${modal}`).modal('show');
            $(btn).attr('disabled', false).html(btn_text);
        },
        error: function (response) {
            snb('error', 'Error', 'There was an error while getting data.');
            $(btn).attr('disabled', false).html(btn_text);

            report(response.responseText);

            // console.log(response);
        }
    });

});
function report(error) {
    Swal.fire({
        title: 'An Error encountered',
        text: "You want to report this error to development team ?",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Yes, report it!',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            sendReport(error);
        }
    });
}


function sendReport(error) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    blockUI();
    $.ajax({
        type: "post",
        url: "http://127.0.0.1:8000/admin/miscellaneous/report-error",
        data: {
            error: error,
            from: location.href
        },
        success: function (response) {
            unblockUI();
            snb('success', 'Success', 'Report has been sent.');
            console.log(response);
        },
        error: function (response) {
            unblockUI();
            console.log(response);
            snb('error', 'Error',
                'There was an error while sending report. please contact the development team.');
            // console.log(response);
        }
    });
}



function initChart({ selector, categories, data, label = 'label' }) {
    const $salesLineChart = document.querySelector(selector);
    const salesLineChartOptions = {
        chart: {
            height: 240,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
            type: 'line',
            dropShadow: {
                enabled: true,
                top: 18,
                left: 2,
                blur: 5,
                opacity: 0.2
            },
            offsetX: -10
        },
        stroke: {
            curve: 'smooth',
            width: 4
        },
        grid: {
            borderColor: $strokeColor,
            padding: {
                top: -20,
                bottom: 5,
                left: 20
            }
        },
        legend: {
            show: false
        },
        colors: [$salesStrokeColor2],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                inverseColors: false,
                gradientToColors: [window.colors.solid.primary],
                shadeIntensity: 1,
                type: 'horizontal',
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100, 100, 100]
            }
        },
        markers: {
            size: 0,
            hover: {
                size: 5
            }
        },
        xaxis: {
            labels: {
                offsetY: 5,
                style: {
                    colors: $textMutedColor,
                    fontSize: '0.857rem'
                }
            },
            axisTicks: {
                show: false
            },
            categories: categories,
            type: 'datetime',
            axisBorder: {
                show: false
            },
            tickPlacement: 'on'
        },
        yaxis: {

            labels: {
                style: {
                    colors: $textMutedColor,
                    fontSize: '0.857rem'
                },
                formatter: function (val) {
                    return val > 999 ? (val / 1000).toFixed(1) + 'k' : val.toFixed(0);
                }
            }
        },
        tooltip: {
            x: {
                show: false
            }
        },
        series: [{
            name: label,
            data: data
        }]
    };
    salesLineChart = new ApexCharts($salesLineChart, salesLineChartOptions);
    salesLineChart.render();
}
function noCallback() {
    snb('error', 'Callback undefined', 'No callback function defined for edit action.');
}

// other functions
(() => {

    $(document).on('click', '[data-delete]', async function () {
        const route = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then(async function (result) {
            if (result.value) {
                await reboundForm({
                    data: '',
                    type: 'delete',
                    route: route,
                    loader: '<div class="delete"><span class="loader">Deleting</span></div>',
                    successCallback: () => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });


            }
        });
    });
    $(document).on('click', '[data-edit]', function () {
        const route = $(this).data('edit');
        const modal = $(this).data('modal');
        const callback = $(this).data('callback');

        const data = reboundForm({
            data: '',
            type: 'get',
            route: route,
            loader: '<div class="fetch"><span class="loader"></span></div>',
            successCallback: (data) => {
                if ((typeof window[callback]) == 'function') {
                    eval(callback)(data, modal);
                } else {
                    snb('error', 'Callback undefined', 'No callback function defined for edit action.');
                }
            }
        });

    });

    $(document).on('click', '[data-show-btn]', function () {
        const data = $(this).parent('.parent').find('[data-show-desc]').html();
        const modal = $(this).data('show-btn');
        $(`${modal} .modal-body`).html(data);
        $(modal).modal('show');

    });

    $(document).on('click', '[data-viewer-btn]', function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        $('#data-viewer-' + id).modal('show');
    });
})();