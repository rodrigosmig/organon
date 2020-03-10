$(function() {
    $(".collapse").on('show.bs.collapse', function() {
        $(this).parent().parent().prev().find('.expand i').removeClass('fa-plus').addClass('fa-minus')       
    }).on('hide.bs.collapse', function(){
        $(this).parent().parent().prev().find('.expand i').removeClass('fa-minus').addClass('fa-plus')       
    });
})
