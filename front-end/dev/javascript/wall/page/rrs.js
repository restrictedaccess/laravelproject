Page.rrs = function ($) {
  var parent, form,
      next, prev, current,
      _next, _prev, _current,
      $nextForm, $prevForm, $currentForm,
      historify = false;
  var init = function () {
    Widget.form.readData().done(function () {
      Widget.form.initialRender();
    });

    $(window).on('hashchange', function (event) {
      historify = true;

      current = window.location.hash.split('#')[1];
      _current = Widget.form.formList.indexOf(current);
      $currentForm = $('#form_' + current);

      _prev = Widget.form.formList[_current - 1];
      $prevForm = $('#form_' + _prev);
      _next = Widget.form.formList[_current + 1];
      $nextForm = $('#form_' + _next);

      var _prevOfPrev = Widget.form.formList[_current - 2],
          $prevOfPrev = $('#form_' + _prevOfPrev),
          _nextOfNext = Widget.form.formList[_current + 2],
          $nextOfNext = $('#form_' + _nextOfNext);

      if (!$nextForm.length) {
        if (!$nextOfNext.length) {
          historify = false;
        }
      }

      $('html body').animate({scrollTop: 0}, 'fast');
      if ($nextForm.length) {
        $nextForm.hide();
      } else {
        $nextOfNext.hide();
      }

      if ($prevForm.length) {
        $prevForm.hide();
      } else {
        $prevOfPrev.hide();
      }
      $currentForm.show();

      Widget.form.handleProgess(current);
      Util.validation.actionValid(current);
      toggleProgess(current);
      handleGA(current);
    });

    $(document).on('click', '.js-next-button', function () {
      $currentForm = $(this).parent();
      var currentId = $currentForm.attr('id').split('_')[1];
      console.log(currentId);
      next = $(this).attr('data-form');
      $nextForm = $('#form_' + next);
      if (historify) {
        if (next == '032') {
          var _check = [];
          $('#medical_depression').find('.js-answer-key:checked').each(function () {
            _check.push($(this).val());
          });
          if (_check.length == 0) {
            next = '033';
          }
          _check = null;
        }

        if (next == '015' || next == '017' || next == '032' || next == '033') {
            if (next == '015' || next == '032') {
              Widget.form.handleLogic(next, 'skipHistory-noskip');
            } else {
              if (currentId == '013') {
                $('#form_015').remove();
              } else if (currentId == '031') {
                $('#form_032').remove();
              }
              Widget.form.handleLogic(next, 'skipHistory-skippable');
            }
        } else {
          Widget.form.historyReplace(next);
        }
      } else {
        if (next == '032') {
          var _check = [];
          $('#medical_depression').find('.js-answer-key:checked').each(function () {
            _check.push($(this).val());
          });
          if (_check.length == 0) {
            next = '033';
          }
          _check = null;
        }

        $currentForm.hide();
        Widget.form.historyPush(next);
        Widget.form.renderMain(next);
        $('html body').animate({scrollTop: 0}, 'fast');
        $('#form_' + next).show();
        toggleProgess(next);
        Widget.form.handleProgess(next);
        Util.validation.actionValid(next);
      }
    });
  };

  var toggleProgess = function (next) {
    if ($('#form_' + next).hasClass('form-question')) {
      $('.progress').removeClass('hidden');
    } else {
      $('.progress').addClass('hidden')
    }
  };

  var handleGA = function (form) {
    ga('set', 'page', '/rrs/' + form);
    ga('send', 'pageview');
  };

  return {
    init: init,
    handleGA: handleGA
  };
}(jQuery);
