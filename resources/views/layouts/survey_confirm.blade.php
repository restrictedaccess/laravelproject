@extends('baselayout.common_page_base')
@section ('content')
<div class="content">
    <div class="page__survey content__padded">
        <div class="hero">
            <div class="main__logo">
                <h1>
                    @if(App::environment('local'))
                    <img class="top__logo" alt="brainsalvation" src="{{ URL::asset('images/front/logo_savation.png') }}">
                    @else
                    <img class="top__logo" alt="brainsalvation" src="{{ URL::secureAsset('images/front/logo_savation.png') }}">
                    @endif
                </h1>
            </div>
        </div>
        <section>

            @if(App::environment('local'))
            {!! Form::open(['method' => 'POST' , 'class'=>'survey__form' , 'url'=>  URL::to('/survey/thanks', array(), false) ]) !!}
            @else
            {!! Form::open(['method' => 'POST' , 'class'=>'survey__form' , 'url'=>  URL::to('/survey/thanks', array(), true) ]) !!}
            @endif
            <input type="hidden" name="userId" value="{{$data['userId']}}"> 
            <div class="survey__confirm">
                <div class="section__line c">
                    <h3 class="survey__confirm_title title__set primary">Quick Survey-Confirm</h3>
                </div>
                <div class="section__line c">
                    <p class="survey__title__block">How satisfied or dissatisfied are you
                        <br>with brainsalvation?</p>
                    <p class="title__set primary text_confirm js-show-satisfied">{{ $data['satisfaction']}}</p>
                </div>
                <div class="section__line">
                    <p class="survey__title__block c">Why do you feel that way?</p>
                    <div class="textarea confirm">
                        <p class="js-show-comment-feel">{{ $data['satisfaction_why']}}</p>
                    </div>
                </div>
                <div class="section__line c">
                    <p class="survey__title__block">If brainsalvation provided Alzheimer's
                        <br>disease prevention programs
                        <br><span class="sub">(dietary advice, exercise guidance, etc.),</span>
                        <br>would you want to try it?</p>
                    <div class="radio__circle">
                        <input type="radio" class="radio__circle__input" id="reply-confirm-1" name="reply-confirm" value="{{ $data['program_want_to_try']}}" checked="">
                        <label class="radio__circle__inner js-show-reply text-capitalize" for="reply-confirm-1">{{ $data['program_want_to_try']}}</label>
                    </div>
                </div>
                <div class="section__line js-render-reply @if($data['program_want_to_try'] == 'No') is-hidden @endif">
                    <p class="survey__title__block c">If you answered YES,
                        <br>how much would you be willing
                        <br>to pay for such a service?</p>
                    @if(isset($data['program_how_much'])) 
                    <p class="title__set primary text_confirm c js-show-yes-willing">{{ $data['program_how_much']}}</p> 
                    @else 
                    <center><p class="title__set primary text_confirm js-show-satisfied">Not Answered</p></center>
                    @endif
                </div>
                <div class="section__line js-render-reply @if($data['program_want_to_try'] == 'Yes') is-hidden @endif">
                    <p class="survey__title__block c">If you answered NO,
                        <br>and you are not willing to try Alzheimer's prevention programs,
                        <br>why do you feel that way?
                        <br>Please mark all that apply.</p>
                    @if(isset($data['program_why_not']) || ( isset($data['other_specify']) && $data['other_specify']!=""))
                    @if(isset($data['program_why_not']))
                    @foreach($data['program_why_not'] as $key=>$value)
                    <p class="title__set primary text_confirm c js-show-no-willing">{{ $value }}</p>
                    @endforeach
                    @endif 
                    @if(isset($data['other_specify']) && $data['other_specify']!="")
                    <div class="textarea confirm">
                        <p class="js-show-comment-other">{{ $data['other_specify']}} </p>
                    </div>
                    @endif
                    @else
                    <center><p class="title__set primary text_confirm js-show-satisfied">Not Answered</p></center>
                    @endif
                </div>
                <div class="section__line c">
                    <p class="survey__title__block">How likely is it that you would
                        <br>recommend this test to a
                        <br>friend or colleague?</p>

                    @if(is_numeric($data['recommendation']))
                    <div class="radio__circle">
                        <input type="radio" class="radio__circle__input js-choice-reply" id="likely-confirm-1" name="likely-confirm" value="{{ $data['recommendation'] }}" checked="">
                        <label class="radio__circle__inner js-show-likely" for="likely-confirm-1">{{ $data['recommendation'] }}</label>
                    </div>
                    @else 
                    <p class="title__set primary text_confirm js-show-satisfied">Not Answered</p>
                    @endif
                </div>
                <div class="section__line">
                    <p class="survey__title__block c">If you have any other comments, please let us know.</p>
                    <div class="textarea confirm">
                        <p class="js-show-comment-other">{{ $data['free_comment']}} </p>
                    </div>
                </div>
                <div class="widget__confirm">
                    <button type="submit" class="btn btn-block btn__regular btn__regular js-step-target">Send</button>
                    <a href="{{ URL::previous() }}" class="btn btn-block btn__regular btn__regular js-step-target">Revision</a>
                </div>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
    <div class="page__survey block__footer">
        <p class="block__footer__link copyright">Copyright &copy; 2015 Pegara, Inc. All Rights Reserved.</p>
    </div>
</div>
@stop