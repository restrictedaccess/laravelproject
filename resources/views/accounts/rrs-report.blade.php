@extends('baselayout.common_page_base')

@section('content')

    @extends('baselayout.common_navigation')

  <div class="content user-account p-t-6">
    <div class="content__padded page__score">
        <div class="graph-wrapper">
            Insert Graph here
        </div>
        <div class="history-list">
          <p><a href="/account-rrs-report/1">6/12/2016  42(Moderate)</a>  <a href="/delate">review delate</a></p>
        </div>
       <div class="buttons">
          @if(isset($results) && count($results))
            <button id="profile-submit-btn" class="btn btn-block btn__regular">Retake Test</button>
          @else
            <button id="profile-submit-btn" class="btn btn-block btn__regular">Start Now</button>
          @endif
        </div>

        <div class="buttons-link">
            <a href="">Feedback</a>
            |
            <a href="">Edit Profile</a>
        </div>

        <ul class="social">
            <li class="social__item">
                <a href="javascript:void(0);" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ url("/") }}', '', '');" class="btn social__btn btn-fb" aria-label="Left Align">
                  <i class="fa fa-facebook" aria-hidden="true"></i> Share
                </a>
            </li>
            <li class="social__item">
                <a href="javascript:void(0);" onclick="window.open('https://twitter.com/share?url=https%3a%2f%2fwww%2ebrainsalvation%2ecom%2f', '', '');" class="btn social__btn btn-twitter" aria-label="Left Align">
                  <i class="fa fa-twitter" aria-hidden="true"></i> Tweet
                </a>
            </li>
            <li class="social__item">
                <a href="javascript:void(0);" onclick="window.open('http://www.linkedin.com/shareArticle?url=https%3a%2f%2fwww%2ebrainsalvation%2ecom%2f', '', '');" class="btn social__btn btn-linkedin" aria-label="Left Align">
                  <i class="fa fa-linkedin-square" aria-hidden="true"></i> Share
                </a>
            </li>
            <li class="social__item">
                <a href="javascript:void(0);" onclick="window.open('https://plus.google.com/share?url=https%3a%2f%2fwww%2ebrainsalvation%2ecom%2f', '', '');" class="btn social__btn btn-gplus" aria-label="Left Align">
                  <i class="fa fa-google-plus-square" aria-hidden="true"></i> Share
                </a>
            </li>
        </ul>
        <ul class="social">
            <li class="social__item">
                <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fbrainsalvation%2F&width=51&layout=button&action=like&size=small&show_faces=false&share=false&height=20" width="51" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            </li>
            <li class="social__item">
                <a href="https://twitter.com/brainsalvation" class="twitter-follow-button" data-show-count="false">Follow @brainsalvation</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </li>
        </ul>
      <div class="links_footer">
          <ul class="list-inline">
            <li>
              <a href="/privacy" class="block__footer__link">Privacy policy</a>
            </li>
            <li>
              <a href="/terms" class="block__footer__link">Terms</a>
            </li>
            <li>
              <a href="http://www.pegara.com/" target="_blank" class="block__footer__link">About us</a>
            </li>
            <li>
              <a href="/reference" class="block__footer__link">References</a>
            </li>
          </ul>
      </div>
    </div>

@stop