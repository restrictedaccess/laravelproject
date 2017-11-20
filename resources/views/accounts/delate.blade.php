@extends('baselayout.common_page_base')

@section('content')

@extends('baselayout.common_navigation')

<div class="content user-account p-t-6">
  <div class="content__padded page__score">
    <p>
      Notice: For your better health management, we recommended that you consult your doctor about disease risk treatment. We do not offer medical advice or diagnoses or engage in the practice of medicine.
    </p>
    <div class="buttons">
      <button id="retake-btn" class="btn btn-block btn__regular">Retake Test</button>
      <button id="home-btn" class="btn btn-block btn__regular">Return to Home</button>
    </div>

  </div>

  @stop