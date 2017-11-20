@extends('baselayout.common_page_base')

@section ('content')

  @extends('baselayout.common_navigation')

<div class="content p-t-6">
  <div class="content__padded">
    <div class="profile_content">
      <h3 class="title_profile">Your profile has been saved</h3>
      {!! Form::open(['method' => 'POST' , 'id'=>'form_profile', 'class'=>'input-group user-profile-form', 'url'=> URL::to('', array(), false) ]) !!}
      <div class="input-row">
        <label class="label__profile" for="first_name">First Name <span class="compulsory__status">*</span></label>
        <div class="input-control">
          <input class="input__profile js-answer-key" id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required="">
          <div class="error_message">{{ $errors->first('first_name') }}</div>
        </div>
      </div>
      <div class="input-row">
        <label class="label__profile" for="last_name">Last Name </label>
        <div class="input-control">
          <input class="input__profile" id="last_name" type="text" name="last_name" value="{{ old('last_name') }}">
          <div class="error_message">{{ $errors->first('last_name') }}</div>
        </div>
      </div>
      <div class="input-row">
        <label class="label__profile" for="email">Email <span class="compulsory__status">*</span></label>
        <div class="input-control">
          <input class="input__profile js-answer-key" id="email" type="email" name="email" value="{{ old('email') }}">
          <div class="error_message">{{ $errors->first('email') }}</div>
        </div>
      </div>
      <div class="input-row">
        <label class="label__profile" for="password">Password <span class="compulsory__status">*</span></label>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-lg-10">
            <div class="error_message">{{ $errors->first('password') }}</div>
            <div class="input-control">
              <input class="input__profile js-answer-key" id="password" type="password" name="password" value="{{ old('password') }}">
            </div>
          </div>
          <div class="col-lg-2">
            <a href="#" class="btn btn-secondary dis-block">edit</a>
          </div>
        </div>

      </div>
      <div class="input-row">
        <label class="label__profile" for="telephone">Mobile Phone </label>
        <div class="input-control">
          <input class="input__profile" id="telephone" type="tel" name="mobile_no" value="{{ old('mobile_no') }}">
          <div class="error_message">{{ $errors->first('mobile_no') }}</div>
        </div>
        <p>(Best contact number)</p>
      </div>
      <div class="input-row">
        <label class="label__profile" for="zip_code">Zip Code/ Postal Code  <span id="zip_cond_req" class="compulsory__status">@if(old('out_of_us') == null) * @endif</span> </label>
        <div class="input-control">
          <input class="input__profile" id="zip_code" type="tel" name="zip_code" value="{{ old('zip_code') }}">
          <div class="error_message">{{ $errors->first('zip_code') }}</div>
        </div>
        <hr class="m-t-1 m-b-0">
        <div class="checkbox__styled distance_pad">
          <input type="checkbox" class="checkbox__styled__input" id="checkbox-1" name="out_of_us" value="1" @if(old('out_of_us') == "1") checked="" @endif>
          <label class="checkbox__styled__label" for="checkbox-1">Out of United States</label>
        </div>
      </div>
      <hr class="m-t-0 m-b-1">
      <div class="input-row">
        <label class="label__profile" for="birthday">Date of Birth <span class="compulsory__status">*</span></label>
        <div class="input-control ml108">
          <input class="input__profile js-answer-key" id="birthday" type="date" name="birthday" value="{{ old('birthday') }}" placeholder="yyyy/mm/dd">
          <div class="dropdown_day">
            <i class="icons_arrow_down">&nbsp;</i>
          </div>
          <div class="error_message">{{ $errors->first('birthday') }}</div>
        </div>
      </div>
      <hr class="m-y-1">
      <div class="input-row placement-row">
        <label class="label__profile pt18" for="gender">Gender <span class="compulsory__status">*</span></label>
        <div class="input-control ml77">
          <div class="radio__circle measure__circle pro0">
            <input type="radio" class="radio__circle__input" id="female" name="gender" value="1" @if(old('gender') == "1" || old('gender') == null) checked="" @endif>
            <label class="radio__circle__inner" for="female">Female</label>
          </div>
          <div class="radio__circle measure__circle">
            <input type="radio" class="radio__circle__input" id="male" name="gender" value="2" @if(old('gender') == "2") checked="" @endif>
            <label class="radio__circle__inner" for="male">Male</label>
          </div>
          <div class="error_message">{{ $errors->first('gender') }}</div>
        </div>
      </div>
      <hr class="m-y-1">
      <div class="input-row placement-row overflow-visible">
        <label class="label__profile pt22" for="height">Height <span class="compulsory__status">*</span></label>
        <div class="input-control ml77">
          <span id="label-ft" class="height-unit-label">ft</span>
          <span id="label-inc" class="height-unit-label">in</span>
          <div class="cases_value mt17">
            <input class="input__profile js-answer-key" id="height" type="number" name="height" placeholder="ft" value="{{old('height')}}">

            <input class="input__profile js-answer-key" id="height_inches" type="number" name="height_inches" placeholder="in" value="{{old('height_inches')}}">

            <div class="error_message">{{ $errors->first('height') }}</div>
          </div>
          <div class="radio__circle measure__circle pr0">
            <input type="radio" class="radio__circle__input js-answer-key" id="cm" name="height_unit" value="1" @if(old('height_unit') == "1") checked="" @endif data-required="true">
            <label class="radio__circle__inner" for="cm">cm</label>
          </div>
          <div class="radio__circle measure__circle">
            <input type="radio" class="radio__circle__input js-answer-key" id="inches" name="height_unit" value="0"  @if(old('height_unit') != "1") checked="" @endif data-required="true">
            <label class="radio__circle__inner" for="inches">feet</label>
          </div>
          <div class="error_message">{{ $errors->first('height_unit') }}</div>
        </div>
      </div>
      <hr class="m-y-1">
      <div class="input-row placement-row">
        <label class="label__profile pt19" for="weight">Weight <span class="compulsory__status">*</span></label>
        <div class="input-control ml77">
          <div class="cases_value mt16">
            <input class="input__profile js-answer-key" id="weight" type="number" name="weight" placeholder="lbs" value="{{old('weight')}}">
            <div class="error_message">{{ $errors->first('weight') }}</div>
          </div>
          <div class="radio__circle measure__circle pr0">
            <input type="radio" class="radio__circle__input js-answer-key" id="kg" name="weight_unit" value="1" @if(old('weight_unit') == "1") checked="" @endif data-required="true">
            <label class="radio__circle__inner" for="kg">kg</label>
          </div>
          <div class="radio__circle measure__circle">
            <input type="radio" class="radio__circle__input js-answer-key" id="lbs" name="weight_unit" value="0" @if(old('weight_unit') != "1") checked="" @endif data-required="true">
            <label class="radio__circle__inner" for="lbs">lbs</label>
          </div>
          <div class="error_message">{{ $errors->first('weight_unit') }}</div>
        </div>
      </div>
      <hr class="m-y-1">
      <div class="input-row">
        <div class="checkbox__styled p0 mt15">
          <input type="checkbox" class="checkbox__styled__input" id="checkbox-2" name="news_letter_flag" value="yes"  checked="">
          <label class="checkbox__styled__label" for="checkbox-2">Include me in the brain health email newsletters from Pegara and Medical Care Corporation. </label>
        </div>
      </div>
      <hr class="m-y-1">
      <div class="check__score">
        <button id="save-btn" class="btn btn__regular" type="submit">Home</button>
      </div>
    </br>
    {!! Form::close() !!}
  </div>
</div>
</div>
@stop
