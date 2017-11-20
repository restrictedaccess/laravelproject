@extends('baselayout.common_page_base')

@section('content')

	<div class="content">
		<div class="content__padded">
			<div class="profile_content">
				@if(isset($condition['test-complete']))
					<h3 class="title_profile">Finished! Congratulations!</h3>
					<p>We’ll show your Brain Health score in just a moment. But first, we need you to create an account with us so we can store your results and offer you important tips for your brain health. We’ll email you a verification message when you’re done.</p>
				@else
					<h3 class="title_profile">Sign Up</h3>
				@endif
				{!! Form::open(['method' => 'POST' , 'id'=>'form_profile', 'class'=>'input-group', 'url'=> URL::to('/login', array(), false) ]) !!}
				    <div class="input-row">
				        <label class="label__profile" for="email">Email</label>
				        <div class="input-control">
				          <input class="input__profile" id="email" type="text" name="email" value="{{ old('email') }}" required="">
				          <div class="error_message">{{ $errors->first('email') }}</div>
				        </div>
				    </div>
				    <div class="input-row">
				        <label class="label__profile" for="password">Password</label>
				        <div class="input-control">
				        <input class="input__profile" id="password" type="password" name="password" value="{{ old('password') }}" required="">
				        	<div class="error_message">{{ $errors->first('password') }}</div>
				        </div>
				    </div>
				    <div class="input-row">
				        <label class="label__profile" for="confirm_password">Confirm Password</label>
				        <div class="input-control">
				        <input class="input__profile" id="confirm_password" type="password" name="confirm_password"required>
				        	<div class="error_message">{{ $errors->first('confirm_password') }}</div>
				        </div>
				    </div>
	        		<button id="btn-login" class="btn btn__regular" type="submit">Sign up</button>
    			{!! Form::close() !!}
    			<p>	
        			<a href="">or</a>
        		</p>
        		<div class="social__media">
        			<button id="btn-fb-login" class="btn" type="submit">Sign in with Facebook</button>
        			<button id="btn-tweet-login" class="btn" type="submit">Sign in with Twitter</button>
        		</div>
        		<p>Already have an account? <a href="/login">Login</a></p>
			</div>
		</div>
	</div>
@stop