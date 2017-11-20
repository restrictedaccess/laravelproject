@extends('baselayout.common_page_base')
@section ('content')
    <div class="content">
      <div class="content__padded">
        <div class="thankyou__page exception_page">
          <div>
            <h3 class="thankyou_title">Internal Sever Error</h3>
            <h5 class="page_title title_500">Sorry,<br>something went wrong</h5>
          </div>
          <div class="block__icons_cover error500">
            <i class="icons_error500">&nbsp;</i>
          </div>
          <div class="btn_home">
            <a href="/" class="btn btn-block btn__regular long">Return to Home</a>
            <a href="{{ URL::previous() }}" class="btn btn-block btn__regular long">Go to Previous Page</a>
          </div>
          <br>
        </div>
      </div>
    </div>
@stop
