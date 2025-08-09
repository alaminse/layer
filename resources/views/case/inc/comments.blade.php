@push('css_before')
    <style>
        .comments {
            display: flex;
            --comments-user: 80px;
            margin-top: 30px;
        }

        .comments:frist-child {
            margin-top: 20px;
        }

        .comments>* {
            max-width: 100%;
            flex: 0 0 auto;
        }

        .comments-profile {
            width: var(--comments-user);
            height: var(--comments-user);
            background-color: #f1f1f1;
            border-radius: 100%;
            overflow: hidden;
        }

        .comments-profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comments-content {
            width: calc(100% - var(--comments-user));
            padding-left: 20px;
        }

        .comments-content h5 {
            font-size: 20px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .comments-content a {
            color: #415094;
        }



        .more-comments {
            margin-top: 35px;
        }

        .comments-content li {
            display: inline-block;
        }

        .comments-content li a {
            color: #828BB2;
            text-decoration: underline
        }
        .dateTime {
            display: block;
            margin-bottom: 10px;
            color: #415094;
        }

        @media only screen and (max-width: 767px) {
            .comments {
                --comments-user: 60px;
            }

            .comments-content {
                padding-left: 15px;
            }

            .comments-content p:not(:last-child) {
                margin-bottom: 15px;
            }

            .comments .primary-btn {
                padding: 0px 10px;
            }

            .more-comments {
                margin-top: 25px;
            }
        }
    </style>
@endpush
<div class="col-12">
    <div class="student-meta-box mb-20">
        <div class="white-box student-details pt-2">

            <div class="single-meta">
                <div class="d-flex align-items-center">
                    <div class="name mr-1">
                        <h3>{{ __('case.Comment') }} :</h3>
                    </div>
                </div>
            </div>
            <div class="single-meta">
                {!! Form::open(['method' => 'POST', 'route' => 'comment.store', 'enctype' => 'multipart/form-data']) !!}
                <input type="hidden" name="case_id" value="{{ $model->id }}">
                <div class="">
                    <div class="primary_input">
                        {{ Form::textarea('comments', null, ['class' => 'primary_textarea summernote', 'placeholder' => __('case.Write Something...'), 'rows' => 5, 'data-parsley-errors-container' => '#comment_error', 'id' => 'comment']) }}
                        <span class="text-danger">{{ $errors->first('comments') }}</span>
                    </div>

                </div>
                <div class="pull-left mt-2 ml-2" id="addFile">
                    <button type="button" class="primary-btn small fix-gr-bg addFileBtn">
                        <i class="ti-plus"> </i>{{ __('case.Add File') }}
                    </button>

                </div>
                <div class="pull-left mt-2 ml-2 d-none" id="removeFile">
                    <button type="button" class="primary-btn small fix-gr-bg removeFileBtn">
                        <i class="ti-times"> </i>{{ __('case.Remove File') }}
                    </button>
                </div>
                <div class="attach-file-row d-none" id="browseFile">
                    <div class="attach-file-section d-flex align-items-center mb-2">
                        <div class="primary_input flex-grow-1">
                            <div class="primary_file_uploader">
                                <input class="primary-input" type="text" id="placeholderAttachMultipleFile"
                                    placeholder="{{ __('common.Browse file') }}" readonly>
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg"
                                        for="attach_file_multiple">{{ __('common.Browse') }} </label>
                                    <input type="file" multiple class="d-none" onchange="javascript:MultipleFileName()" name="file[]" id="attach_file_multiple">

                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="text-right mt-2">
                    <button class="primary_btn_large submit" type="submit"><i
                            class="ti-check"></i>{{ __('common.Submit') }}
                    </button>

                    <button class="primary_btn_large submitting" type="submit" disabled style="display: none;">
                        <i class="ti-check"></i>{{ __('common.Creating') . '...' }}
                    </button>

                </div>
                {!! Form::close() !!}
            </div>

            <div class="single-meta">
                @foreach ($model->comments as $comment)
                    <div class="comments">

                        <div class="comments-content">
                            <div>
                                <h5 class="d-flex align-items-center justify-content-between">
                                    {{ $comment->staff->name }}
                                    @if (auth()->user()->role_id == 1)
                                        <span style="cursor: pointer;"
                                            data-url="{{ route('comment.destroy', $comment->id) }}" id="delete_item"
                                            class="primary-btn small fix-gr-bg icon-only"><i class="ti-trash"></i></span>
                                    @endif

                                </h5>
                                <span class="dateTime">{{ getFormatedDate($comment->created_at) . ' id:' . $comment->staff_id }} </span>
                            </div>

                            <p class="{{ $comment->staff_id != auth()->id() && !$comment->read->read_at ? 'font-weight-bold' : '' }}">{!! $comment->comments !!}</p>
                            @if ($comment->files)
                                @foreach ($comment->files as $file)
                                    <div class="single-meta p-0">
                                        <div class="d-flex align-items-center">
                                            <div class="name btn-modal flex-grow-1  btn-modal"
                                                data-container="file_modal"
                                                data-href="{{ route('comment.file.show', $file->uuid) }}"
                                                style="cursor: pointer;">
                                                {{ $loop->index + 1 }}. {{ $file->user_filename }}
                                            </div>

                                            <div class="value mt-1">

                                                <span class="primary-btn small fix-gr-bg icon-only  btn-modal"
                                                    data-container="file_modal"
                                                    data-href="{{ route('comment.file.show', $file->uuid) }}"
                                                    style="cursor: pointer;"><i class="ti-eye"></i></span>
                                                @if (auth()->user()->role_id == 1 || $comment->staff_id == auth()->user()->id)
                                                    <span style="cursor: pointer;"
                                                        data-url="{{ route('comment.file.destroy', $file->uuid) }}"
                                                        id="delete_item"
                                                        class="primary-btn small fix-gr-bg icon-only"><i
                                                            class="ti-trash"></i></span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                @endforeach
                {{-- <div class="more-comments text-center">
                    <button type="button" class="primary-btn fix-gr-bg">See More</button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@push('js_before')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.addFileBtn', function() {
                $('#browseFile').removeClass('d-none');
                $('#addFile').addClass('d-none');
                $('#removeFile').removeClass('d-none');
            })
            $(document).on('click', '.removeFileBtn', function() {
                $('#browseFile').addClass('d-none');
                $('#addFile').removeClass('d-none');
                $('#removeFile').addClass('d-none');
                $('#attach_file_multiple').val('');
                document.getElementById('placeholderAttachMultipleFile').placeholder = "{{ __('common.Browse file') }}";

            })

            MultipleFileName = function() {
                var input = document.getElementById('attach_file_multiple');
                var output = document.getElementById('placeholderAttachMultipleFile');
                var children = "";
                for (var i = 0; i < input.files.length; ++i) {
                    children += input.files.item(i).name + ',';
                }
                document.getElementById('placeholderAttachMultipleFile').placeholder = children;
            }
        })
    </script>
@endpush
