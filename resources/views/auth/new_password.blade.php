@extends('baselayout.common_page_base')

@section('content')

	<div class="content">
		<div class="content__padded">
			<div class="profile_content">
				<h3 class="title_profile">Create your new password</h3>
				{!! Form::open(['method' => 'POST' , 'id'=>'form_profile', 'class'=>'input-group', 'url'=> URL::to('', array(), false) ]) !!}
					<div class="form-group">
				        <label class="label__profile" for="email">Email</label>
			        	<label class="" for="email">xxxx</label>
				    </div>
				    <div class="form-group">
				        <label class="label__profile" for="password">Password</label>
				        <div class="input-control">
				        	<input class="input__profile" id="password" type="password" name="password" required="">
				        	<div class="error_message">{{ $errors->first('password') }}</div>
				        </div>
				        <div class="note">Password must be at least 8 characters and  Include a combination of text  & number &  punctuation mark(ex: ! , &)</div>
				    </div>
				    <div class="form-group">
				        <label class="label__profile" for="password">Confirm New Password</label>
				        <div class="input-control">
				        	<input class="input__profile" id="password" type="password" name="password" required="">
				        	<div class="error_message">{{ $errors->first('password') }}</div>
				        </div>
				    </div>
	        		<button id="btn-reset-pwd" class="btn btn__regular" type="submit">Reset Password</button>
    			{!! Form::close() !!}
        		<a class="btn btn__regular">Back</a>
			</div>
		</div>
	</div>
@stop