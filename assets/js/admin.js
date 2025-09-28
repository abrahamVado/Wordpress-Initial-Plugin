(function($){
  // # Super Comments
  // #1 PURPOSE: Minimal jQuery admin script wired to a sample button.
  // #2 HOW: Enqueued via Admin::enqueueAdmin().

  $(document).on('click', '#demo-plugin-ping', function(){
    const url = (window.wpApiSettings && window.wpApiSettings.root)
      ? window.wpApiSettings.root + 'demo-plugin/v1/oauth/verify'
      : '/wp-json/demo-plugin/v1/oauth/verify';

    $('#demo-plugin-output').text('Pinging ' + url + ' ...');

    $.ajax({
      url: url,
      method: 'GET',
      headers: { 'Authorization': 'Bearer dev-token' }
    }).done(function(res){
      $('#demo-plugin-output').text(JSON.stringify(res, null, 2));
    }).fail(function(xhr){
      $('#demo-plugin-output').text('Error ' + xhr.status + ': ' + xhr.responseText);
    });
  });

})(jQuery);
