Page.profile = function($) {
  var init = function() {
    var currentYear = new Date().getFullYear();
    $.validator.addMethod('birth',
      function (value, element) {
        var birthYear = value.split('-');
        if (parseInt(birthYear[0]) <= (currentYear - 18) &&
            parseInt(birthYear[0]) >= (currentYear - 90)) {
          return true;
        } else {
          return false;
        }
      },
      'Please enter a year greater than ' + (currentYear - 90) + ' and smaller than ' + (currentYear - 18) + '.'
    );
    $('#form_profile').validate({
      ignore: [],
      onfocusout: false,
      invalidHandler: function(event, validator) {
        var errors = validator.numberOfInvalids();
        var errorList = validator.errorList;
        if (errors > 0) {
          $.each(errorList, function (index, el) {
            if (el.element.name == 'name_first') {
              el.element.name = 'first_name';
            } else if (el.element.name == 'name_last') {
              el.element.name = 'last_name';
            } else if (el.element.name == 'mobile_phone') {
              el.element.name = 'mobile_no';
            } else if (el.element.name == 'height') {
              ga('send', 'event', 'form_039', 'height_unit', 'validation', null);
            } else if (el.element.name == 'weight') {
              ga('send', 'event', 'form_039', 'weight_unit', 'validation', null);
            }
            ga('send', 'event', 'form_039', el.element.name, 'validation', null);
          });
          ga('send', 'event', 'form_039', 'new_letter_flg', 'validation', null);
        }
      },
      errorElement: 'div',
      errorClass: 'error_message',
      rules: {
        name_first: {
          required: true,
          minlength: 1,
          maxlength: 50
        },
        name_last: {
          minlength: 1,
          maxlength: 50,
        },
        email: {
          required: true,
          email: true,
          rangelength: [1, 255]
        },
        mobile_phone: {
          number: true,
          rangelength: [10, 16]
        },
        zip_code: {
          number: true,
          minlength: 5,
          maxlength: 5
        },
        birthday: {
          required: true,
          date: false,
          dateISO: true,
          birth: true
        },
        gender: {
          required: true
        },
        height: {
          required: true,
          number: true,
          min: 12,
          max: 84
        },
        weight: {
          required: true,
          number: true,
          min: 60,
          max: 1000
        }
      }
    });

    $(document).on('change', 'input[name="height_unit"]', function () {
      if ($(this).val() == 'cm') {
        $('input[name="height"]').rules('add', {
          min: 100,
          max: 200
        });
      } else {
        $('input[name="height"]').rules('add', {
          min: 12,
          max: 84
        });
      }
      $('#height').valid()
    });

    $(document).on('change', 'input[name="weight_unit"]', function () {
      if ($(this).val() == 'kg') {
        $('input[name="weight"]').rules('add', {
          min: 27,
          max: 450
        });
      } else {
        $('input[name="weight"]').rules('add', {
          min: 60,
          max: 1000
        });
      }
      $('#weight').valid();
    });
  };
  return {
    init: init
  };
}(jQuery);
