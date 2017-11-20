<!DOCTYPE html>
<html lang="js">
    <head>
        <meta charset="utf-8">
        <title>@if( isset($meta['title'])) {{ $meta['title']}} @else brainsalvation - Error Page @endif</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="@if( isset($meta['description'])) {{ $meta['description']}} @endif">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <meta property="og:title" content="brainsalvation - lifestyle changes to reduce Alzheimer’s risk" />
        <meta property="og:type" content="website" />
        @if(App::environment('prd'))
        <meta property="og:url" content="https://www.brainsalvation.com" />
        <meta property="og:image" content="@if(isset($share_img)){{ url('/images/scores/'.$share_img) }}
                                            @else https://www.brainsalvation.com/images/front/facebook.jpg
                                            @endif" />
        @else
        <meta property="og:url" content="https://dev.brainsalvation.com" />
        <meta property="og:image" content="@if(isset($share_img)) {{ url('/images/scores/'.$share_img)  }}
                                            @else https://www.brainsalvation.com/images/front/facebook.jpg
                                            @endif" />
        @endif
        <meta property="og:site_name" content=“brainsalvation” />
        <meta property="og:description" content="How does your lifestyle affect your Alzheimer's disease risk? Take our free test to discover your personal Risk Reduction Score." />


        @if(App::environment('local'))
            <link rel="stylesheet" href="{{ URL::asset('/css/styles.css') }}" type="text/css">
        @else
            <link rel="stylesheet" href="{{ URL::secureAsset('/css/styles.css') }}" type="text/css">
        @endif


        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '1362810800412595');
        fbq('track', "PageView");
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=1362810800412595&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->

        <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
        <script type="text/javascript">twttr.conversion.trackPid('nux00', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
        <noscript>
        <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=nux00&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
        <img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=nux00&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
        </noscript>
        <!-- End Twitter universal website tag code -->



    </head>
    <body>
        <section>
            @yield('content')
        </section>
        @if(App::environment('local'))
            <script type="text/javascript" src="{{ URL::asset('js/scripts.js') }}"></script>
        @else
            <script type="text/javascript" src="{{ URL::secureAsset('js/scripts.js') }}"></script>
        @endif
    </body>
 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  @if(App::environment('prd'))
　  ga('create', 'UA-76329406-1', 'auto');
  @else
　  ga('create', 'UA-76329406-2', 'auto');
  @endif
  ga('send', 'pageview');
</script>
<script>
    $("#main-top-navbar").affix({
      offset: {
        top: 1
      }
    });

    $(".navbar-wrapper").height($(".navbar").height());
</script>
</html>
