/*
 * fetch
 */
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
