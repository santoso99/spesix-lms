$(document).ready(function(){
    /*-------------------------------------
      jquery Scollup activation code
    -------------------------------------*/
    $("#preloader").fadeOut("slow", function () {
      $(this).remove();
    });
    /*-------------------------------------
        All Checkbox Checked
    -------------------------------------*/
    $(".checkAll").on("click", function () {
      $(this).parents('.table').find('input:checkbox').prop('checked', this.checked);
    });

    /*-------------------------------------
          Select 2 Init
      -------------------------------------*/
      if ($.fn.select2 !== undefined) {
        $('.select2').select2({
          width: '100%'
        });
      }

    $(".clickable-row").on("click",function() {
        window.location = $(this).data("href");
    });
    $(".radio-label").on("click", function(){
      $(".radio-label").css("background-color","");
      $(this).css("background-color","#C9F5A5");
    });
    $(function () {
      $('[data-toggle="popover"]').popover({
        html: true,
      });
    });
});