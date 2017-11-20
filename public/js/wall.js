/*! pegara-brain-salvation - v0.0.1 ( 2016-04-28 ) - MIT */
(function(window) {


/**
 * namespace
 * PBS = Pegara's Brain Salvation
 */
var PBS    = window.PBS = {};
var Util   = PBS.Util   = {};
var Widget = PBS.Widget = {};
var Page   = PBS.Page   = {};
var Route  = PBS.Route  = {
  all     : '.',
  rrs     : '^\/rrs?',
  profile : '^\/rrs\/profile',
  score   : '^\/rrs\/score',
  survey  : '^\/survey\/form'
};

/**
 * on domContentLoaded
 */
$(function() {
  // All pages
  Util.dispatcher(Route.all, function() {
    Page.all.init();
  });

  // RRS form page
  Util.dispatcher(Route.rrs, function() {

    Page.rrs.init();
  });

  // RRS profile form page
  Util.dispatcher(Route.profile, function() {

    Page.profile.init();
  });

  // RRS score page
  Util.dispatcher(Route.score, function() {

    Page.score.init();
  });

  // Survey page
  Util.dispatcher(Route.survey, function() {

    Page.survey.init();
  });

  // dispatch
  var url = location.pathname;
  Util.dispatcher(url);
});

Util.dispatcher = function(page, callback) {
  this.page_func = this.page_func || [];

  if (callback) return this.page_func.push([page, callback]);
  for(var i = 0, l = this.page_func.length; i < l; ++i) {
    var func = this.page_func[i];
    var match = page.match(func[0]);
    match && func[1](match);
  }
};

Util.string = (function() {

  return {

    /*
     * @param {String}
     * @return {String}
     */
    sprintf: function(format) {
      var regex = /(%d|%s){1}/,
          args  = [],
          len   = arguments.length;

      for (var i = 1; i < len; i++) {
        args.push(arguments[i]);
      }

      len = args.length;
      var str = format;

      for (var i = 0; i < len; i++) {
        str = str.replace(regex, args[i]);
      }

      return str;
    },

    /*
     * @param {String}
     * @return {String}
     */
    stripHTML: function(val) {
      var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
      return val.replace(tags, '');
    },

    /*
     * @param {String/Number}
     * @param {Number}
     * @param {String}
     * @return {String}
     */
    leftPad: function(str, pad, spacer) {
      spacer = spacer || '0';
      pad    = pad || 0;
      var target = '';
      for (var i = 0; i < pad; i++) {
        target = target + spacer;
      }

      return (target + str).slice(-1 * pad);
    },

    /*
     * @param {Number}
     * @return {String}
     */
    csv: function(val) {
      return String(val).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
    }

  }

})();

Util.date = (function() {

  // Get date of today
  var today = function() {
    // Dateオブジェクトを生成
    var now = new Date();
    var y = now.getFullYear();
    var m = now.getMonth() + 1;
    var d = now.getDate();
    var h = now.getHours();
    var i = now.getMinutes();
    return y + '-' + m + '-' + d + '-' + h + '-'+ i;
  };

  return {

    latest: {

      latestKey: 'latest',

      /*
       * @return {Boolean}
       * ローカルストレイジを使って最近アクセスしたのが今日かどうか判定
       */
      isToday: function() {
        var now       = new Date(),
            latest    = new Date(Util.storage.get(this.latestKey)),
            diffYear  = now.getFullYear()     === latest.getFullYear(),
            diffMonth = (now.getMonth() + 1)  === (latest.getMonth() + 1),
            diffDate  = now.getDate()         === latest.getDate(),
            diffHours = now.getHours()        <  8; // バッチが十分に回りきったあとの時間がだいたい8時

        if (diffYear && diffMonth && diffDate || diffHours) {
          return true;
        }
        // if (diffHours) {
        //   return true;
        // }
        return false;
      },

      /*
       * @return {String} latestKey
       */
      getLatestKey: function() {
        return this.latestKey;
      }
    },

    today: today
  }
})();

Util.url = (function() {

  return {

    /*
     * @param {String} path
     * @param {Object} query
     */
    getQuery: function(path) {
      var query = {},
          param = [],
          tmp   = [];

      if (!path || !/^\?.*=.*/.test(path)) { return query; };

      path = path.substr(1);
      param = path.split(/&/g);

      _.each(param, function(item, index) {
        tmp = item.split(/=/);
        query[tmp[0]] = tmp[1];
      });

      return query;
    },

    getLastPath: function() {
      return location.pathname.split('/').pop();
    },

    removeFirstPath: function(){
      var _url = location.pathname;
      var _path = _url.split('/');
      _path.splice(1, 1)
      _url = _path.join('/');
      return _url;
    },

    concatPath: function(path1, path2) {
      var path1Flag = path1.substr(-1, 1) === '/' ? true : false,
          path2Flag = path2.substr(0, 1) === '/' ? true : false,
          concatPath = '';

      if (path1Flag === true && path2Flag === true) {
        concatPath = path1 + path2.substr(1);
      } else if (path1Flag === true || path2Flag === true) {
        concatPath = path1 + path2;
      } else {
        concatPath = path1 + '/' + path2;
      }

      return concatPath;
    }

  };
})();

Util.fetch = function(options) {
  var env      = MMS.Config.env,
      baseUrl  = env.base_url,
      mId      = env.m_id,
      mOwnerId = env.m_owner_id,
      userId   = env.user_id,
      referer  = env.referer,
      apiUrl   = Util.url.concatPath(baseUrl, 'api/%s?'),
      $defer   = $.Deferred(),
      query    = {
        m_id       : mId,
        m_owner_id : mOwnerId,
        referer    : referer
      },
      url      = '';
  _.extend(query, options.params);

  // decide url.
  apiUrl = Util.string.sprintf(apiUrl, options.path);

  if (options.type === 'ranking'||
      options.type === 'category'||
      options.type === 'killer'||
      options.type === 'topKiller') {
    _.extend(query, {user_id: userId});
  }

  if (options.type === 'notificationIncentive') {
    _.extend(query, {type: options.notiType});
  }
  if (options.type === 'viewHistory') {
    _.extend(query, {type: options.params});
  }

  url = apiUrl + $.param(query);
  $.ajax({
    type     : 'GET',
    dataType : 'json',
    url      : url,
    success  : $defer.resolve,
    error    : $defer.reject
  });

  return $defer.promise();
};

Util.dimension = (function(win, doc) {

  /**
   * 表示領域のサイズを取得する
   *
   * @return {Object}
   */
  function viewportSize() {
    return {
      width : win.innerWidth,
      height: win.innerHeight
    };
  }

  /**
   * スクロール量を取得する
   *
   * @return {Object}
   */
  function scrollPos() {
    return {
      left: win.pageXOffset || doc.documentElement.scrollLeft || doc.body.scrollLeft,
      top : win.pageYOffset || doc.documentElement.scrollTop  || doc.body.scrollTop
    };
  }

  /**
   * 要素の表示領域内の絶対座標と，矩形の幅と高さを返す ( border-boxモデル )
   * getBoundingClientRectの実装が必要
   *
   * @param {Element} elm
   * @return {Object}
   */
    function elAbsRectPos(elm) {
      var rect = elm.getBoundingClientRect();

      return {
        top   : rect.top,
        bottom: rect.bottom,
        left  : rect.left,
        right : rect.right,
        width : rect.width  || (rect.right  - rect.left),
        height: rect.height || (rect.bottom - rect.top)
      };
    }

  /**
   * 要素の親要素との相対座標と，矩形の幅と高さを返す
   *
   * @param {Element} elm
   * @param {Element} [parent]
   * @return {Object}
   */
  function elRelRectPos(elm, parent) {
    var crit = elAbsRectPos(parent || elm.parentNode),
        self = elAbsRectPos(elm);

    return {
      top    : self.top    - crit.top,
      bottom : crit.bottom - self.bottom,
      left   : self.left   - crit.left,
      right  : crit.right  - self.right
    };
  }

  /**
   * 要素を中央に配置する
   * デフォルトはviewportに対しての中央
   *
   * @param {Element} elm
   * @param {Element} [crit]
   */
    // @todo issue: ロジックの整理が必要
  function elCentering(elm, crit) {
    var self = elAbsRectPos(elm), from, to, xy = {},
        pos = {}, fix = {}, relbase = false;

    function _isRelative(elm) {
      var e = elm, state;
      while (e = e.parentNode) {
        // documentに突き当たったら終了
        if (e === doc) {
          return false;
        }
        state = elm.style.position;
        if (state === 'absolute' || state === 'relative') {
          return e;
        }
      }
      return false;
    }

    // critがあって，スタイルのtop, leftと座標が異なれば相対基準をチェック
    xy.top  = elm.style.top;
    xy.left = elm.style.left;

    if (crit && self.top !== xy.top && self.left !== xy.left) {
      relbase = _isRelative(elm);
    }

    // 相対基準がいるか？
    if (relbase !== false) {
      // 相対基準とcritは同一か？
      if (crit && crit === relbase) {
        // 1.相対座標でfix
        to = elAbsRectPos(crit);

        pos.left = (to.width  - self.width)  / 2 + 'px';
        pos.top  = (to.height - self.height) / 2 + 'px';
      } else {
        // 2.relbaseとcritの座標をあわせて，矩形サイズの比較から中央を算出する -> noteみる
        to   = elAbsRectPos(crit);
        from = elAbsRectPos(relbase);

        fix.top  = to.top  - from.top;
        fix.left = to.left - from.left;

        pos.left = (to.width  - self.width)  / 2 + fix.left + 'px';
        pos.top  = (to.height - self.height) / 2 + fix.top  + 'px';
      }
    } else {
      // critはあるか？
      if (crit) {
        // 3.単純に絶対座標同士でフィックス
        to = elAbsRectPos(crit);

        pos.left = (to.width  - self.width)  / 2 + to.left + 'px';
        pos.top  = (to.height - self.height) / 2 + to.top  + 'px';
      } else {
        // 4.単純にviewportの中央にする（スクロール位置でfix）
        to = viewportSize();
        fix = scrollPos();

        pos.left = (to.width  - self.width)  / 2 + fix.left + 'px';
        pos.top  = (to.height - self.height) / 2 + fix.top  + 'px';
      }
    }

    Object.keys(pos).forEach(function(prop) {
      elm.style[prop] = pos[prop];
    });
  }

  /**
   * 要素が範囲内にあるかどうか
   * @param {Object} $elm Element for check.
   * @param {Number} len Distance from window-bottom to top of $elm.
   * @return {Boolean}
   */
  function elIsOnRange($elm, len) {
    var win = $(window),
        len = len || 0,
        viewport = {
          top : win.scrollTop()
        };
    viewport.bottom = viewport.top + win.height();
    var bounds = $elm.offset();
    bounds.bottom = bounds.top + $elm.height();
    return !( (viewport.bottom + len) < (bounds.top) || viewport.top > bounds.bottom);
  }

  return {
    viewportSize: viewportSize,
    scrollPos   : scrollPos,
    elCentering : elCentering,
    elRelRectPos: elRelRectPos,
    elAbsRectPos: elAbsRectPos,
    elIsOnRange: elIsOnRange
  };

})(window, document);

Util.validation = (function () {
  var getFormData = function ($form) {
    var _key, _value, _tag, _type, _required,
        _formData = {
          error: {}
        };

    $($form + ' .js-answer-key').each(function (index, el) {
      var $el = $(el);
      _tag = $el.get(0).tagName;
      if (_tag !== 'INPUT') {
        _type = _tag;
      } else {
        _type = $el.attr('type');
      }

      //init data
      _value = 'non-data';
      _key = $el.attr('name');
      _required = $el.attr('data-required');
      _formData.error[_key] = true;
      //end
      switch (_type) {
        case 'checkbox':
          if (_key.indexOf('[]')) { //multiple checkbox
            var _getValue = [];
            $('input[name="' + _key + '"]').each(function () {
              if ($(this).prop('checked')) {
                _getValue.push($el.val());
              }
            });
            if (_getValue.length > 0) {
              _value = _getValue;
            }
          } else { //single checkbox true|false
            if ($el.prop('checked')) {
              _value = 1;
            } else {
              _value = 0;
            }
          }

          break;
        case 'radio':
          $('input[name=' + _key + ']').each(function () {
            if ($(this).prop('checked')) {
              _value = $(this).val();
            }
          });
          break;
        case 'SELECT':
          if ($el.val() != -1) {
            _value = $el.val();
          }
          break;
        default:
          _value = $el.val();
          break;
      }
      if (_value === 'non-data' && _required) {
        _formData.error[_key] = true;
      } else {
        delete _formData.error[_key];
      }
    });

    return _formData;
  };

  var formControl = function (valid, $form) {
    //control button
    var $next = $($form + ' .js-next-button, .js-submit-button');
    if (valid) {
      $next.removeAttr('disabled');
    } else {
      $next.attr('disabled', 'disabled');
    }
  };

  var actionValid = function (form) {
    form = '#form_' + form;
    var formData = {};
    $(document).on('change', form + ' .js-answer-key, .js-submit-button', function () {
      if ($(this).attr('data-required')) {
        formData = getFormData(form);
        if (jQuery.isEmptyObject(formData.error)) {
          formControl(true, form);
        } else {
          formControl(false, form);
        }
      } else {
        formControl(true, form);
      }
    });
    formData = null;
  };

  return {
    getFormData: getFormData,
    formControl: formControl,
    actionValid: actionValid
  }
})(jQuery);

Widget.elements = (function () {
  return {
    selectBox: function () {
      $('.select__box').each(function() {
        var $select = $(this).children('.select__box__actual');
        var $option = $select.find('option:selected');
        $(this).prepend('<label class="select__box__label">' + $option.text().substr(0, 20) + '</label>');
        if ($(this).children('.select__box__label').length > 1) {
          $(this).children('.select__box__label:first-child').remove();
        }
        var $selectLabel = $(this).children('.select__box__label');

        $select.on('change', function() {
          var $self = $(this);
          var $current = $self.find('option:selected');
          $selectLabel.text($current.text().substr(0, 20));
          $self.blur();
        });
      });
    }
  };
})(jQuery);

Widget.form = (function () {
  // Templates for questions and answers
  var initialData, thisForm,
      inheritData = {},
      initialForm = '001',
      formTarget  = '#risk-reduction-score';

  var formList = ['001', '002', '003', '004', '005-1', '005-2', '005-3', '005-4', '006', '007-1', '007-2', '007-3', '007-4', '007-5', '007-6', '007-7', '008', '009', '010', '011', '013', '015', '017', '018', '020', '022', '023', '024', '027', '030', '031', '032', '033', '034', '035'];

  $.templates('tmplTopic', '<div class="form-topic js-form_{{:#data.current}}" id="form_{{:#data.current}}" style="display: none;">' +
    '  <h3 class="topic__title c">{{:main.title}}</h3>' +
    '  <div class="topic__cover {{:main.image}}">' +
    '  </div>' +
    '  <button type="button" name="prev-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" data-form="{{:#data.prev}}">BACK</button>' +
    '  <button type="button" name="next-question" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" data-form="{{:#data.next}}">Next</button><br>' +
    '</div>');

  $.templates('tmplQuestionMain', '<div class="form-question js-form_{{:#data.current}}" id="form_{{:#data.current}}" style="display: none;position: relative">' +
    '  <div class="question__cat {{:main.id}}">' +
    '    <span class="question__icon {{:main.image}}"></span><span class="question__group">{{:main.group}}</span>' +
    '  </div>' +
    '  <div class="question__main">' +
    '    {{if !main.label}}' +
    '    <h3 class="question__title--first c">{{:main.title}}</h3>' +
    '    {{if main.help}}<p class="question__help c">{{:main.help}}</p>{{/if}}' +
    '    {{else !main.title}}' +
    '    <h4 class="question__title--second c">{{:main.label}}</h4>' +
    '    {{if main.help}}<p class="question__help c">{{:main.help}}</p>{{/if}}' +
    '    {{else}}' +
    '    <h3 class="question__title--first c">{{:main.title}}</h3>' +
    '    {{if main.help}}<p class="question__help c">{{:main.help}}</p>{{/if}}' +
    '    <h4 class="question__title--second c">{{:main.label}}</h4>' +
    '    {{/if}}' +
    '    {{if main.answers.template == "radio-circle"}}' +
    '      {{include main.answers tmpl="tmplRadioCircle" ~data=#data.main ~current=#data.current /}}' +
    '    {{else main.answers.template == "checkbox-option"}}' +
    '      {{include main.answers tmpl="tmplCheckbox" ~data=#data.main ~current=#data.current /}}' +
    '    {{else main.answers.template == "radio-regular"}}' +
    '      {{include main.answers tmpl="tmplRadioRegular" ~data=#data.main ~current=#data.current /}}' +
    '    {{else main.answers.template == "select-option"}}' +
    '      {{include main.answers tmpl="tmplSelect" ~data=#data.main ~current=#data.current /}}' +
    '    {{/if}}' +
    '  </div>' +
    '  {{if #data.next}}' +
    '    {{if #data.current == "008" || #data.current == "009" || #data.current == "031"}}' +
    '  <button type="button" name="back" class="btn btn-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" id="btn_form_{{:#data.prev}}" data-form="{{:#data.prev}}">BACK</button>' +
    '  <button type="button" name="next" class="btn btn-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" id="btn_form_{{:#data.current}}" data-form="{{:#data.next}}">Next</button><br>' +
    '    {{else}}' +
    '  <button type="button" name="back" class="btn btn-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" id="btn_form_{{:#data.prev}}" data-form="{{:#data.prev}}">BACK</button>' +
    '  <button type="button" name="next" class="btn btn-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" id="btn_form_{{:#data.current}}" data-form="{{:#data.next}}" disabled="">Next</button><br>' +
    '    {{/if}}' +
    '  {{else}}' +
    '  <button type="button" name="back" class="btn btn-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" id="btn_form_{{:#data.prev}}" data-form="{{:#data.prev}}">BACK</button>' +
    '  <button type="submit" name="submit" class="btn btn-block btn__regular long btn__regular--uppercase js-submit-button btn-next btn_control" id="btn_form_{{:#data.current}}" disabled="">Next</button><br>' +
    '  {{/if}}' +
    '</div>');

  $.templates('tmplQuestionInherit', '<div class="form-question js-form_{{:#data.current}}" id="form_{{:#data.current}}">' +
    '  <div class="question__cat {{:#data.main.id}}">' +
    '    <span class="question__icon {{:#data.main.image}}"></span><span class="question__group">{{:#data.main.group}}</span>' +
    '  </div>' +
    '  {{props #data.inherit ~data=#data.main}}' +
    '  <div class="question__main">' +
    '    <h4 class="question__title--second c">Are you currently using treatment to control <span class="b">{{>prop}}</span>?</h4>' +
    '    <div id="{{:~data.id}}_{{>key}}" class="answers">' +
    '      {{props ~data.answers.list ~key=key}}' +
    '      <div class="radio__regular">' +
    '        <input type="radio" class="radio__regular__input js-answer-key" id="{{:~data.id}}_{{:~key}}{{>key}}" name="{{:~data.id}}_{{:~key}}" value="{{>key}}" data-required="true">' +
    '        <label class="radio__regular__label" for="{{:~data.id}}_{{:~key}}{{>key}}">{{>prop}}</label>' +
    '      </div>' +
    '      {{/props}}' +
    '    </div>' +
    '  </div>' +
    '  {{/props}}' +
    '  <button type="button" name="back" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-prev-button btn-prev btn_control" id="btn_form_{{:#data.prev}}" data-form="{{:#data.prev}}">BACK</button>' +
    '  <button type="button" name="next" class="btn btn-block btn-inline-block btn__regular long btn__regular--uppercase js-next-button btn-next btn_control" id="btn_form_{{:#data.current}}" data-form="{{:#data.next}}" disabled="">Next</button><br>' +
    '</div>');

  $.templates('tmplQuestionDepend', '<div class="question__depend">' +
    '  <h4 class="question__title--second c">{{:label}}</h4>' +
    '  {{if help}}<p class="question__help">{{:help}}</p>{{/if}}' +
    '  {{if answers.template == "radio-circle"}}' +
    '    {{include answers tmpl="tmplRadioCircle" ~data=#data ~current=#data.current /}}' +
    '  {{else answers.template == "checkbox-option"}}' +
    '    {{include answers tmpl="tmplCheckbox" ~data=#data ~current=#data.current /}}' +
    '  {{else answers.template == "radio-regular"}}' +
    '    {{include answers tmpl="tmplRadioRegular" ~data=#data ~current=#data.current /}}' +
    '  {{else answers.template == "select-option"}}' +
    '    {{include answers tmpl="tmplSelect" ~data=#data ~current=#data.current /}}' +
    '  {{/if}}' +
    '</div>');

  $.templates('tmplRadioCircle', '{{if list.length == 5}}' +
    '<div id="{{:~data.id}}" class="answers answers--5">' +
    '{{else list.length == 6}}' +
    '<div id="{{:~data.id}}" class="answers answers--6">' +
    '{{else list.length == 8}}' +
    '<div id="{{:~data.id}}" class="answers answers--8">' +
    '{{else}}' +
    '<div id="{{:~data.id}}" class="answers">' +
    '{{/if}}' +
    '  <div class="answers__list">' +
    '    {{props list ~default=default ~logical=logical ~suffix=suffix}}' +
    '      {{if key == 6 && prop == "Don\'t know"}}' +
    '  </div>' +
    '  {{if ~suffix}}<div class="answers__suffix">{{:~suffix}}</div>{{/if}}' +
    '  <div class="answers__list">' +
    '      {{/if}}' +
    '    <div class="radio__circle">' +
    '      {{if ~logical}}' +
    '        {{props ~logical ~item=key}}' +
    '          {{if key == ~item}}' +
    '      <input type="radio" class="radio__circle__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}" value="{{>key}}" onclick="PBS.Widget.form.handleLogic(\'{{:~current}}\', \'{{>prop}}\', this);"{{if ~item == ~default}} checked=""{{/if}} data-required="true">' +
    '          {{/if}}' +
    '        {{/props}}' +
    '      {{else}}' +
    '      <input type="radio" class="radio__circle__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}" value="{{>key}}" {{if key == ~default}} checked=""{{/if}} data-required="true">' +
    '      {{/if}}' +
    '      <label for="{{:~data.id}}_{{>key}}" class="radio__circle__inner{{if prop == "Don\'t know"}} radio__circle__inner--long{{/if}}">{{>prop}}</label>' +
    '    </div>' +
    '      {{if key == 6 && prop == "Don\'t know"}}' +
    '  </div>' +
    '      {{/if}}' +
    '    {{/props}}' +
    '  </div>' +
    '  {{if list[6] !== "Don\'t know"}}' +
    '    {{if suffix}}<div class="answers__suffix">{{:suffix}}</div>{{/if}}' +
    '  {{/if}}' +
    '</div>');

  $.templates('tmplRadioRegular', '<div id="{{:~data.id}}" class="answers">' +
    '  {{props list ~default=default ~logical=logical}}' +
    '  <div class="radio__regular">' +
    '    {{if ~logical}}' +
    '      {{props ~logical ~item=key}}' +
    '        {{if key == ~item}}' +
    '    <input type="radio" class="radio__regular__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}" value="{{>key}}" onclick="PBS.Widget.form.handleLogic(\'{{:~current}}\', \'{{>prop}}\', this);"{{if key == ~default}} checked=""{{/if}} data-required="true">' +
    '        {{/if}}' +
    '      {{/props}}' +
    '    {{else}}' +
    '    <input type="radio" class="radio__regular__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}" value="{{>key}}"{{if key == ~default}} checked=""{{/if}} data-required="true">' +
    '    {{/if}}' +
    '    <label class="radio__regular__label" for="{{:~data.id}}_{{>key}}">{{>prop}}</label>' +
    '  </div>' +
    '  {{/props}}' +
    '  {{if suffix}}<div class="answers__suffix">{{:suffix}}</div>{{/if}}' +
    '</div>');

  $.templates('tmplCheckbox', '<div id="{{:~data.id}}" class="answers">' +
    '  {{props list ~default=default ~logical=logical}}' +
    '  <div class="checkbox__styled">' +
    '    {{if ~logical}}' +
    '    <input type="checkbox" class="checkbox__styled__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}[]" value="{{>key}}" onchange="PBS.Widget.form.handleLogic(this, \'{{:~logical}}\');"{{props ~default ~item=key}}{{if prop == ~item}} checked=""{{/if}}{{/props}}{{if ~current != "031"}} data-required="true"{{/if}}>' +
    '    {{else}}' +
    '    <input type="checkbox" class="checkbox__styled__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}[]" value="{{>key}}"{{props ~default ~item=key}}{{if prop == ~item}} checked=""{{/if}}{{/props}}{{if ~current != "031"}} data-required="true"{{/if}}>' +
    '    {{/if}}' +
    '    <label class="checkbox__styled__label" for="{{:~data.id}}_{{>key}}">{{>prop}}</label>' +
    '  </div>' +
    '  {{/props}}' +
    '  {{if suffix}}<div class="answers__suffix">{{:suffix}}</div>{{/if}}' +
    '</div>');

  $.templates('tmplSelect', '<div id="{{:~data.id}}" class="answers">' +
    '  <div class="select__box">' +
    '    <select class="select__box__actual js-answer-key" name="{{:~data.id}}"{{if logical}} onchange="PBS.Widget.form.handleLogic(\'{{:~current}}\', \'{{:logical}}\', this);"{{/if}} data-required="true">' +
    '      {{if ~current == "018" || ~current == "020" || ~current == "021"}}' +
    '      <option value="-1">Select your answer</option>' +
    '      {{/if}}' +
    '      {{props list ~default=default}}' +
    '      <option value="{{>key}}"{{if key == ~default}} selected=""{{/if}}>{{>prop}}</option>' +
    '      {{/props}}' +
    '    </select>' +
    '  </div>' +
    '  {{if suffix}}<div class="answers__suffix">{{:suffix}}</div>{{/if}}' +
    '</div>');

  // Handle browser history for "Back" case
  var historyPush = function (form) {
    window.location.hash = '#' + form;
    //Page.rrs.handleGA(form); //commented for double calling the GA
  };

  var historyReplace = function (form) {
    window.location.hash = '#' + form;
  };

  // Render form on requested
  var renderMain = function (form, target) {
    // Read into the specified form, eg. data.001: {}
    var _render, _data;

    _data = initialData[form];

    if (form == '032') {
      delete _data['inherit'];
      if (!_data['inherit']) {
        _data['inherit'] = inheritData;
      }
      _render = $.render.tmplQuestionInherit(_data);
    } else {
      switch (_data.main.type) {
        case 'topic':
          _render = $.render.tmplTopic(_data);
          break;
        case 'question':
          _render = $.render.tmplQuestionMain(_data);
          break;
        default:
          _render = null;
      }
    }

    if (target) {
      $(_render).insertAfter('#form_' + target);
    } else {
      $(formTarget).append(_render);
    }

    if (form == '027') {
      renderDepend(form);
      renderDepend(form, 1);
    }

    Widget.elements.selectBox();

    _data = _render = null;
  };

  var renderDepend = function (tg, num) {
    var _render,
        _data = initialData[tg].depend,
        _tg = '#form_' + tg;

    for (var i = 0; i < _data.length; i++) {
      _data[i]['current'] = initialData[tg].current;
    }

    if (num) {
      _render = $.render.tmplQuestionDepend(_data[1]);
      $(_render).insertAfter(_tg + ' > .question__depend:eq(0)');
    } else {
      _render = $.render.tmplQuestionDepend(_data[0]);
      $(_render).insertAfter(_tg + ' > .question__main');
    }
    Widget.elements.selectBox();

    _render = _data = null;
  };

  var handleLogic = function (el, action, itself) {
    if (itself) {
      var itsId = '#' + itself.id;
      $(itsId).off('change');
    }

    if (el !== null && typeof el !== 'object') {
      var $el = $('#form_' + el);
    }

    var _action = action.split('-'),
        logic = action;

    if (_action != action) {
      logic = _action[0];
    }
    switch (logic) {
      case 'paintDepend':
        if (_action[1]) {
          if ($el.children('.question__depend').length == 1) {
            renderDepend(el, 2);
          }
        } else {
          if (!$el.children('.question__depend').length) {
            renderDepend(el);
          }
        }
        break;
      case 'destroyDepend':
        if (el == '013') {
          $('#btn_form_013').attr('data-form', '017');
        }
        $el.children('.question__depend').remove();
        break;
      case 'collectData':
        if (_action[1] == '031') {
          $('#btn_form_031').attr('data-form', '032');
          if (el.checked && !inheritData[el.value]) {
            inheritData[el.value] = $('#' + el.id).next().text();
          } else {
            delete inheritData[el.value];
          }

          el = el.id;
        }
        break;
      case 'skippable':
        if ($el.children('.js-next-button').length == 1) {
          $('#btn_form_' + el).attr('data-form', _action[1]);
        }
        break;
      case 'skipHistory':
        var elOneLv = formList[formList.indexOf(el) - 1],
            $elOneLv = $('#form_' + elOneLv),
            elTwoLv = formList[formList.indexOf(el) - 2],
            $elTwoLv = $('#form_' + elTwoLv);
        if (_action[1] == 'noskip') {
          if ($el.length == 0) {
            renderMain(el, elOneLv);
          } else {
            if (el == '032') {
              $el.remove();
              renderMain(el, elOneLv);
            }
          }
        } else {
          if ($el.length == 0) {
            renderMain(el, elTwoLv);
          }
        }
        historyReplace(el);
        $elTwoLv.hide();
        $elOneLv.hide();
        break;
      default:
        break;
    }

    Util.validation.actionValid(el);
    if (itself) {
      $(itsId).trigger('change');
    }
  };

  var readData = function () {
    var $defer = new $.Deferred;
    $.getJSON('../data/data.json').success(function (data) {
      initialData = data;
      $defer.resolve();
    });
    return $defer.promise();
  };

  var handleProgess = function (form) {
    var total = formList.length,
        current = formList.indexOf(form) + 1,
        percent = (current/total)*100;

    percent = percent.toFixed(0);

    $('#progress__percent__current').animate({
      left: percent + '%'
    }, {
      duration: 800,
      start: function () {
        $('#progress__bar__current').animate({
          width: percent + '%'
        }, 800);
      }
    }, 800);
    $('#progress__percent__current span').text(percent);
  };

  var initialRender = function (formData) {
    historyPush(initialForm);
    var _initialRender = $.render.tmplTopic(initialData[initialForm]);
    $(formTarget).append(_initialRender);
    $('#form_' + initialForm).show();
    _initialRender = null;
  };

  return {
    formList: formList,
    readData: readData,
    renderMain: renderMain,
    renderDepend: renderDepend,
    initialRender: initialRender,
    handleLogic: handleLogic,
    handleProgess: handleProgess,
    historyPush: historyPush,
    historyReplace: historyReplace
  }
})(jQuery);

Widget.surveyModule = function ($) {
  var $reply = $('.js-render-reply');

  var init = function () {
    _bind();
  };

  var _bind = function () {
    $('.js-choice-reply').on('change', function () {
      _onReply($(this));
    });
  };

  var _onReply = function (e) {
    if (e.prop('checked')) {
      var _reply_type = e.val();
      $reply.filter('[data-reply!="' + _reply_type + '"]').addClass('is-hidden');
      $reply.filter('[data-reply="' + _reply_type + '"]').removeClass('is-hidden');
      $('input[name="' + _reply_type + '-willing"]').prop('checked', false);
    }
  };

  return {
    init: init
  };

}(jQuery);

Page.all = function($) {
  var init = function() {
    $(function() {
      FastClick.attach(document.body);
    });
  };

  return {
    init: init
  };
}(jQuery);

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

    $(document).on('click', '.js-prev-button', function () {
      $currentForm = $(this).parent();
      var currentId = $currentForm.attr('id').split('_')[1];

      prev = $(this).attr('data-form');
      $prevForm = $('#form_' + prev);

      if(currentId == '001') {
        var targetWinUrl = window.location.origin+'/';
        window.location.replace(window.location.origin);
      }

      if(currentId == '017') {
        if($('#form_015').length > 0) {
          prev = prev;
        } else {
          prev = '013';
        }
      }

      Widget.form.historyPush(prev);
      $currentForm.hide();
      $('html body').animate({scrollTop: 0}, 'fast');
      $('#form_' + prev).show();
      toggleProgess(prev);
      Widget.form.handleProgess(prev);
      Util.validation.actionValid(prev);
    });
  };

  var toggleProgess = function (next) {
    if ($('#form_' + next).hasClass('form-question')) {
      $('.progress').removeClass('hidden');
    } else {
      $('.progress').addClass('hidden');
      $('#total-progress-container').removeClass('hidden');
    }
  };

  var handleGA = function (form) {
    ga('set', 'page', '/rrs/' + form);
    ga('send', 'pageview', document.location.pathname+'/'+form);
  };

  return {
    init: init,
    handleGA: handleGA
  };
}(jQuery);

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
      'Sorry, our service is targeted at 18 to 90 years old.'
    );

    $.validator.addMethod('feet',
      function (value, element) {
        var feetValue = parseInt(value);
        if((feetValue < 4) || (feetValue > 7)){
          return false;
        }else {
          return true;
        }
      },
      'Sorry, our service is targeted at 4 feet to 7 feet.'
    );

    $.validator.addMethod('inch',
      function (value, element) {
        var inchValue = parseInt(value);
        if((inchValue < 0) || (inchValue > 11)){
          return false;
        }else {
          return true;
        }
      },
      'Plese enter only from 0 to 11 inches.'
    );

    $.validator.addMethod('cm',
      function (value, element) {
        var cmValue = parseInt(value);
        if((cmValue < 100) || (cmValue > 210)){
          return false;
        }else {
          return true;
        }
      },
      'Sorry, our service is targeted at 100 to 210cm.'
    );

    $.validator.addMethod('lbs',
      function (value, element) {
        var lbValue = parseInt(value);
        if((lbValue < 60) || (lbValue > 1000)){
          return false;
        }else {
          return true;
        }
      },
      'Sorry, our service is targeted at 60 to 1,000lbs.'
    );

    $.validator.addMethod('kg',
      function (value, element) {
        var kgValue = parseInt(value);
        if((kgValue < 27) || (kgValue > 450)){
          return false;
        }else {
          return true;
        }
      },
      'Sorry, our service is targeted at 27 to 450kg.'
    );

    $('#form_profile').validate({
      ignore: [],
      focusInvalid: false,
      invalidHandler: function(event, validator) {
        var errors = validator.numberOfInvalids();
        var errorList = validator.errorList;
        if (errors > 0) {
          $.each(errorList, function (index, el) {
            if (el.element.name == 'first_name') {
              el.element.name = 'first_name';
            } else if (el.element.name == 'last_name') {
              el.element.name = 'last_name';
            } else if (el.element.name == 'mobile_phone') {
              el.element.name = 'mobile_no';
            } else if (el.element.name == 'height') {
              ga('send', 'event', 'form_039', 'height_unit', 'validation', null);
            } else if (el.element.name == 'weight') {
              ga('send', 'event', 'form_039', 'weight_unit', 'validation', null);
            }else if (el.element.name == 'news_letter_flag') {
              ga('send', 'event', 'form_039', 'news_letter_flag', 'validation', null);
            }
            ga('send', 'event', 'form_039', el.element.name, 'validation', null);
          });
        }
      },
      errorElement: 'div',
      errorClass: 'error_message',
      rules: {
        first_name: {
          required: true,
          minlength: 1,
          maxlength: 50
        },
        last_name: {
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
          required: true,
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
          feet: true
        },
        height_inches: {
          number: true,
          inch: true
        },
        weight: {
          required: true,
          number: true,
          lbs: true
        }
      }
    });

    $(document).on('change', 'input[name="height_unit"]', function () {

      if ($(this).val() == 1) {
        $('#height_inches').hide();
        $('input[name="height"]').attr({
          placeholder: 'cm'
        });
        $('.height-unit-label').hide();
        $('input[name="height"]').rules('add', {
          required: true,
          number: true,
          feet: false,
          cm: true
        });
        $('input[name="height_inches"]').val('');
      } else {
        $('#height_inches').show();
        $('.height-unit-label').show();
        $('input[name="height"]').attr({
          placeholder: 'ft'
        });
        $('input[name="height"]').rules('add', {
          required: true,
          number: true,
          feet: true,
          cm: false
        });
      }
      $('#height').valid();
      $('#height_inches').valid();
    });

    $(document).on('change', 'input[name="weight_unit"]', function () {
      if ($(this).val() == 1) {
        $('input[name="weight"]').attr({
          placeholder: 'kg'
        });
        $('input[name="weight"]').rules('add', {
          required: true,
          number: true,
          lbs: false,
          kg: true
        });
      } else {
        $('input[name="weight"]').attr({
          placeholder: 'lbs'
        });
        $('input[name="weight"]').rules('add', {
          required: true,
          number: true,
          lbs: true,
          kg: false
        });
      }
      $('#weight').valid();
    });

    $(document).on('change', 'input[name="out_of_us"]', function () {

      var oouVal = $('input[name=out_of_us]:checked', '#form_profile').val();

      if (oouVal == 1) {
        $('#zip_cond_req').html('');
        $('input[name="zip_code"]').rules('add', {
          required: false,
          number: false,
          minlength: 0,
          maxlength: 100
        });
      } else {
        $('#zip_cond_req').html('*');
        $('input[name="zip_code"]').rules('add', {
          required: true,
          number: true,
          minlength: 5,
          maxlength: 5
        });
      }
      $('#zip_code').valid()
    });

    $(document).on('change', 'input[name="news_letter_flag"]', function () {

      var nlVal = $('input[name=news_letter_flag]:checked', '#form_profile').val();

      if(nlVal=='yes'){
        $('#profile-submit-btn').removeAttr('disabled');
      }else {
        $('#profile-submit-btn').attr({
          disabled: 'disabled'
        });
      }
    });

    $('#modal-confirm').modal('hide');
    $('#btn-modal-ok').on('click', function(e) {
      var targetWinUrl = window.location.origin+'/rrs';
      window.location.replace(targetWinUrl);
    });
  };
  return {
    init: init
  };
}(jQuery);

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
        this.chart.ctx.font = 'bold 24px "source_sans_prosemibold"';
        this.chart.ctx.fillStyle = 'white';
        this.chart.ctx.textBaseline = 'middle';
        if (this.segments[0].value == '100') {
          this.chart.ctx.fillText(this.segments[0].value + '/100', this.chart.width / 2 - 43, this.chart.width / 2, 100);
        } else {
          this.chart.ctx.fillText(this.segments[0].value + '/100', this.chart.width / 2 - 35, this.chart.width / 2, 100);
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
            //$('.content').animate({ scrollTop: Offset }, '800');
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

})(this);

window.onhashchange = function() {

 var targetWinUrl = window.location.origin+'/rrs';

 if(window.location.href==targetWinUrl){
  window.location.replace(window.location.origin);
 }

}
