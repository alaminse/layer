@push('css_before')
    <style>
        .modal-content .modal-header .close {
            color: #7c32ff;
        }
        .modal-content .modal-body {
            background-image:none;
        }

    </style>
@endpush
<div class="row mt-40">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="main-title">
                    <h3 class="mb-20">{{ __('common.Calendar') }}</h3>
                </div>
            </div>
        </div>
        <div class="white-box">
            <div class='common-calendar'>
            </div>
        </div>
    </div>

</div>
<div id="fullCalModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalTitle" class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span> <span class="sr-only">@lang('common.close')</span>
                </button>
            </div>
            <div class="modal-body text-center">

                <div id="modalBody">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.Close')</button>
            </div>
        </div>
    </div>
</div>
@push('admin.scripts')
    <script type="text/javascript" src="{{ asset('public/backEnd/vendors/js/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('public/backEnd/vendors/js/fullcallendar-locale-all.js') }}"></script>
    <script>
        if ($('.common-calendar').length) {
            $('.common-calendar').fullCalendar({
                locale: LANG,
                rtl: RTL,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventClick: function(event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody').html(event.description);
                    $('#fullCalModal').modal();
                    return false;
                },
                height: 650,
                events: <?php echo json_encode($calendar_events); ?>,
            });
        }
    </script>
@endpush
