@extends('baselayout.common_page_base', ['share_img' => $share_img])
@section ('content')

<script>fbq('track', 'CompleteRegistration');</script>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!-- Twitter single-event website tag code -->
<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">twttr.conversion.trackPid('nuyo8', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=nuyo8&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=nuyo8&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
</noscript>
<!-- End Twitter single-event website tag code -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-76329406-1', 'auto');
  ga('send', 'pageview');
</script>

<div class="content">
    <div class="content__padded page__score">
        <div class="result">
            <h3 class="result__title">{{ $score['name']}}’s</h3>
            <h5 class="result__info">Risk Reduction Score</h5>
        </div>
        <div class="count__up">
            <h3 class="count__up__inner">
                <span id="js-score-up" data-score="{{$score['final_score']}}">20</span>
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
                    <div id="total-progress-bar" class="progress__bar__current {{$score['final_score_status']}}">
                        <div id="total-progress-pointer" class="percent">
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="summary">
                    <div class="summary__note">
                        <h5 class="summary__note__content normal-weight" @if($header['status']) style="color:red;" @endif>{{ $header['header'] }}</h5>
                    </div>
                    <div class="summary__part padding-lr-20">
                        <?php
                        unset($score['final_score']);
                        unset($score['final_score_status']);
                        unset($score['final_max_score']);
                        unset($score['name']);
                        ?>
                        @foreach( $score as $catKey=>$info)
                        <div class="summary__part__info summary__part--{{ $catKey }}">
                            <h3 class="summary__part__title summary__part__title--{{ $catKey }}"><i class="icon-score icons_{{ $catKey }}">&nbsp;</i>{{ $catKey }}</h3>
                            <div class="main__content main__content--{{ $catKey }}">
                                <canvas id="{{ $catKey }}" data-value="{{ $info['score'] }}" width="112px" height="112px"></canvas>
                                <div class="detail">
                                    <h5 class="detail__label text-center detail__label--{{$info['score_status']}}"><i class="icon-score icons_{{$info['score_status']}}">&nbsp;</i>{{ucwords($info['score_status'])}}!</h5>
                                    <a href="#" class="see_detail" type="button">See detail</a>
                                </div>
                                <div class="detail__information detail__information--{{ $catKey }}">
                                    <div class="detail__information__list">
                                        @foreach($info['other_info'] as $key=>$value)
                                        <div class="topic">
                                            <div class="topic__icons">
                                                {!! $value['second_sentence_gif_name'] !!}
                                                <span class="topic__rating topic__rating--{{$value['first_sentence_gif_name']}}"><i class="icon-score icons_s{{$value['first_sentence_gif_name']}}">&nbsp;</i>{{$value['evaluation_str']}}</span>
                                            </div>
                                            @if($value['display']==1)
                                            <div class="topic__content">
                                                <p class="advice-para">{!! $value['first_advise']." ".$value['second_advise'] !!}@if($catKey == 'activity' && $key == 'adv_sco_bmi') {{ $bmi }} )</b>@endif</p>
                                                <h6 class="reason"><i class="icon-score icons_pen">&nbsp;</i>Reason:</h6>
                                                <p class="reason__content">{{$value['reason']}}</p>
                                                @if($value['tips'] !="" || $value['tips']!=null)
                                                <h6 class="tips"><i class="icon-score icons_tip">&nbsp;</i>Tips:</h6>
                                                <ul class="tip__list">
                                                    {!! $value['tips'] !!}
                                                </ul>
                                                @endif
                                            </div>
                                            <div class="btn__toggle">
                                                <a href="#" class="drop__toggle">Hide reason/advise</a>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="summary">
                    <div class="summary__note">
                        <h6 class="summary__note__content normal-weight" @if($header['status']) style="color:red;" @endif>{{ $header['footer']}}</h6>
                    </div>
                </div><br><br>
                <div class="retake__test">
                    <a href="/rrs" type="button" class="btn btn__regular">Retake test</a>
                    <a href="/rrstop" class="btn btn-block btn__regular long">Return to Home</a>
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
            </div>
        </div>
    </div>
    <div class="block__footer">
        <a href="mailto:info@pegara.com" class="block__footer__link feedback">FEEDBACK</a>
        <a href="/reference" class="block__footer__link">References</a>
        <a href="/terms" class="block__footer__link">Terms</a>
        <a href="http://www.pegara.com/" target="_blank" class="block__footer__link">About us</a>
        <a href="http://www.pegara.com/" target="_blank" class="block__footer__link">Contact us</a>
        <a href="/privacy" class="block__footer__link">Privacy policy</a>
        <p class="block__footer__link copyright">Copyright &copy; 2015 Pegara, Inc. All Rights Reserved.</p>
    </div>
@stop
