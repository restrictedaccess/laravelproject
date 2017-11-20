Page.survey = function ($) {
  var init = function () {
    Widget.elements.selectBox();
    Widget.surveyModule.init();
    $('.survey__form').validate({
      ignore: [],
      onfocusout: false,
      invalidHandler: function(event, validator) {
        var errors = validator.numberOfInvalids();
        var errorList = validator.errorList;
        if (errors > 0) {
          $.each(errorList, function (index, el) {
            if (el.element.name == 'other_specify') {
              ga('send', 'event', 'Survey', 'program_why_not', 'validation', null);
            } else {
              ga('send', 'event', 'Survey', 'program_how_much', 'validation', null);
            }
            ga('send', 'event', 'Survey', el.element.name, 'validation', null);
          });
          ga('send', 'event', 'Survey', 'satisfaction_why', 'validation', null);
          ga('send', 'event', 'Survey', 'recommendation', 'validation', null);
          ga('send', 'event', 'Survey', 'free comment', 'validation', null);
        }
      },
      errorElement: 'div',
      errorClass: 'error_message',
      rules: {
        satisfaction: {
          required: true
        },
        satisfaction_why: {
          maxlength: 3000
        },
        program_want_to_try: {
          required: true
        },
        other_specify: {
          maxlength: 500
        },
        free_comment: {
          maxlength: 3000
        }
      }
    });
  };
  return {
    init: init
  };
}(jQuery);
