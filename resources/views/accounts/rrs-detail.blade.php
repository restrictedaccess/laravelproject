@extends('baselayout.common_page_base')

@section('content')

    @extends('baselayout.common_navigation')

	<div class="content user-account p-t-6">
    <div class="content__padded page__score">
        <div class="result">
            <h3 class="result__title">Title here</h3>
            <h5 class="result__info">Risk Reduction Score</h5>
        </div>
        <div class="count__up">
            <h3 class="count__up__inner">
                <span id="js-score-up" data-score="68">20</span>
                <span>/100</span>
            </h3>
        </div>
        <div class="progressbar__score">
            <div id="total-progress-container" class="progress">
                <div class="progress__bar">
                    <div class="progress__bar__current__level">
                        <span class="level__title">Poor</span>
                        <span class="level__title">Fair</span>
                        <span class="level__title">Average</span>
                        <span class="level__title">Good</span>
                        <span class="level__title">Excellent!</span>
                    </div>
                    <div id="total-progress-bar" class="progress__bar__current average">
                        <div id="total-progress-pointer" class="percent">
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="summary">
            <div class="summary__note">
                <h5 class="summary__note__content normal-weight" {{-- @if($header['status']) style="color:red;" @endif --}}>{{-- {{ $header['header'] }} --}}</h5>
            </div>
            <div class="summary__part padding-lr-20">
                {{-- @foreach( $score as $catKey=>$info) --}}
                <div class="summary__part__info summary__part--{{-- {{ $catKey }} --}}">
                    <h3 class="summary__part__title summary__part__title--{{-- {{ $catKey }} --}}"><i class="icon-score icons_{{-- {{ $catKey }} --}}">&nbsp;</i>{{-- {{ $catKey }} --}}</h3>
                    <div class="main__content main__content--{{-- {{ $catKey }} --}}">
                        <canvas id="{{-- {{ $catKey }} --}}" data-value="{{-- {{ $info['score'] }} --}}" width="112px" height="112px"></canvas>
                        <div class="detail">
                            <h5 class="detail__label text-center detail__label--{{-- {{$info['score_status']}} --}}"><i class="icon-score icons_{{-- {{$info['score_status']}} --}}">&nbsp;</i>{{-- {{ucwords($info['score_status'])}} --}}!</h5>
                            <a href="#" class="see_detail" type="button">See detail</a>
                        </div>
                        <div class="detail__information detail__information--{{-- {{ $catKey }} --}}">
                            <div class="detail__information__list">
                                {{-- @foreach($info['other_info'] as $key=>$value) --}}
                                <div class="topic">
                                    <div class="topic__icons">
                                        {{-- {!! $value['second_sentence_gif_name'] !!} --}}
                                        <span class="topic__rating topic__rating--{{-- {{$value['first_sentence_gif_name']}} --}}"><i class="icon-score icons_s{{-- {{$value['first_sentence_gif_name']}} --}}">&nbsp;</i>{{-- {{$value['evaluation_str']}} --}}</span>
                                    </div>
                                    {{-- @if($value['display']==1) --}}
                                    <div class="topic__content">
                                        <p class="advice-para">{{-- {!! $value['first_advise']." ".$value['second_advise'] !!}@if($catKey == 'activity' && $key == 'adv_sco_bmi') {{ $bmi }} --}} )</b>{{-- @endif --}}</p>
                                        <h6 class="reason"><i class="icon-score icons_pen">&nbsp;</i>Reason:</h6>
                                        <p class="reason__content">{{-- {{$value['reason']}} --}}</p>
                                        {{-- @if($value['tips'] !="" || $value['tips']!=null) --}}
                                        <h6 class="tips"><i class="icon-score icons_tip">&nbsp;</i>Tips:</h6>
                                        <ul class="tip__list">
                                            {{-- {!! $value['tips'] !!} --}}
                                        </ul>
                                        {{-- @endif --}}
                                    </div>
                                    <div class="btn__toggle">
                                        <a href="#" class="drop__toggle">Hide reason/advise</a>
                                    </div>
                                    {{-- @endif --}}
                                </div>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @endforeach --}}
            </div>
        </div>
       <div class="buttons">
            <button id="profile-back-btn" class="btn btn-block btn__regular">Details of My Score</button>
            <button id="profile-submit-btn" class="btn btn__regular">Retake Test</button>
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