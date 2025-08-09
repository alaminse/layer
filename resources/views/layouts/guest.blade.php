<!doctype html>
<html dir="{{ rtl() ? 'rtl' : 'ltr' }}" class="{{ rtl() ? 'rtl' : '' }}" lang="{{ session()->get('locale', Config::get('app.locale')) }}">

<head>
    <meta charset="utf-8">
    <meta name="_token" content="{!! csrf_token() !!}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <link rel="icon" href="{{ asset('public/uploads/settings/favicon.png') }}" type="image/png" />

    <style>
                :root {
                    --base_font : {{ in_array(session()->get('locale', Config::get('app.locale')), ['ar']) ?  'Cairo,' : ''}}Poppins, sans-serif;
                    @foreach($color_theme->colors as $color)
--{{ $color->name}}: {{ $color->pivot->value }};
                    @if(in_array($color->name, ['success', 'danger']))
--{{ $color->name}}_with_opacity: {{ $color->pivot->value }}23;
                @endif
            @endforeach
        
}
            </style>

    <title>
        {{ isset($title)? $title .' | ' .config('configs.site_title'): config('configs.site_title') }}
    </title>

    @if (rtl())
        <link rel="stylesheet" href="{{ asset('public/backEnd/css/rtl/bootstrap.min.css') }}" />
    @else
        <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/bootstrap.css" />
    @endif
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/themify-icons.css" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/flaticon.css" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ asset('public/login-asset/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/login-asset/css/login.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/toastr.min.css" />
    <link rel="stylesheet" href="{{ asset('public/css/parsley.css') }}"/>

    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/css/nice-select.css" />
    <link rel="stylesheet" href="{{ asset('public/backEnd/') }}/vendors/js/select2/select2.css" />

    <link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/style.css" />
    @stack('css')

</head>


<body class="login-resistration-area">
    <input type="hidden" id="url" value="{{ url('/') }}">
    <!-- main-login-area-start -->
    <div class="main-login-area login-res-v2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-xl-7 offset-xl-5">

                    @yield('content')


                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('public/backEnd/vendors/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ route('assets.lang.js') }}"></script>
<script src="{{ asset('public/backEnd/vendors/js/loadah.min.js') }}"></script>
<script src="{{ asset('public/backEnd/') }}/vendors/js/nice-select.min.js"></script>
<script>
    function trans(string, args) {
        let value = _.get(window.jsi18n, string);

        _.eachRight(args, (paramVal, paramKey) => {
            value = paramVal.replace(`:${paramKey}`, value);
        });

        if (typeof value == 'undefined') {
            return string;
        }

        return value;
    }
</script>
<script src="{{ asset('public/js/parsley.min.js') }}"></script>
<script src="{{ asset('/backEnd/js/parsley_i18n/' . session()->get('locale', Config::get('app.locale')) . '.js') }}">
</script>
<script src="{{ asset('public/backEnd/vendors/js/toastr.min.js') }}"></script>
{!! Toastr::message() !!}
<script>
    // submit btn protect
    $(".primary_select_regi").niceSelect();
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        _componentAjaxChildLoad('#content_form', '#country_id', '#state_id', 'state')
        _componentAjaxChildLoad('#content_form', '#state_id', '#city_id', 'city')


        function _componentAjaxChildLoad(form_id = '#content_form', parent_id = '#country_id', child_id =
            '#state_id', module = 'state') {

            $(document).on('change', form_id + ' ' + parent_id, function(e) {
                var content_id = form_id + ' ' + child_id;
                var value = $(this).val();
                var url = $('#url').val();
                $(content_id + '>option').remove();
                var child = $(form_id + ' select' + child_id);
                child.append(
                    $('<option>', {
                        value: '',
                        text: trans('js.Select ' + ucword(module))
                    })
                );
                $.ajax({
                        url: url + '/select/' + module,
                        type: 'post',
                        data: {
                            value: value
                        },
                        dataType: 'json'
                    })
                    .done(function(data) {
                        $.each(data, function(i, v) {
                            child.append(
                                $('<option>', {
                                    value: v.id,
                                    text: v.name
                                })
                            );
                        })
                        child.trigger('change');
                        child.niceSelect('update');
                    })
                    .fail(function(data) {
                        toastr.error(trans('js.Something is not right'), trans('js.Error'))
                    });
            });
        };

        function ajax_error(data) {

            if (data.status === 404) {
                toastr.error(trans('js.What you are looking is not found'), trans('js.Opps'));
                return;
            } else if (data.status === 500) {
                toastr.error(trans(
                    'js.Something went wrong. If you are seeing this message multiple times, please contact Spondon IT authors.'
                ), trans('js.Opps'));
                return;
            } else if (data.status === 200) {
                toastr.error(trans('js.Something is not right'), trans('js.Error'));
                return;
            }
            let jsonValue = $.parseJSON(data.responseText);
            let errors = jsonValue.errors;
            if (errors) {
                let i = 0;
                $.each(errors, function(key, value) {
                    let first_item = Object.keys(errors)[i];
                    let error_el_id = $('#' + first_item);
                    if (error_el_id.length > 0) {
                        error_el_id.parsley().addError('ajax', {
                            message: value,
                            updateClass: true
                        });
                    }

                    toastr.error(value, trans('js.Validation Error'));
                    i++;
                });
            } else {
                toastr.error(jsonValue.message, trans('js.Opps'));
            }
        }

        function _formValidation(form_id = 'content_form', modal = false, modal_id = 'content_modal',
            ajax_table = null) {

            const form = $('#' + form_id);

            if (!form.length) {
                return;
            }

            form.parsley().on('field:validated', function() {
                $('.parsley-ajax').remove();
                const ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            });
            form.on('submit', function(e) {
                e.preventDefault();
                $('.parsley-ajax').remove();
                form.find('.submit').hide();
                form.find('.submitting').show();
                const submit_url = form.attr('action');
                const method = form.attr('method');
                //Start Ajax
                const formData = new FormData(form[0]);
                $.ajax({
                    url: submit_url,
                    type: method,
                    data: formData,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        form.trigger("reset");
                        form.find("input:text:visible:first").focus();
                        toastr.success(data.message, trans('js.Success'));
                        if (modal) {
                            $("." + modal_id).modal('hide');
                        }
                        if (ajax_table) {
                            ajax_table.ajax.reload();
                        }

                        if (data.goto) {
                            window.location.href = data.goto;
                        }

                        form.find('.submit').show();
                        form.find('.submitting').hide();

                    },
                    error: function(data) {
                        ajax_error(data);
                        form.find('.submit').show();
                        form.find('.submitting').hide();
                    }
                });
            });
        }

        function ucword(value) {

            if (!value)
                return;

            return value.toLowerCase().replace(/\b[a-z]/g, function(value) {
                return value.toUpperCase();
            });
        }

        _formValidation();
        _formValidation('content_form1');
        _formValidation('content_form2');
        _formValidation('content_form3');



    });
    var fileInput = document.getElementById('attach_file');
    if (fileInput) {
        //alert("staffs photo");
        fileInput.addEventListener('change', showFileName);

        function showFileName(event) {
            "use strict";
            var fileInput = event.srcElement;
            var fileName = fileInput.files[0].name;
            document.getElementById('placeholderAttachFile').placeholder = fileName;
        }
    }
    var index = 0;
    $(document).on('click', '#file_add', function() {
        index = $('.attach-file-row').length;
        addNewFileAddItem(index)
    });
    $(document).on('change', '.file-upload-multi', function(e) {
        let fileName = e.target.files[0].name;        
        $(this).parent().parent().find('#placeholderStaffsName').attr('placeholder', fileName);
    });
    $(document).on('click', '.case-attach', function() {
        let id = $(this).data('id');
        $('#apprendDiv_'+id).remove();
    });

    function addNewFileAddItem(index) {
        "use strict";

        var attachFile = `<div class="row mt-3 attach-file-row" id="apprendDiv_${index}">
                    <div class="col-5">
                        {!! Form::text('title[]', null, ['autofocus' => true, 'class' => '', 'id' => 'name', 'placeholder' => __('auth.Enter Title')]) !!}
                    </div>
                    <div class="col-5">
                        <div class="primary_input flex-grow-1">
                            <div class="primary_file_uploader">
                                <input class="primary-input" type="text" id="placeholderStaffsName"
                                    placeholder="{{ __('common.Browse file') }}" readonly>
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg" for="attach_file_${index}">{{ __('common.Browse') }} </label>
                                    <input type="file" class="d-none file-upload-multi" name="file[]" id="attach_file_${index}">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 pull-right">
                        <button style="cursor:pointer;" class="btn primary-btn small fix-gr-bg icon-only case-attach" type="button" data-id="${index}"> <i class="ti-trash m-0"></i> </button>
                    </div>                    
                </div> `;

        $('.appendDiv').append(attachFile);
    }
</script>
@stack('script')
</body>
</html>
