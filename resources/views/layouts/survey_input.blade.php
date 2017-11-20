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
        @if(App::environment('local'))
           {!! Form::open(['method' => 'POST' , 'class'=>'survey__form' , 'url'=>  URL::to('/survey/confirm', array(), false) ]) !!}
        @else
           {!! Form::open(['method' => 'POST' , 'class'=>'survey__form' , 'url'=>  URL::to('/survey/confirm', array(), true) ]) !!}
        @endif
       <input type="hidden" name="userId" value="{{$userId}}"> 
          <section>
            <div class="section__line c">
              <h3 class="survey__title title__set primary">Quick Survey</h3>
              <p class="survey__desc">Your feedback is so helpful
                <br>for us to hear.
                <br>If you have a few minutes to
                <br>answer a quick survey.</p>
            </div>
            <div class="section__line">
              <p class="survey__title__block c">How satisfied or dissatisfied are you with brainsalvation?</p>
              <div class="error_message">{{ $errors->first('satisfaction') }}</div>
              <ul class="list__ask">
                  @foreach($data['satisfaction'] as $key=>$obj)
                        <li class="list__ask__item">
                            <div class="radio__regular">
                                <input type="radio" class="radio__regular__input js-input" id="satisfied-{{$key+1}}" name="satisfaction" value="{{$obj->value}}" @if(old('satisfaction')==$obj->value || ( old('satisfaction')==null && $key==0 ) )checked=""@endif required="">
                                       <label class="radio__regular__label" tabindex="4" for="satisfied-{{$key+1}}">{{ $obj->name}}</label>
                            </div>
                        </li>
                  @endforeach
              </ul>
            </div>
            <div class="section__line section__line--textarea">
              <p class="survey__title__block c">Why do you feel that way?</p>
               <textarea class="textarea js-input" placeholder="free comment" name="satisfaction_why" rows="5">{{old('satisfaction_why')}}</textarea>
               <div class="error_message">{{ $errors->first('satisfaction_why') }}</div>
            </div>
              <div class="section__line c">
                    <p class="survey__title__block">If brainsalvation provided Alzheimer's
                        <br>disease prevention programs
                        <br><span class="sub">(dietary advice, exercise guidance, etc.),</span>
                        <br>would you want to try it?</p>
                    <center><div class="error_message">{{ $errors->first('program_want_to_try') }}</div></center>
                    @foreach($data['yes_no'] as $key=>$obj)
                    <div class="radio__circle">
                        <input type="radio" class="radio__circle__input js-choice-reply js-input" id="reply-{{$key+1}}" name="program_want_to_try" value="{{$obj->value}}" @if(old('program_want_to_try')===$obj->value)checked=""@endif >
                               <label class="radio__circle__inner" for="reply-{{$key+1}}">{{ $obj->name}}</label>
                    </div>
                    @endforeach
                </div>
              
              <div class="section__line js-render-reply @if(old('program_want_to_try')==null || old('program_want_to_try')==='0') is-hidden @endif" data-reply="1">
                    <p class="survey__title__block c">If you answered YES,
                        <br>how much would you be willing
                        <br>to pay for such a service?</p>
                    <ul class="list__ask">
                        
                        @foreach($data['willing_to_pay'] as $key=>$obj)
                        <li class="list__ask__item">
                            <div class="radio__regular">
                                <input type="radio" class="radio__regular__input js-input" id="yes-willing-{{$key+1}}" name="program_how_much" value="{{$obj->value}}" @if(old('program_how_much')==$obj->value)checked=""@endif>
                                <label class="radio__regular__label" tabindex="4" for="yes-willing-{{$key+1}}">{{ $obj->name}}</label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
              
               <div class="section__line js-render-reply @if(old('program_want_to_try')==null || old('program_want_to_try')==='1') is-hidden @endif" data-reply="0">
                    <p class="survey__title__block c">If you answered NO,
                        <br>and you are not willing to try Alzheimer's prevention programs, why do you feel that way?<br />Please mark all that apply.</p>
                    <ul class="list__ask">
                        @foreach($data['not_willing_to_use'] as $key=>$obj)
                        <li class="list__ask__item">
                            <div class="checkbox__styled">
                                <input type="checkbox" class="checkbox__styled__input js-input" id="no-willing-{{$key+1}}" value="{{$obj->value}}" name="program_why_not[]" @if(old('program_why_not')!=null) @foreach(old('program_why_not') as $key=>$item) @if($item == $obj->value)checked=""@endif @endforeach @endif>
                                <label class="checkbox__styled__label" tabindex="4" for="no-willing-{{$key+1}}">{{ $obj->name}}</label>
                            </div>
                        </li>
                         @endforeach
                        <li class="list__ask__item">
                             <div>
                                 <textarea class="textarea js-input" placeholder="Other Concern ( Specify )" name="other_specify" rows="5">{{ old('other_specify') }}</textarea>
                             </div>
                        </li>
                    </ul>
                </div>
              
             
              <div class="section__line c">
                    <p class="survey__title__block">How likely is it that you would
                        <br>recommend this test to a
                        <br>friend or colleague?</p>
                    <div class="select__box">
                        <select class="select__box__actual js-input" name="recommendation">
                            <option>Select your answer</option>
                            <option value="0" @if(old('recommendation')=="0")selected="" @endif>0 (Not at all likely)</option>
                            <option value="1" @if(old('recommendation')=="1")selected="" @endif>1</option>
                            <option value="2" @if(old('recommendation')=="2")selected="" @endif>2</option>
                            <option value="3" @if(old('recommendation')=="3")selected="" @endif>3</option>
                            <option value="4" @if(old('recommendation')=="4")selected="" @endif>4</option>
                            <option value="5" @if(old('recommendation')=="5")selected="" @endif>5</option>
                            <option value="6" @if(old('recommendation')=="6")selected="" @endif>6</option>
                            <option value="7" @if(old('recommendation')=="7")selected="" @endif>7</option>
                            <option value="8" @if(old('recommendation')=="8")selected="" @endif>8</option>
                            <option value="9" @if(old('recommendation')=="9")selected="" @endif>9</option>
                            <option value="10"@if(old('recommendation')=="10")selected="" @endif>10 (Extreamly likely)</option>
                        </select>
                    </div>
                </div>
            
              <div class="section__comment c">
                    <p class="survey__title__block">If you have any other comments, please let us know.</p>
                    <textarea class="textarea js-input" placeholder="free comment" name="free_comment" rows="5">{{ old('free_comment') }}</textarea> 
                    <div class="error_message">{{ $errors->first('free_comment') }}</div>
              </div>
           
              <div class="widget__confirm">
                <button type="submit" class="btn btn-block btn__regular btn__regular">Send</button>
              </div>
          </section>
         {!! Form::close() !!}
        </div>
        <div class="page__survey block__footer">
          <p class="block__footer__link copyright">Copyright &copy; 2015 Pegara, Inc. All Rights Reserved.</p>
        </div>
      </div>
@stop