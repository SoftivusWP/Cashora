jQuery(document).ready(function($) {
   /* scroll to # */
   $('.cbtrkr_scroll').on('click',function (e) {
      e.preventDefault();
      if (typeof $(this).data('scrollto') !== 'undefined') {
         var target = $(this).data('scrollto');
         var hash = $(this).data('scrollto');
      } 
      else {
         var target = $(this.hash + ', a[name="'+ this.hash.replace(/#/,"") +'"]').first();
         var hash = this.hash;
      }

      var $target = $(target);
      if($target.length !==0){
          $('html, body').stop().animate({
             'scrollTop': $target.offset().top - 45
          }, 500, 'swing', function () {
            if(history.pushState) {
              history.pushState(null, null, hash);
            }
            else {
              window.location.hash = hash;
            }
          });
      }
   }); 
});