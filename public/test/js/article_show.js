//funksion per clik te zemres ne nje post te caktuar
$(document).ready(function (){
   $('.js-like-article').on('click', function (e){
      e.preventDefault();
      var $link = $(e.currentTarget);
      $link.toggleClass('fa-heart-o').toggleClass('fa-heart');
      $.ajax({
         method:'POST',
         url:$link.attr('href')
      }).done(function (data){
         $('.js-like-article-count').html(data.hearts);
      });
   });
});