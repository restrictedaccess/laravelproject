@extends('baselayout.common_page_base')
@section ('content')
<form method="POST">
    {!! csrf_field() !!}
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <p>We’ve sent an identification code to {{ $user->email }}. Please enter that code below to continue (you may need to check your spam folder if you don’t see the email). We also need the password you entered in the Sign Up form.</p>
    </div>

    <div>
        <label>ID Code</label>
        <input type="text" name="id_code" value="{{ old('id_code') }}">
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" id="password">
    </div>

    <div>
        <button type="submit">Next</button>
    </div>
</form>

@stop