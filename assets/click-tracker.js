jQuery(document).ready(function($){
  $('a').on('click', function(){
    var href = $(this).attr('href');
    if (href && href.includes("microsoft.com")) {
      $.post(mvp_ajax.ajax_url, {
        action: 'mvp_log_click',
        nonce: mvp_ajax.nonce,
        url: href
      });
    }
  });
});