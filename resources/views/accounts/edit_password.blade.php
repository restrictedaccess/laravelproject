@extends('baselayout.common_page_base')

@section ('content')

@extends('baselayout.common_navigation')

<div class="content p-t-6">
  <div class="content__padded">
    <div class="profile_content">
      <h3 class="title_profile">Create your new password</h3>
      {!! Form::open(['method' => 'POST' , 'id'=>'form_password', 'class'=>'input-group user-profile-form', 'url'=> URL::to('', array(), false) ]) !!}
      <div class="input-row">
        <label class="label__profile" for="email">Email <span class="compulsory__status">*</span></label>
        <div class="input-control">
          <input class="input__profile" id="email" type="email" name="email">
        </div>
      </div>
      <div class="input-row">
        <label class="label__profile" for="password">New Password <span class="compulsory__status">*</span></label>
        <div class="input-control">
          <input class="input__profile" id="password" type="password" name="password">
          <div class="error_message">{{ $errors->first('password') }}</div>
        </div>
        <p class="hint"> Password must be at least 8 characters and  Include a combination of text  & number &  punctuation mark(ex: ! , &) </p>
      </div>
      <div class="input-row">
        <label class="label__profile" for="confirm_password">Confirm Password <span class="compulsory__status">*</span></label>
        <div class="input-control">
          <input class="input__profile" id="confirm_password" type="password" name="confirm_password">
          <div class="error_message">{{ $errors->first('confirm_password') }}</div>
        </div>
      </div>
      <hr class="m-y-1">
      <div class="check__score">
        <button id="reset-password-btn" class="btn btn__regular" type="submit">Reset Password</button>
        <button id="back-btn" class="btn btn__regular" type="submit">Back</button>
      </div>
    </br>
    {!! Form::close() !!}
  </div>
</div>
</div>
@stop
