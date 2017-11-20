@extends('baselayout.common_page_base')
@section ('content')
<div class="content">
    <div class="content__padded page-rrs">
        <div class="progress hidden">
            <div class="progress__bar">
                <div id="progress__bar__current" class="progress__bar__current">
                    <div id="progress__percent__current" class="percent">
                        <span>50</span>
                    </div>
                </div>
            </div>
        </div>
        @if(App::environment('local'))
        {!! Form::open(['method' => 'POST' , 'id'=>'risk-reduction-score', 'url'=>  URL::to('/rrs/profile', array(), false) ]) !!} 
        @else
        {!! Form::open(['method' => 'POST' , 'id'=>'risk-reduction-score', 'url'=>  URL::to('/rrs/profile', array(), true) ]) !!} 
        @endif
        {!! Form::close() !!}
    </div>
</div>
@stop



