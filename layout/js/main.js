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

/*
    setInterval(function(){
        check_user_auth() ; 
    },2000);

    function check_user_auth(){        
        jQuery.ajax({
            url:'user_auth_session.php',
            type:'post',
            data:'type=ajax',
            success:function(res){
                if(res=='logout'){
                    
                    window.location.href='logout.php';
                }
            }
        });
    }
    */
    // $('.carousel').carousel()
    var myCarousel = document.querySelector('#myCarousel')
    var carousel = new bootstrap.Carousel(myCarousel)

    $(".pies ul li .text-truncate, .comment .text-truncate").on("click",function(){
        $(this).toggleClass("text-truncate") ; 
        // $(this).text($(this).val()) ; 
    });
    $(".prov-items .comm").on("click",function(){
        $(this).toggleClass("text-truncate") ; 
        // $(this).text($(this).val()) ; 
    });
    
});
