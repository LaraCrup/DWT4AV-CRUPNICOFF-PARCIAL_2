$(document).ready(function () {
    $('#cakesSlider').slick({
        infinite: true,
        arrows: true,
        dots: false,
        centerMode: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev">❮</button>',
        nextArrow: '<button type="button" class="slick-next">❯</button>',
        responsive: [
            {
                breakpoint: 540,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2.2,
                    arrows: false,
                }
            },
            {
                breakpoint: 1080,
                settings: {
                    slidesToShow: 3,
                    arrows: true,
                }
            },
            {
                breakpoint: 1280,
                settings: {
                    slidesToShow: 3,
                    arrows: true
                }
            },
            {
                breakpoint: 1500,
                settings: {
                    slidesToShow: 4,
                    arrows: true
                }
            }
        ]
    });

    setTimeout(() => {
        $('.carouselContainer').addClass('animate');
    }, 100);
});