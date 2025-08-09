<table class="table Crm_table_active3">
    <thead>
    <tr>

        <th scope="col">{{ __('common.SL') }}</th>
        <th>{{ __('case.Case') }}</th>
        <th>{{ __('case.Client') }}</th>
        <th>{{ __('case.Details') }}</th>
        <th class="noprint">{{ __('common.Actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($models as $model)
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>
            <b>{{ __('case.Case No.') }}: </b>
            {{ $model->case_category ? $model->case_category->name : '' }}
            /{{ $model->case_no }} <br>
            @if ($model->case_category_id)
                <a
                    href="{{ route('category.case.show', $model->case_category_id) }}"><b>{{ __('case.Category') }}
                        :
                    </b>
                    {{ $model->case_category ? $model->case_category->name : '' }}
                </a>
            @else
                <b>{{ __('case.Category') }}: </b>
                {{ $model->case_category ? $model->case_category->name : '' }}
            @endif
            <br>
            <a href="{{ route('case.show', $model->id) }}"><b>{{ __('case.Title') }}
                    : </b>{{ $model->title }}
            </a>
            <br>
            <b>{{ __('case.Next Hearing Date') }}
                : </b> {{ formatDate($model->hearing_date) }} <br>
            <b>{{ __('case.Filing Date') }}
                : </b> {{ formatDate($model->filling_date) }}
        </td>
        <td>
            @if ($model->layout == 1)
                @if ($model->client == 'Plaintiff' and $model->plaintiff_client)
                    <a
                        href="{{ route('client.show', $model->plaintiff_client ? $model->plaintiff_client->id : $model->clientLayout2->id) }}"><b>{{ __('case.Name') }}</b>:
                        {{ $model->plaintiff_client->name }}</a> <br>
                    <b>{{ __('case.Mobile') }}
                        : </b> {{ $model->plaintiff_client->mobile }} <br>
                    <b>{{ __('case.Email') }}
                        : </b> {{ $model->plaintiff_client->email }} <br>
                    <b>{{ __('case.Address') }}
                        : </b> {{ $model->plaintiff_client->address }}
                    {{ $model->plaintiff_client->city ? ', ' . $model->plaintiff_client->city->name : '' }}
                    {{ $model->plaintiff_client->state ? ', ' . $model->plaintiff_client->state->name : '' }}
                @elseif($model->client == 'Opposite' and $model->opposite_client)
                    <a
                        href="{{ route('client.show', $model->opposite_client->id) }}"><b>{{ __('case.Name') }}</b>:
                        {{ $model->opposite_client->name }}</a> <br>
                    <b>{{ __('case.Mobile') }}
                        : </b> {{ $model->opposite_client->mobile }} <br>
                    <b>{{ __('case.Email') }}: </b>
                    {{ $model->opposite_client->email }}
                    <br>
                    <b>{{ __('case.Address') }}
                        : </b> {{ $model->opposite_client->address }}
                    {{ $model->opposite_client->city ? ', ' . $model->opposite_client->city->name : '' }}
                    {{ $model->opposite_client->state ? ', ' . $model->opposite_client->state->name : '' }}
                @endif
            @elseif($model->layout == 2)
                <a href="{{ route('client.show', $model->clientLayout2->id) }}"><b>{{ __('case.Name') }}</b>:
                    {{ $model->clientLayout2->name }}</a> <br>
                <b>{{ __('case.Mobile') }}
                    : </b> {{ $model->clientLayout2->mobile }} <br>
                <b>{{ __('case.Email') }}
                    : </b> {{ $model->clientLayout2->email }} <br>
                <b>{{ __('case.Address') }}
                    : </b> {{ $model->clientLayout2->address }}
                {{ $model->clientLayout2->city ? ', ' . $model->clientLayout2->city->name : '' }}
                {{ $model->clientLayout2->state ? ', ' . $model->clientLayout2->state->name : '' }}
            @endif
        </td>
        <td>
            @if ($model->court)
                <a href="{{ route('master.court.show', $model->court_id) }}"><b>{{ __('case.Court') }}</b>:
                    {{ $model->court->name }} </a><br>
                <a
                    href="{{ route('category.court.show', $model->court_category_id) }}">
                    <b>{{ __('case.Category') }}</b>:
                    {{ $model->court->court_category ? $model->court->court_category->name : '' }}
                </a><br>
                <b>{{ __('case.Room No') }}: </b>
                {{ $model->court->room_number }}
                <br>
                <b>{{ __('case.Address') }}: </b>
                {{ $model->court->location }}
                {{ $model->court->city ? ', ' . $model->court->city->name : '' }}
                {{ $model->court->state ? ', ' . $model->court->state->name : '' }}
            @endif
        </td>


        <td>


            <div class="dropdown CRM_dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    {{ __('common.Select') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right"
                    aria-labelledby="dropdownMenu2">
                    <a href="{{ route('case.show', $model->id) }}"
                        class="dropdown-item"><i class="icon-file-eye"></i>
                        {{ __('common.View') }}</a>
                    <a href="#" class="dropdown-item assignLawyer" data-case_id="{{ $model->id }}" data-modal-size="modal-md">
                            {{ __('case.Assign Staff/Lawyer') }}</a>
                    @if (!$model->judgement)
                        @if (permissionCheck('case.edit'))
                            <a href="{{ route('case.edit', $model->id) }}"
                                class="dropdown-item"><i
                                    class="icon-pencil mr-2"></i>{{ __('common.Edit') }}
                            </a>
                        @endif
                        @if (permissionCheck('date.store'))
                            <a href="{{ route('date.create', ['case' => $model->id]) }}"
                                class="dropdown-item"><i
                                    class="icon-calendar3 mr-2"></i>{{ __('case.New Date') }}
                            </a>
                        @endif
                        @if (permissionCheck('putlist.store'))
                            <a href="{{ route('putlist.create', ['case' => $model->id]) }}"
                                class="dropdown-item"><i
                                    class="icon-calendar3 mr-2"></i>{{ __('case.New Put Up Date') }}
                            </a>
                        @endif
                        @if (permissionCheck('lobbying.store'))
                            <a href="{{ route('lobbying.create', ['case' => $model->id]) }}"
                                class="dropdown-item"><i
                                    class="icon-calendar3 mr-2"></i>{{ __('case.New Lobbying Date') }}
                            </a>
                        @endif
                        @if (permissionCheck('judgement.store'))
                            <a href="{{ route('judgement.create', ['case' => $model->id]) }}"
                                class="dropdown-item"><i
                                    class="icon-calendar3 mr-2"></i>{{ __('case.New Judgement Date') }}
                            </a>
                        @endif
                    @endif
                    @if (permissionCheck('case.destroy'))
                        <span id="delete_item" data-id="{{ $model->id }}"
                            data-url="{{ route('case.destroy', $model->id) }}"
                            class="dropdown-item"><i class="icon-trash"></i>
                            {{ __('common.Delete') }}
                        </span>
                    @endif

                </div>
            </div>


        </td>
    </tr>
    @endforeach

    </tbody>
</table>
