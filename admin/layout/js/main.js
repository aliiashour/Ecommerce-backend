$(document).ready(function(){
    // dashboard
    $(".panel-heading .toogle-body").click(function(){
        $(this).toggleClass("done").parent().next(".panel-body").slideToggle("slow") ;

    }) ; 
    // Toogle Placeholder When Pointer
    $("[placeholder]").focus(function(){
        $(this).attr('data-set' ,$(this).attr('placeholder')) ; 
        $(this).attr('placeholder', '');
    }).blur(function(){
        $(this).attr('placeholder', $(this).attr('data-set')) ;
    });
    
    // add aterist to required field of edit form
    $(":required").after("<span class='aterisk'>*</span>")  ;
    
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
    // make animation for categores buttons
    $(".categores .cat").hover(
        function(){
            $(this).children(".hidden-buttons").animate({
                marginRight: 0
            }, 500);
        }, function(){
            $(this).children(".hidden-buttons").animate({
                marginRight: -200
            }, 500);
        }) ;
    $(".categores .cat h4").click(function(){
        $(this).next(".toggleView").toggleClass("hideDescribtion") ;  
    });
    // onpress checkbox
    
    var myCarousel = document.querySelector('#myCarousel')
    var carousel = new bootstrap.Carousel(myCarousel)

});