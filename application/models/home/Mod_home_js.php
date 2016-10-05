<?php

class Mod_home_js extends CI_Model {

     function __construct() {
        parent::__construct();
    }

    public function index() {
        $js = <<<JAVASCRIPT

            function scrollOn() {
                document.body.onmousewheel = function () { return true; };
            }

            function scrollOff() {
                document.body.onmousewheel = function () { return false; };
            }

            $(function(){
                var conceptLock = false;
                var lookbookLock = false;
                var editorialLock = false;
                $(window).on('scroll', function(){
                    var bodyPos = $('body').scrollTop(),
                        conceptPos = $('.concept').offset().top,
                        lookbookPos = $('.lookbook').offset().top,
                        editorialPos = $('.editorial').offset().top;
                    if (conceptPos - bodyPos <50 && !conceptLock) {
                        $('.concept .area.area1').animate({
                            opacity:1
                        }, 300, function(){

                            $('.concept .area.area2').animate({
                                opacity:1
                            }, 300, function(){

                                $('.concept .area.area3').animate({
                                    opacity:1
                                }, 300)

                            })

                        })
                        conceptLock = true;
                    }
                    if (lookbookPos - bodyPos <50 && !lookbookLock) {
                        $('.lookbook .area.area1').animate({
                            opacity:1
                        }, 300, function(){

                            $('.lookbook .area.area2').animate({
                                opacity:1
                            }, 300, function(){

                                $('.lookbook .area.area3').animate({
                                    opacity:1
                                }, 300)

                            })

                        })
                        lookbookLock = true;
                    }
                    if (editorialPos - bodyPos <50 && !editorialLock) {
                        $('.editorial .area.area1').animate({
                            opacity:1
                        }, 300, function(){

                            $('.editorial .area.area2').animate({
                                opacity:1
                            }, 300, function(){

                                $('.editorial .area.area3').animate({
                                    opacity:1
                                }, 300)

                            })

                        })
                        editorialLock = true;
                    }


                })
            });

            $(function(){

                $('.backToTop').click(function(){
                    $('html, body').animate({scrollTop: 0}, 1000);
                });

                $('#carouselMulti').carousel({
                    interval: false,
                    pause:true
                })

                $('#carouselSingle').carousel({
                    interval: false,
                    pause:true
                })

                $('#carouselMulti.carousel .item').each(function(){
                    var next = $(this).next();
                    if (!next.length) {
                        next = $(this).siblings(':first');
                    }
                    next.children(':first-child').clone().appendTo($(this));

                    if (next.next().length>0) {
                        next.next().children(':first-child').clone().appendTo($(this));
                    }
                    else {
                        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
                    }
                });

            });

JAVASCRIPT;
        $this->myjs->add($js);
    }

}
