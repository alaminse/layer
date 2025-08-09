<div class="General_system_wrap_area d-block">
    <div class="single_system_wrap">
        {!! Form::open(['url' => route('config.update'), 'method' => 'post', 'id' => 'update_layout_setting', 'files' =>true ]) !!}
        @csrf
        <div class="row">
            <div class="col-6">
                <label class="primary_checkbox d-flex mr-12">
                    <input type="radio" class="complete_order0 PetRes" id="complete_order0"
                        name="case_layout" value="1" {{ getConfigValueByKey($config,'case_layout')==1?'checked':'' }}>
                    <span class="checkmark mr-2"></span> {{ __('case.Layout 01') }}
                </label> <br>
                <strong>Feature</strong> <br>
                <p># Single plaintiff and Accuesed</p>
                <p># On Behalf Of/Client Category</p>
                <img src="{{ asset('public/backEnd/img/case/case_layout_01.png') }}" class="img-fluid" alt="">
            </div>
            <div class="col-6">
                <label class="primary_checkbox d-flex mr-12">
                    <input type="radio" class="complete_order0 PetRes" id="complete_order0"
                        name="case_layout" value="2" {{ getConfigValueByKey($config,'case_layout')==2?'checked':'' }}>
                    <span class="checkmark mr-2"></span> {{ __('case.Layout 02') }}
                </label> <br>
                <strong>Feature</strong> <br>
                <p># Multiple Respondent/Petitioner.</p> 
                <p># Add Title.</p> 
                <p># Case Assign to Staff</p> 
                <img src="{{ asset('public/backEnd/img/case/case_layout_02.png') }}" class="img-fluid" alt="">
            </div>
        </div>
        <p class="color-red"> note: If You change layout runing application some information(as like multiple client) could be missing </p>
        
        <div class="submit_btn text-center mt-4">
            <button class="primary_btn_large submit" type="submit"><i class="ti-check"></i>{{ __('common.Save') }}
            </button>
    
            <button class="primary_btn_large submitting" type="submit" disabled style="display: none;"><i class="ti-check"></i>{{ __('common.Saving') }}
            </button>
    
        </div>
        {!! Form::close() !!}
    </div>

</div>