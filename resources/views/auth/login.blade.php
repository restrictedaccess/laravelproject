@extends('baselayout.common_page_base')
@section('content')
	<div class="content">
		<div class="content__padded">
			<div class="profile_content">
				<h3 class="title_profile">Login</h3>
				{!! Form::open(['method' => 'POST' , 'id'=>'form_profile', 'class'=>'input-group', 'url'=> URL::to('/login', array(), false) ]) !!}
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
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
				        <input class="input__profile" id="password" type="password" name="password" required="">
				        	<div class="error_message">{{ $errors->first('password') }}</div>
				        </div>
				    </div>
	        		<button id="btn-login" class="btn btn__regular" type="submit">Login</button>
    			{!! Form::close() !!}
        		<a href="">Forgot your password?</a>
        		<p>	
        			<a href="">or</a>
        		</p>
        		<div class="social__media">
        			<button id="btn-fb-login" class="btn" type="submit">Sign in with Facebook</button>
        			<button id="btn-tweet-login" class="btn" type="submit">Sign in with Twitter</button>
        		</div>
        		<p>Don't have an account? <a href="/sign-up">Sign Up</a></p>
			</div>
		</div>
	</div>
>>>>>>> 90ef571f9de31945bdc5d363688b1ab7970b8c39
@stop