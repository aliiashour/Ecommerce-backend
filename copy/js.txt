$(document).ready(function(){
    $(".chose span").click(function(){

        $(this).addClass("active").siblings().removeClass("active") ;
        $(".form").fadeOut(0)  ;
        $('.' + $(this).data("class")).fadeIn() ; 
    }) ;
    // make password visible
    $(".show-pass").hover(function(){
        $(".pass").attr('type', 'text') ; 
    }, function(){
        $(".pass").attr('type', 'password') ; 
    });
    // confirm deleting members
    $(".confirm").click(function(){
        return confirm("Are You Sure ?") ; 
    });

    // Make Live Preview

    $('.ads .live-name, .ads .live-desc, .ads .live-price').on('keyup', function(){
        $(".live-preview ." + $(this).data('scope')).text( $(this).val() ) ;
    }) ; 

});