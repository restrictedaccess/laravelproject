Page.score = function($) {
  var score = $('#js-score-up').attr('data-score'),
    _activity = $('#activity').attr('data-value'),
    _diet = $('#diet').attr('data-value'),
    _life_style = $('#lifestyle').attr('data-value'),
    _medical = $('#medical').attr('data-value');

  var options = {
    animationEasing: 'linear',
    showTooltips: false,
    segmentShowStroke: false
  };

  var data = {
    diet: [{
      value: _diet,
      color: '#68ace5'
    }, {
      value: 100 - _diet,
      color: '#717171'
    }],
    activity: [{
      value: _activity,
      color: '#68ace5'
    }, {
      value: 100 - _activity,
      color: '#717171'
    }],
    lifestyle: [{
      value: _life_style,
      color: '#68ace5'
    }, {
      value: 100 - _life_style,
      color: '#717171'
    }],
    medical: [{
      value: _medical,
      color: '#68ace5'
    }, {
      value: 100 - _medical,
      color: '#717171'
    }]
  };

  var init = function() {
    var scoreUp = new CountUp('js-score-up', 0, score, 0, 2.5, {  
      useEasing: true,
      useGrouping: true,
      separator: ',',
      decimal: '.',
      prefix: '',
      suffix: ''
    });

    scoreUp.start();

    Chart.types.Pie.extend({
      name: 'PieAlt',
      draw: function() {
        Chart.types.Pie.prototype.draw.apply(this, arguments);
        this.chart.ctx.font = 'bold 36px "Source Sans Pro"';
        this.chart.ctx.fillStyle = 'white';
        this.chart.ctx.textBaseline = 'middle';
        if (this.segments[0].value == '100') {
          this.chart.ctx.fillText(this.segments[0].value + "%", this.chart.width / 2 - 43, this.chart.width / 2, 100);
        } else {
          this.chart.ctx.fillText(this.segments[0].value + "%", this.chart.width / 2 - 35, this.chart.width / 2, 100);
        }
      }
    });

    var activity = document.getElementById('activity').getContext('2d'),
      actChart = new Chart(activity).PieAlt(data['activity'], options);
    var diet = document.getElementById('diet').getContext('2d'),
      dietChart = new Chart(diet).PieAlt(data['diet'], options);
    var lifestyle = document.getElementById('lifestyle').getContext('2d'),
      lsChart = new Chart(lifestyle).PieAlt(data['lifestyle'], options);
    var medical = document.getElementById('medical').getContext('2d'),
      medChart = new Chart(medical).PieAlt(data['medical'], options);

    $('.see_detail').click(function(e) {
      var text = $(this).text();
      $(this).text(
        text == 'See detail' ? 'Hide detail' : 'See detail');
      $(this).toggleClass('active');
      $(this).parent().parent().toggleClass('active');
      $(this).parent().parent().find('.detail__information').slideToggle();
      e.preventDefault();
    });
    var slide_toggle = function() {
      $('.topic').each(function() {
        var Offset = $(this).parent().find('.topic__content').position().top - 65;
        $(this).find('.drop__toggle').click(function(e) {
          e.preventDefault();
          var text = $(this).text();
          $(this).text(text == 'Hide reason/advise' ? 'See reason/advise' : 'Hide reason/advise');
          $(this).toggleClass('active');
          if ($(this).parent().parent().find('.topic__content').is(':visible')) {
            $(this).parent().parent().find('.topic__content').slideUp(500);
            $('.content').animate({ scrollTop: Offset }, '800');
          } else {
            $(this).parent().parent().find('.topic__content').slideDown(500);
          }
        });
      });
    };
    slide_toggle();
  };

  return {
    init: init
  };
}(jQuery);
