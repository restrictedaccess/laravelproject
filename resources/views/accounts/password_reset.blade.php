@extends('baselayout.common_page_base')

@section ('content')

  @extends('baselayout.common_navigation')

<div class="content p-t-6">
  <div class="content__padded">
    <div class="profile_content">
      <h3 class="title_profile m-t-3 p-t-3">Password reset complete</h3>
      <h2 class="m-t-2 m-b-3">Thank you! Your password has been successfully reset</h2>
      <div class="check__score">
        <button id="login-btn" class="btn btn__regular dis-block-xs" type="submit">Login</button>
        <button id="home-btn" class="btn btn__regular dis-block-xs" type="submit">Home</button>
      </div>
    </div>
  </div>
</div>
@stop
