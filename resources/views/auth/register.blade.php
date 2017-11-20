@extends('baselayout.common_page_base')
@section ('content')
<form method="POST" action="/register">
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
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password">
    </div>
    <p>Password must be at least 8 characters and  Include a combination of text  & number &  punctuation mark(ex: ! , &)</p>
    <div>
        Confirm Password
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <button type="submit">Register</button>
    </div>

    <div>
        <button type="button">Signin with facebook</button>
    </div>
    <div>
        <button type="button">Signin with Twitter</button>
    </div>
    <div>
        <p>Already have an account? <a href="{{ url('/login') }}">Login</a></p>
    </div>
</form>
    @stop