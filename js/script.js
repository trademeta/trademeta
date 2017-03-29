var w = $(window).width();

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

//========= Slider =========
$('.slick-slider').slick({
    pauseOnHover: false,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 5000,
    arrows: true,
    prevArrow: $('#prev'),
    nextArrow: $('#next')
});

//========= Написать сообщение =========
$('.send-mess a').magnificPopup({
    items: {
        type: 'inline',
        src: $('.form-block .wrap').clone()
    },
    callbacks: {
        open: function() {
            setTimeout(function () {
                formValidate($('.mfp-content .form'));
            },50);
        }
    },
    preloader: false,
    removalDelay: 500,
    mainClass: 'mfp-fade',
    midClick: true
});
//========= Портфолио - Подробнее =========



//========= Виды вёрстки =========
var layoutsContent = $('.layouts__content'),
    $l0 = $('.l0'),
    $l1 = $('.l1'),
    $l2 = $('.l2');
if(w>768) {
    var l0 = {'top': $l0[0].offsetTop, 'left': $l0[0].offsetLeft},
        l1 = {'top': $l1[0].offsetTop, 'left': $l1[0].offsetLeft},
        l2 = {'top': $l2[0].offsetTop, 'left': $l2[0].offsetLeft};
    layoutsContent.on('mouseenter', function () {
        if (layoutsContent.hasClass('actived')) {
            $(this).find('span').stop().each(function (i, el) {
                var $el = $(el);
                i == 0 && $el.removeClass('rubberBand').addClass('visible');
                i == 2 && $el.removeClass('rollIn').addClass('visible');

                $el.css({
                    'position': 'absolute',
                    'left': window['l' + i].left,
                    'top': window['l' + i].top
                }).stop().animate({
                    'top': '63px',
                    'left': ((i * 150) - 150) + window['l' + i].left + 'px'
                }, 1000, function () {
                    if (i == 0) {
                        $el.addClass('rubberBand');
                    }
                });
            });
            $({rotate: 0}).animate({
                rotate: -360
            }, {
                duration: 1000,
                step: function (now, fx) {
                    $l2.css('transform', 'rotate(' + now + 'deg)')
                }
            })
        }
    }).on('mouseleave', function () {
        $(this).find('span').stop().each(function (i, el) {
            $(el).animate({
                'left': window['l' + i].left,
                'top': window['l' + i].top
            }, 1000);
        });
    });
}

if(w<=768) {
    layoutsContent.on('click',function() {
        $l0.removeClass('rubberBand').addClass('visible');
        setTimeout(function() {
            $l0.addClass('rubberBand');
        },50);
        $l2.removeClass('rollIn').addClass('visible');
        $({rotate:0}).animate({
            rotate:-360
        },{
            duration:1000,
            step:function(now,fx) {
                $l2.css('transform','rotate('+now+'deg)')
            }
        })
    })
}
(function () {
    var wp, $el = $l0;
    wp = $el.waypoint(function () {
        $el.addClass('rubberBand');
        $l2.addClass('rollIn');
        layoutsContent.addClass('actived');
        wp[0].destroy();
    }, {
        offset: '65%'
    });
})();
//========= Виды вёрстки: End =========

//========= Portfolio =========
var $book = $('.book'),
    $nobook = $('.nobook'),
    $bookLeft = $('.book-left'),
    $bookRight = $('.book-right'),
    $changeView = $('.change-view');

$changeView.data('view', false);

function bookStart() {
    $book.turn({
        page: 2,
        width: '100%',
        height: '100%',
        autoCenter: true,
        when: {
            turned: function (e, p, o) {
                if (p >= 26) {
                    $('.order').on('click', function () {
                        var scrol = $('.form-block').offset().top;
                        $('html, body').stop().animate({
                            scrollTop: scrol
                        });
                    })
                }
                //Портфолио - Подробнее
                $('.book a.more').on('click', function(e){
                    e.preventDefault();
                    var $parent = $(this).closest('div'),
                        $more = $parent.find('.more-block'),
                        $popup = $('.popup'),
                        $popupContent = $popup.find('.popup__content');
                    if($popupContent.children().length == 0) {
                        $more.clone().appendTo($popupContent);
                    }
                    $popup.fadeIn(500).on('click', function(e){
                        $popup.fadeOut(500, function() {
                            $popupContent.html('');
                        });
                    });
                });
            }
        }
    });
    $bookLeft.on('click', function () {
        $book.turn('previous');
    });
    $bookRight.on('click', function () {
        $book.turn('next');
    });
}
bookStart();

//========= Смена вида портфолио =========
$changeView.on('click',function() {
    var $this = $(this),
        view = $this.data('view');
    $this.data('view', !view);
    if($book.is(':visible')) {
        $book.hide().turn("disable",true);
        $nobook.fadeIn(1000).find('.pages').addClass('grid');
        if(isMobile.any() || w<768){
            $nobook.addClass('mob');
        }
        $('.book-left,.book-right').fadeOut(300);
    }else{
        $nobook.removeClass('mob').hide();
        $book.fadeIn(1000).turn('disable', false);
        $('.book-left,.book-right').fadeIn(300);
        var size = turnResize($book);
        $book.turn('size', size.width, size.height);
    }
});

//Тёмный фон с детальным обзором
$(document).on('click','.nobook.mob .pages', function () {
    $(this).find('.pages1').toggleClass('mobpage1');
});

if (w < 768) {
    $changeView.data('view', true);
    $('.book,.book-left,.book-right').hide();
    $('.nobook .pages').addClass('grid');
    $nobook.css('display', 'inline-block').addClass('mob');
} else if(w >= 768) {
    $nobook.hide();
    $('.boook-left,.boook-right').fadeIn(300);
}

$('.nobook .pages a').on('click', function(e){
    var $target = $(e.target);
    if($target.is('a.more')){
        e.preventDefault();
        var $parent = $(this).closest('div'),
            $more = $parent.find('.more-block'),
            $popup = $('.popup'),
            $popupContent = $popup.find('.popup__content');
        if($popupContent.children().length == 0) {
            $more.clone().appendTo($popupContent);
        }
        $popup.fadeIn(500);
        $popup.on('click', function(e){
            $popup.fadeOut(500, function() {
                $popupContent.html('');
            });
        });
        return false;
    }
});

//book resize
$(window).resize(function() {
    w = $(window).width();
    var juxtapose = $('.juxtapose'),
        juxtWrap = juxtapose.closest('.wrap'),
        view = $changeView.data('view');
    juxtapose.width(juxtWrap.width());
    var size = turnResize($book);
    if (w < 768) {
        if($book.is(':visible')){
            $('.book,.book-left,.book-right').hide();
            $('.nobook .pages').addClass('grid');
            $nobook.css('display', 'inline-block').addClass('mob');
        }
        if(!$book.turn("disabled")) {
            $book.turn('disable', true);
        }
    } else if(w >= 768) {
        if(!view) {
            $book.turn('resize');
            $book.turn('size', size.width, size.height);
            if($nobook.is(':visible')){
                $nobook.removeClass('mob').hide();
                $('.book,.book-left,.book-right').show();
            }
            if($book.turn("disabled")) {
                $book.fadeIn(1000).turn('disable', false);
            }
        }
    }
});
function turnResize(el) {
    el[0].style.width = '';
    el[0].style.height = '';

    var wrap = el.closest('.wrap'),
        width = wrap.width(),
        height = el.height();

    el[0].style.width = width + 'px';
    el[0].style.height = height + 'px';

    return {
        width: width,
        height: height
    };
}
//========= Portfolio: End =========

//========= Form =========
function formValidate(form) {
    form.validate({
        debug: true,
        errorPlacement: function (error, element) {
            error.appendTo(element.next("span"));
        },
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 15
            },
            email: {
                required: true,
                minlength: 5,
                maxlength: 25
            },
            textarea: {
                required: true,
                minlength: 10,
                maxlength: 200
            }
        },
        submitHandler: function () {
            var data = {};
            form.find('input:not([type="submit"]), textarea').each(function (i, el) {
                data[el.id] = $(el).val();
            });
            $.ajax({
                type: "POST",
                url: '/components/form.php',
                data: data,
                success: function(data){
                    if(data=='mail sent'){
                        var $popup=$('.popup'),
                            $popupContent = $popup.find('.popup__content');
                        $popupContent.html('Сообщение отправлено. В ближайшее время ваше сообщение будет обработано');
                        $popup.fadeIn(500);
                        setTimeout(function () {
                            $popup.fadeOut(500,function() {
                                $popupContent.html('');
                            });
                        },4000)
                    }
                }
            });
            if(form.closest('.mfp-content').length){
                $.magnificPopup.close();
            }
        }
    });
}
formValidate($('.form'));
//========= Form: End =========

//========= Menu =========
var $menu = $('nav#menu'),
    $menuLink = $('.menu-link');
$menu.mmenu();
var api = $menu.data('mmenu');
$menuLink.on('click', function (e) {
    $(this).fadeOut(200);
});
api.bind('closed', function (e) {
    $menuLink.fadeIn(200);
});

$menu.find('a').not('.change-view, .mm-title').on('click', function () {
    var $el = $(this),
        link = $el.data('link'),
        scrol=$('.'+link).offset().top;
    $('html, body').stop().animate({
        scrollTop: scrol
    });
});
//========= Menu: End =========

setTimeout(function () {
    var jxImage = $('.jx-image');
    if (jxImage.length) {
        jxImage.each(function (i, el) {
            var img = $(el).find('img');
            if(img[0].hasAttribute('width')){
                img.removeAttr('width');
            }
        })
    }
}, 50);

$('.trademeta').on('click', function(e){
    $('html, body').stop().animate({
        scrollTop: 0
    });
});
