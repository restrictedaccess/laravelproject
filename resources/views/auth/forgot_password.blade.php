@extends('baselayout.common_page_base')

@section('content')

	<div class="content">
		<div class="content__padded">
			<div class="profile_content">
				<h3 class="title_profile">Forgot your password?</h3>
				<p>Pegara will send password reset instructions to the email address associated with your account. </p>
				{!! Form::open(['method' => 'POST' , 'id'=>'form_profile', 'class'=>'input-group', 'url'=> URL::to('/forgot-password', array(), false) ]) !!}
				    <div class="input-row">
				        <label class="label__profile" for="email">Email</label>
				        <div class="input-control">
				          <input class="input__profile" id="email" type="text" name="email" value="{{ old('email') }}" required="">
				          <div class="error_message">{{ $errors->first('email') }}</div>
				        </div>
				    </div>
	        		<button id="btn-login" class="btn btn__regular" type="submit">Send Instructions</button>
    			{!! Form::close() !!}
    			<div class="notes">
    				Notes:<br>
					If you don’t get an  email from Pegara after a few minutes, please be sure to check your spam filter. The email will be coming from  do-not-noreply@brainsalvation.com.
    			</div>
    			<a class="btn btn__regular">Back</a>
			</div>
		</div>
	</div>
@stop