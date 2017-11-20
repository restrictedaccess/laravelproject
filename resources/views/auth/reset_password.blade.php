@extends('baselayout.common_page_base')

@section('content')

	<div class="content">
		<div class="content__padded">
			<div class="profile_content">
				@if(isset($condition['forgot_password']))
					<h3 class="title_profile">Forgot your password?</h3>
					<p>We’ve sent an identification code to jane@pegara.com. Please enter that code below to continue (you may need to check your spam folder if you don’t see the email). Also, to verify your identity, we need the postal code you entered in your profile.</p>
				@elseif(isset($condition['incorrect_id']))
					<h3 class="title_profile">Incorrect ID code</h3>
					<p>Sorry. That ID code doesn’t match the information we have for jane@pegara.com. Please try again. </p>
				@else
					<h3 class="title_profile">Verify your email address</h3>
					<p>We’ve sent an identification code to jane@pegara.com. Please enter that code below to continue (you may need to check your spam folder if you don’t see the email). We also need the password you entered in the Sign Up form.</p>
				@endif

				{!! Form::open(['method' => 'POST' , 'id'=>'form_profile', 'class'=>'input-group', 'url'=> URL::to('/forgot-password', array(), false) ]) !!}
				    <div class="input-row">
				        <label class="label__profile" for="id_code">ID Code</label>
				        <div class="input-control">
				          <input class="input__profile" id="id_code" type="text" name="id_code" value="{{ old('id_code') }}" required="">
				          <div class="error_message">{{ $errors->first('id_code') }}</div>
				        </div>
				    </div>
				    <div class="input-row">
				        <label class="label__profile" for="password">Password</label>
				        <div class="input-control">
				        <input class="input__profile" id="password" type="password" name="password" required="">
				        	<div class="error_message">{{ $errors->first('password') }}</div>
				        </div>
				    </div>
	        		<button class="btn btn__regular" type="submit">Next</button>
    			{!! Form::close() !!}

    			@if(isset($condition['forgot_password']))
    				<a class="btn btn__regular">Back</a>
    			@endif
			</div>
		</div>
	</div>
@stop