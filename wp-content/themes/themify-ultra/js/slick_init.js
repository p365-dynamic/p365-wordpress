jQuery(document).ready(function($) {
    $('.center_review').slick({
        centerMode: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false,
        centerPadding: '0px',
        slidesToShow: 3,
        focusOnSelect: true,
        touchMove: true,
        responsive: [{
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '20px',
                    slidesToShow: 1
                }
            }
        ]
    });
    $('.slider-for').slick({
        dots: true,
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 640,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });

    $('.slick_slide_mob').slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });
    $('.slick_slide_mob_partners').slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });
    $('.car-insurance-slider').slick({
        dots: true,
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 2
    });
    //condition for checking if user has logged in from angular app
    var logoutBtn = localStorage.getItem("loggedIn");


    setTimeout(function() {
        if (logoutBtn == "true") {

            $('.logout_link').closest('li').attr('style', 'display:inline-block !important');
        } else {
            $('.logout_link').closest('li').attr('style', 'display:none !important');

        }
    }, 100);
});