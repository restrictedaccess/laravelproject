@extends('baselayout.common_page_base')
@section ('content')
@if(App::environment('local'))
    <script type="text/javascript" src="{{ URL::asset('js/browser.js') }}"></script>
@else
    <script type="text/javascript" src="{{ URL::secureAsset('js/browser.js') }}"></script>
@endif

<!-- Twitter single-event website tag code -->
<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">twttr.conversion.trackPid('nuyo9', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=nuyo9&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=nuyo9&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
</noscript>
<!-- End Twitter single-event website tag code -->


<script>fbq('track', 'ViewContent');</script>

<div class="content main">

    @if(Auth::check())
      @include('baselayout.common_navigation')
    @else
      @include('baselayout.common_navigation-default-main')
    @endif
      <div class="hero">
        <div class="main__logo">
          <!-- <h1>
            <a href="#">
                @if(App::environment('local'))
                    <img class="top__logo" alt="brainsalvation" src="{{ URL::asset('images/front/logo_savation.png') }}">
                @else
                    <img class="top__logo" alt="brainsalvation" src="{{ URL::secureAsset('images/front/logo_savation.png') }}">
                @endif
            </a>
          </h1> -->
          <h3 class="top__caption">
            <span class="br">How does your </span>
            <span class="br">lifestyle affect your</span>
            <span class="br">Alzheimer's Risk?</span>
          </h3>
        </div>
        <div class="risk__reduction">
          <p class="risk__reduction__title">Discover your
            <br>Risk Reduction Score</p>
          <div class="risk__reduction__button">
            <a href="/rrs" alt="START NOW" class="btn btn-block btn__regular btn__regular--uppercase short">start now</a>
            @if(Auth::check())
            <a href="/account" alt="START NOW" class="btn btn-block btn__regular btn__regular--uppercase short">My Page</a>
            @endif
          </div>
        </div>
      </div>
      <div class="content__padded page-top">
        <div class="risk__reduction__content">
          <h3 class="risk__reduction__content__title">What is Risk Reduction Score?</h3>
          <div class="risk__reduction_chart">
                @if(App::environment('local'))
                    <img class="risk__reduction_img" alt="Risk Reduction Score" src="{{ URL::asset('images/front/reduction_score.jpg') }}" alt="Risk Redution Score" width="300" height="228">
                @else
                    <img class="risk__reduction_img" alt="Risk Reduction Score" src="{{ URL::secureAsset('images/front/reduction_score.jpg') }}" alt="Risk Redution Score" width="300" height="228">
                @endif
          </div>
          <div class="describe">
            <div class="describe__content">
              <p class="describe__inner">The Risk Reduction Score is a crucial component of the brainsalvation system. The score provides a clear guideline for understanding how your lifestyle increases or decreases your chances of developing dementia and/or Alzheimer’s. The Risk Reduction Score incorporates findings from recent, peer-reviewed <a href="/reference" class="describe__link">medical research</a>, and was developed under the supervision of <a href="https://www.mccare.com" target="_blank" class="describe__link">Medical Care Corporation</a>,  a data analytics company specializing in the measurement of cognition.</p>
              <p class="describe__inner">We'll use the Risk Reduction Score to give you lifestyle tips that will help you reduce your risk of dementia and Alzheimer's disease. We hope that this information helps you achieve a long, happy life with your family and friends.</p>
            </div>
            <div class="alzheimers__disease">
              <h4 class="alzheimers__disease__title">ALZHEIMER'S DISEASE FACTS AND FIGURES</h4>
              <div class="figures__detail">
                <div class="figures__detail__inner">
                  <h5 class="figures__detail__title">PREVALENCE</h5>
                  <p class="describe__inner">Alzheimer’s disease is the <span class="describe__inner--semibold">6th leading cause of death</span> in the United States.<span class="citation">*1</span></p>
                </div>
                <div class="figures__detail__inner">
                  <h5 class="figures__detail__title">CAREGIVERS</h5>
                  <p class="describe__inner">On average, care contributors <span class="describe__inner--semibold">lose over $15,000</span> in annual income as a result of reducing or quitting work to meet the demands of caregiving.<span class="citation">*1</span></p>
                </div>
                <div class="figures__detail__inner">
                  <h5 class="figures__detail__title">COST TO NATION</h5>
                  <p class="describe__inner">Alzheimer's disease is one of the costliest chronic diseases to society. The growing <span class="describe__inner--semibold">Alzheimer's crisis is helping to bankrupt Medicare</span>. Medicare and Medicaid are expected to cover <span class="describe__inner--semibold">$160 billion, or 68%</span>, of the total health care and long-term care payments forpeople with Alzheimer's disease and other dementias.<span class="citation">*1</span></p>
                </div>
                <div class="figures__detail__inner">
                  <h5 class="figures__detail__title">Pathogenesis</h5>
                  <p class="describe__inner">The Amyloid β buildup that is the cause of Alzheimer's in the brain starts from the age of about <span class="describe__inner--semibold">40 or older</span>. At <span class="describe__inner--semibold">10 or more years later</span>, Tau protein buildup will begin. Then, 15 or more years later, it will reach Mild cognitive Impairment expression or “Alzheimer’s disease”.<span class="citation">*2</span></p>
                </div>
              </div>
              <div class="reference__sources">
                <p class="reference__sources__list">Reference sources;</p>
                <p class="reference__sources__list">*1 <a href="http://www.alz.org/facts/" target="_blank" class="block__footer__link describe__link">Alzheimer’s association</a></p>
                <p class="reference__sources__list">*2 David M. Holtzman,C. Morris John,</p>
                <p class="reference__sources__list">Alison Goate, 2011, Alzheimer’s</p>
                <p class="reference__sources__list">Disease: The Challenge of the Second Century</p>
              </div>
              <div class="block__start">
                <p class="risk__reduction__title">Discover your
                  <br>Risk Reduction Score</p>
                <div class="risk__reduction__button">
                  <a href="/rrs" alt="START NOW" class="btn btn-block btn__regular btn__regular--uppercase short">start now !</a>
                </div>
              </div>

              <div class="block__additional__info">
                <p class="text-center">In order to give you an accurate score and relevant advice, we ask for a few details about you.</p>
                <p class="text-center"><a role="button" data-toggle="collapse" href="#additionalInfo" aria-expanded="false" aria-controls="additionalInfo">Click here</a> if you'd like to review them in advance before taking the quiz.</p>
              </div>
              <div class="collapse" id="additionalInfo">
                <p class="text-center">Age, Gender, Weight, Height, Medical Conditions etc.</p>
              </div>
              <div class="mpi_content">
                <div class="row">
                  <div class="mpi-header">
                    <h1 class="">Concerned about  your memory?</h1>
                    <img class="mpi-img" src="{{ URL::asset('images/front/mpi_logo.png') }}" alt="mci" width="150">
                    <a href="/mpi">Memory Performance Index (MPI)</a>
                    <h2 class="price">$59</h2>
                  </div>
                </div>
                <ul class="list-inline services">
                  <li>
                    <h4 class="mci__title">Accurate</h4>
                    <small class="mci__sub">97 <span>%</span></small>
                  </li>
                  <li>
                    <h4 class="mci__title">Simple</h4>
                    <small class="mci__sub">10 <span>min</span></small>
                  </li>
                  <li>
                    <h4 class="mci__title">Validation</h4>
                    <small class="mci__sub">Million+ <br>Tests</small>
                  </li>
                </ul>
                <a href="/mpi" alt="Learn more" class="btn btn-block btn__regular btn__regular--uppercase short m-t-6">Learn More</a>
              </div>
            </div>
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
    </div>

@stop
