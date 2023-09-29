/**
 * Theme scripts
 */
(function( mdBone, $, undefined ) {

"use strict";

    /* ============================================================================
     * minimalDog utility
     * ==========================================================================*/

    var Util = {

        getBackendVar: function(variable_name) {
            if (typeof window['mdBoneVar'] === 'undefined') {
                return '';
            }
            if (arguments.length == 1) {
                return window['mdBoneVar'][variable_name];
            } else {
                var b = arguments[1]; // take second argument
                return window['mdBoneVar'][variable_name][b];
            }
        },

        moveY: function (elm, value) {
            var translate = 'translate3d(0px,' + value + 'px, 0)';
            elm.style['-webkit-transform'] = translate;
            elm.style['-moz-transform'] = translate;
            elm.style['-ms-transform'] = translate;
            elm.style['-o-transform'] = translate;
            elm.style.transform = translate;
        },

    };
    

    /* ============================================================================
     * minimalDog event
     * ==========================================================================*/

    var EventsListener = {

        //the events - we have timers that look at the variables and fire the event if the flag is true
        scroll_event_slow_run: false,
        scroll_event_medium_run: false,

        resize_event_slow_run: false, //when true, fire up the resize event
        resize_event_medium_run: false,


        scroll_window_scrollTop: 0, //used to store the scrollTop

        window_innerHeight: window.innerHeight, // used to store the window height
        window_innerWidth: window.innerWidth, // used to store the window width

        init: function init() {

            var smartAffixOn = Util.getBackendVar('stickyHeader', 'toggle'); // Check if smartAffix is enabled

            $(window).scroll(function() {
                EventsListener.scroll_event_slow_run = true;
                EventsListener.scroll_event_medium_run = true;

                
                
            });


            $(window).resize(function() {
                EventsListener.resize_event_slow_run = true;
                EventsListener.resize_event_medium_run = true;

                
            });



            //medium resolution timer for rest?
            setInterval(function() {
                //scroll event
                if (EventsListener.scroll_event_medium_run) {
                    EventsListener.scroll_event_medium_run = false;

                    // Functions to run
                    
                    //read the scroll top
                    EventsListener.scroll_window_scrollTop = $(window).scrollTop();
                    
                    /*  ----------------------------------------------------------------------------
                     Run affix menu event
                     */
                    if (smartAffixOn == '1') {
                        smartAffix.eventScroll(EventsListener.scroll_window_scrollTop); //main menu affix   
                    }
                    

                }

                //resize event
                if (EventsListener.resize_event_medium_run) {
                    EventsListener.resize_event_medium_run = false;

                    if (smartAffixOn == '1') {
                        smartAffix.compute(); //main menu affix     
                    }

                }
            }, 10);



            //low resolution timer for rest?
            setInterval(function() {
                //scroll event
                if (EventsListener.scroll_event_slow_run) {
                    EventsListener.scroll_event_slow_run = false;

                    // Functions to run
                }

                //resize event
                if (EventsListener.resize_event_slow_run) {
                    EventsListener.resize_event_slow_run = false;
    
                    Detect.run_is_phone_screen();
                }
            }, 500);

        }
    };

    EventsListener.init();


    /* ============================================================================
     * minimalDog browser detection
     * ==========================================================================*/

    var Detect = new function () {

        //constructor
        this.is_ie8 = false;
        this.is_ie9 = false;
        this.is_ie10 = false;
        this.is_ie11 = false;
        this.is_ie = false;
        this.is_safari = false;
        this.is_chrome = false;
        this.is_ipad = false;
        this.is_touch_device = false;
        this.has_history = false;
        this.is_phone_screen = false;
        this.is_ios = false;
        this.is_android = false;
        this.is_osx = false;
        this.is_firefox = false;

        // is touch device ?
        this.is_touch_device = !!('ontouchstart' in window);
        this.is_mobile_device = false;

        this.html_jquery_obj = $('html');

        // detect ie8
        if (this.html_jquery_obj.is('.ie8')) {
            this.is_ie8 = true;
            this.is_ie = true;
        }

        // detect ie9
        if (this.html_jquery_obj.is('.ie9')) {
            this.is_ie9 = true;
            this.is_ie = true;
        }

        // detect ie10 - also adds the ie10 class //it also detects windows mobile IE as IE10
        if(navigator.userAgent.indexOf("MSIE 10.0") > -1){
            this.html_jquery_obj.addClass("ie10");
            this.is_ie10 = true;
            this.is_ie = true;
            //alert('10');
        }

        //ie 11 check - also adds the ie11 class - it may detect ie on windows mobile
        if(!!navigator.userAgent.match(/Trident.*rv\:11\./)){
            this.html_jquery_obj.addClass("ie11");
            this.is_ie11 = true;
            //this.is_ie = true; //do not flag ie11 as is_ie
            //alert('11');
        }


        //do we have html5 history support?
        if (window.history && window.history.pushState) {
            this.has_history = true;
        }

        //check for safari
        if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
            this.is_safari = true;
        }

        //chrome and chrome-ium check
        this.is_chrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase());

        this.is_ipad = navigator.userAgent.match(/iPad/i) != null;



        if (/(iPad|iPhone|iPod)/g.test( navigator.userAgent )) {
            this.html_jquery_obj.addClass('md_detect_is_ios'); //add class for ios
            this.is_ios = true;
        } else {
            this.is_ios = false;
        }



        //detect if we run on a mobile device - ipad included - used by the modal / scroll to @see scroll_into_view
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            this.is_mobile_device = true;
        }

        /**
         * function to check the phone screen
         * @see EventsListener
         * The $ windows width is not reliable cross browser!
         */
        this.run_is_phone_screen = function () {
            if ((($(window).width() < 768) || ($(window).height() < 640)) && (this.is_ipad === false)) {
                this.is_phone_screen = true;

            } else {
                this.is_phone_screen = false;
            }

            //console.log(this.is_phone_screen + ' ' + $(window).width() + ' ' + $(window).height());
        };



        this.run_is_phone_screen();


        //test for android
        var user_agent = navigator.userAgent.toLowerCase();
        if(user_agent.indexOf("android") > -1) {
            this.is_android = true;
            // we use this class to fix android problems
            this.html_jquery_obj.addClass('md_detect_is_android');
        }


        if (navigator.userAgent.indexOf('Mac OS X') != -1) {
            this.is_osx = true;
        }

        if (navigator.userAgent.indexOf('Firefox') != -1) {
            this.is_firefox = true;
        }

    };

    /* ============================================================================
     * Smart sticky menu
     * ==========================================================================*/

    var smartAffix = {
        //settings, obtained from ext
        staticMenuSelector: '', //the affix menu (this element will get the mdAffixed)
        fixedMenuSelector: '', //the menu wrapper / placeholder
        menuHeight: 0, // main menu height
        menuOffsetTop: 0, //how much the menu is moved from the original position when it's affixed
        hasAdminBar: false,
        adminBarOffset: 0,
        isAffixed: false, //the current state of the menu, true if the menu is affix
        isShown: false,
        isFromInitial: false,
        windowScrollTop: 0, 
        lastWindowScrollTop: 0, //last scrollTop position, used to calculate the scroll direction
        offCheckpoint: 0, // distance from top where fixed header will be hidden
        onCheckpoint: 0, // distance from top where fixed header can show up

        init : function init (options) {

            //read the settings
            smartAffix.fixedMenuSelector = options.fixedMenuSelector;
            smartAffix.staticMenuSelector = options.staticMenuSelector;
            smartAffix.hasAdminBar = options.hasAdminBar;

            // Check if selectors exist
            if( !$(smartAffix.fixedMenuSelector).length ) {
                return;
            }

            // if admin bar is showing, calculate the offset
            if (smartAffix.hasAdminBar) {
                var screenWidth = $(window).width();
                if (screenWidth < 600) {
                    smartAffix.adminBarOffset = 0;
                } else if (screenWidth < 782) {
                    smartAffix.adminBarOffset = 46;
                } else {
                    smartAffix.adminBarOffset = 32;
                }
                
            }
            
            // a computation before jquery.ready is necessary for firefox, where EventsListener.scroll comes before
            if (Detect.is_firefox) {
                smartAffix.compute();
            }

            $(document).ready(function() {
                //compute on semi dom ready
                smartAffix.compute();

            });

            //recompute when all the page + logos are loaded
            $(window).load(function() {
                smartAffix.compute();

                //recompute after 1 sec for retarded phones
                setTimeout(function(){
                    smartAffix.compute();
                }, 1000);

                // update state
                smartAffix.updateState();
            });


        },// end init

        compute: function compute(){
            // Set where from top fixed header starts showing up
            smartAffix.offCheckpoint = $(smartAffix.staticMenuSelector).offset().top - smartAffix.adminBarOffset;
            smartAffix.onCheckpoint = smartAffix.offCheckpoint + 400;

            // Set menu top offset
            smartAffix.windowScrollTop = $(window).scrollTop();
            if (smartAffix.offCheckpoint < smartAffix.windowScrollTop) {
                smartAffix.isAffixed = true;
            }

            // calculate admin bar offset
            if (smartAffix.hasAdminBar) {
                var screenWidth = $(window).width();
                if (screenWidth < 600) {
                    smartAffix.adminBarOffset = 0;
                } else if (screenWidth < 782) {
                    smartAffix.adminBarOffset = 46;
                } else {
                    smartAffix.adminBarOffset = 32;
                }
                
            }

        },

        updateState: function updateState(){

            //update affixed state
            if (smartAffix.isAffixed) {
                $(smartAffix.fixedMenuSelector).addClass('mdAffixed');
            } else {
                $(smartAffix.fixedMenuSelector).removeClass('mdAffixed');
            }

            if (smartAffix.isShown) {
                $(smartAffix.fixedMenuSelector).addClass('mdAffixed--shown');
            } else {
                $(smartAffix.fixedMenuSelector).removeClass('mdAffixed--shown');
            }
            
        },

        /**
         * called by md_events on scroll
         */

        eventScroll: function eventScroll(scrollTop) {

            var scrollDirection = '';
            var scrollDelta = 0;

            // check the direction
            if (scrollTop != smartAffix.lastWindowScrollTop) { //compute direction only if we have different last scroll top

                // compute the direction of the scroll
                if (scrollTop > smartAffix.lastWindowScrollTop) {
                    scrollDirection = 'down';
                } else {
                    scrollDirection = 'up';
                }
                //calculate the scroll delta
                scrollDelta = Math.abs(scrollTop - smartAffix.lastWindowScrollTop);
                smartAffix.lastWindowScrollTop = scrollTop;

                // update affix state
                if (smartAffix.offCheckpoint < scrollTop) {
                    smartAffix.isAffixed = true;
                } else {
                    smartAffix.isAffixed = false;
                }
                
                
                // check affix state
                if (smartAffix.isAffixed) {
                    // We're in affixed state, let's do some check
                    if ((scrollDirection == 'down') && (scrollDelta > 10)) {
                        if (smartAffix.isShown) {
                            smartAffix.isShown = false; // hide menu
                        }
                    } else {
                        if ((!smartAffix.isShown) && (scrollDelta > 10) && (smartAffix.onCheckpoint < scrollTop)) {
                            smartAffix.isShown = true; // show menu
                        }
                    }
                } else {
                    smartAffix.isShown = false;
                }

                smartAffix.updateState(); // update state
            }

            

        }, // end eventScroll function

    }

    var smartAffixOn = Util.getBackendVar('stickyHeader', 'toggle'); // Check if smartAffix is enabled
    if ( smartAffixOn == '1') {
        smartAffix.init({
            fixedMenuSelector: '.js-fixedHeader',
            staticMenuSelector: '.siteHeader-nav',
            hasAdminBar: Util.getBackendVar('stickyHeader', 'hasAdminBar'),
        });
    }

    /* ============================================================================
     * Single billboard layout parallax effect
     * ==========================================================================*/

    function BillboardParallax() {

        if (Detect.is_ie || Detect.is_touch_device || Detect.is_phone_screen) { //disable on IE and mobile device
            return;
        }

        if ($('.is-parallaxDisabled').length > 0) { // disable by option
            return;
        }

        var md_parallax_viewport = $('.postSingle--billboard-cover');
        var md_parallax_el = document.getElementById('md-billboard-info');

        var md_parallax_bg_el = document.getElementById('md-single-cover');

        if ((md_parallax_el == null) || (!md_parallax_bg_el == null)) {
            return;
        }

        // Calculate translate distance rate
        var on_checkpoint = $('.postSingle--billboard-cover').offset().top - $(window).height();
        if (on_checkpoint < 0) { on_checkpoint = 0; }
        var off_checkpoint = $('.postSingle--billboard-cover').offset().top + $('.postSingle--billboard-cover').height();
        var parallax_viewport_height = md_parallax_viewport.height();
        var bg_height = $(md_parallax_bg_el).height();
        var bg_offset = bg_height - parallax_viewport_height; // bg spare height compare to cover
        var distanceToUpperEdge = 1;
        // Distance to scroll down since cover is visible until window upper top edge meets cover upper top edge
        if ($(window).height() <= md_parallax_viewport.offset().top) {
            distanceToUpperEdge = $(window).height();
        } else {
            distanceToUpperEdge = md_parallax_viewport.offset().top;
        }
        var bg_translate_speed = bg_offset/distanceToUpperEdge;
        if (bg_translate_speed > 0.8) { bg_translate_speed = 0.8; }

        // Calculate opacity rate
        var on_checkpoint_text = $('#md-billboard-info').offset().top + 0.5*($('#md-billboard-info').height() - $(window).height());
        if (on_checkpoint_text < 0) { on_checkpoint_text = 0; }
        var off_checkpoint_text = $('#md-billboard-info').offset().top + $('#md-billboard-info').height();
        var text_opacity_rate = 0.6/(off_checkpoint_text - on_checkpoint_text);

        var scroll_from_top = '';
        var distance_from_bottom;

        $(window).on('resize',function(){
            // Calculate translate distance rate
            on_checkpoint = $('.postSingle--billboard-cover').offset().top - $(window).height();
            if (on_checkpoint < 0) { on_checkpoint = 0; }
            off_checkpoint = $('.postSingle--billboard-cover').offset().top + $('.postSingle--billboard-cover').height();
            parallax_viewport_height = md_parallax_viewport.height();
            bg_height = $(md_parallax_bg_el).height();
            bg_offset = bg_height - parallax_viewport_height; // bg spare height compare to cover
            distanceToUpperEdge = 1;
            // Distance to scroll down since cover is visible until window upper top edge meets cover upper top edge
            if ($(window).height() <= md_parallax_viewport.offset().top) {
                distanceToUpperEdge = $(window).height();
            } else {
                distanceToUpperEdge = md_parallax_viewport.offset().top;
            }
            bg_translate_speed = bg_offset/distanceToUpperEdge;
            if (bg_translate_speed > 0.6) { bg_translate_speed = 0.6; }

            // Calculate opacity rate
            on_checkpoint_text = $('#md-billboard-info').offset().top + 0.5*($('#md-billboard-info').height() - $(window).height());
            if (on_checkpoint_text < 0) { on_checkpoint_text = 0; }
            off_checkpoint_text = $('#md-billboard-info').offset().top + $('#md-billboard-info').height();
            text_opacity_rate = 0.6/(off_checkpoint_text - on_checkpoint_text);
        });

        //attach the animation tick on scroll
        $(window).scroll(function(){
            // with each scroll event request an animation frame (we have a polyfill for animation frame)
            // the requestAnimationFrame is called only once and after that we wait
            md_request_tick();
        });

        var md_animation_running = false; //if the tick is running, we set this to true

        function md_request_tick() {
            if (md_animation_running === false) {
                window.requestAnimationFrame(md_do_animation);
            }
            md_animation_running = true;
        }

        /**
         * the animation loop
         */
        function md_do_animation() {
            scroll_from_top = $(document).scrollTop();
            if ((scroll_from_top <= off_checkpoint) && (scroll_from_top >= on_checkpoint)) { //stop the animation after scroll from top
                var scroll_distance = scroll_from_top - on_checkpoint;    

                //move the bg
                var parallax_move = -Math.round(scroll_distance * bg_translate_speed);
                Util.moveY(md_parallax_bg_el,-parallax_move);

                // //move the title + cat
                // var text_translate_speed = bg_translate_speed * 0.5;
                // var text_parallax_move = -Math.round(scroll_distance * text_translate_speed);
                // Util.moveY(md_parallax_el,-text_parallax_move);

            }

            if ((scroll_from_top < off_checkpoint_text) && (scroll_from_top > on_checkpoint_text)) {
                var scroll_distance = scroll_from_top - on_checkpoint_text;
                var blur_value = 1 - (scroll_distance * text_opacity_rate);
                blur_value = Math.round(blur_value * 100) / 100;

                if (Detect.is_ie8 === true) {
                    blur_value = 1;
                }

                //opacity
                md_parallax_el.style.opacity = blur_value;

            } else if (scroll_from_top <= on_checkpoint_text) {
                //opacity
                md_parallax_el.style.opacity = 1;
            }

            md_animation_running = false;
        }

    }

    $(document).ready(function() {
        BillboardParallax();
    })

    /* ============================================================================
     * Gallery slider
     * ==========================================================================*/

    function md_gallery_slider( selector ){
        $(selector).fotorama();
    }

    /* ============================================================================
     * Masonry
     * ==========================================================================*/

    $( window ).load(function() {
        if ( $.isFunction($.fn.masonry) ) { // check if masonry script is loaded
            var $masonryGrid = $('.js-masonry-grid');
            $masonryGrid.masonry({
                itemSelector: '.grid-item'
            });
        }
    });

    /* ============================================================================
     * AJAX load posts
     * ==========================================================================*/

    function md_ajaxLoadPosts(){

        if (!$('.js-ajax-loadmore.is-active').length) {
            return;
        }

        // The number of current page.
        var pageNum = parseInt(Util.getBackendVar('ajaxloadpost', 'startPage'));
     
        // The maximum number of pages the current query can return.
        var max = parseInt(Util.getBackendVar('ajaxloadpost', 'maxPages'));

        var loadedPosts = '';
        var ajaxStatus = '';

        ajaxLoadPosts($('.js-ajax-loadmore.is-active'));

        $(document).on( 'click', '.js-ajax-loadmore.is-active', function() {
            appendResponse($(this));
            ajaxLoadPosts($(this));
        })

        function ajaxLoadPosts(loadBtn) {
            if(pageNum < max) {
                // Counter for loaded posts
                var loadedPostsCount = loadBtn.siblings('#mdContent').find('article').length;
                loadBtn.removeClass('is-active');

                var ajaxCall = $.ajax({
                    url: Util.getBackendVar('ajaxloadpost', 'ajaxurl'),
                    type: 'post',
                    data: {
                        action: 'ajax_load_post',
                        query_vars: Util.getBackendVar('ajaxloadpost', 'query_vars'),
                        page: pageNum + 1,
                        loadedPostsCount: loadedPostsCount,
                        currentRelURI: Util.getBackendVar('currentRelURI'),
                    }
                })

                ajaxCall.done(function( respond ) {
                    loadedPosts = $(respond);
                    ajaxStatus = 'success';
                });

                ajaxCall.fail(function() {
                    ajaxStatus = 'failed';
                    
                });

                ajaxCall.always(function() {
                    updateBtnText(loadBtn);                    
                    pageNum++;
                })

            }
        }

        function addThisReload(){
            if (typeof addthis !== 'undefined') {
                addthis.toolbox('.addthis_toolbox');
                addthis.counter('.addthis_counter');
                addthis.ready();
            }
        }

        function appendResponse(loadBtn){
            loadBtn.removeClass('is-active');

            if ($('#mdContent').hasClass('js-masonry-grid')) {
                $("#mdContent").append(loadedPosts).masonry( 'appended', loadedPosts, true ); // masonry layout 
            } else {
                $(loadedPosts).appendTo('#mdContent').css('opacity', 0).animate({opacity: 1}, 500); // other layout
            }

            md_gallery_slider('#mdContent .fotorama'); // fotorama init
            addThisReload(); // addThis init
            
            updateBtnText(loadBtn);
            $('html, body').animate({ scrollTop: $(window).scrollTop() + 1 }, 0); // for recalculating of sticky sidebar
            loadedPosts = '';
        }

        function updateBtnText(loadBtn){
            if (ajaxStatus == 'failed') {
                loadBtn.find('span').text(Util.getBackendVar('ajaxloadpost', 'failText'));
            } else {
                if ( pageNum >= max ) {
                    loadBtn.find('span').text(Util.getBackendVar('ajaxloadpost', 'noMoreText'));
                } else {
                    loadBtn.addClass('is-active');
                }
            }
        }
        

        
    }
    // End AJAX load posts function

    $(document).ready(function() {
        // AJAX load posts
        md_ajaxLoadPosts();
    })

    /* ============================================================================
     * AJAX infinity scroll
     * ==========================================================================*/

    // AJAX infity scroll
    function md_ajaxIfninityScroll(){

        var loadBtn = $('.js-ajax-infinity-scroll.is-active');
        if (!loadBtn.length) {
            return;
        }

        // The number of the next page to load (/page/x/).
        var pageNum = parseInt(Util.getBackendVar('ajaxloadpost', 'startPage'));
     
        // The maximum number of pages the current query can return.
        var max = parseInt(Util.getBackendVar('ajaxloadpost', 'maxPages'));

        

        var initialText = loadBtn.text();

        function updateBtn(){
            if ( pageNum == max ) {
                loadBtn.find('span').text(Util.getBackendVar('ajaxloadpost', 'noMoreText'));
            } else {
                loadBtn.find('span').text(initialText);
                loadBtn.addClass('is-active');
            }
            return $(this);
        }

        function addThisReload(){
            if (typeof addthis !== 'undefined') {
                addthis.toolbox('.addthis_toolbox');
                addthis.counter('.addthis_counter');
                addthis.ready();
            }
        }

        function ajaxLoadPosts(){
            if(pageNum < max) {
                // Counter for loaded posts
                var loadedPostsCount = loadBtn.siblings('#mdContent').find('article').length;

                loadBtn.addClass('is-loading');
                
                loadBtn.find('span').text(Util.getBackendVar('ajaxloadpost', 'loadingText'));
                loadBtn.find('i').addClass('fa-spin');

                var ajaxCall = $.ajax({
                    url: Util.getBackendVar('ajaxloadpost', 'ajaxurl'),
                    type: 'post',
                    data: {
                        action: 'ajax_load_post',
                        query_vars: Util.getBackendVar('ajaxloadpost', 'query_vars'),
                        page: pageNum + 1,
                        loadedPostsCount: loadedPostsCount,
                        currentRelURI: Util.getBackendVar('currentRelURI'),
                    }
                });

                ajaxCall.done(function( respond ) {
                    var html = $(respond);
                    if ($('#mdContent').hasClass('js-masonry-grid')) {
                        $("#mdContent").append(html).masonry( 'appended', html, true ); // masonry layout   
                    } else {
                        $(html).appendTo('#mdContent').css('opacity', 0).animate({opacity: 1}, 500); // other layout
                    }

                    md_gallery_slider('#mdContent .fotorama'); // fotorama init
                    addThisReload(); // addThis init
                    $('html, body').animate({ scrollTop: $(window).scrollTop() + 1 }, 0); // for recalculating of sticky sidebar
                    updateBtn();
                    pageNum++;

                });

                ajaxCall.fail(function() {
                    loadBtn.find('span').text(Util.getBackendVar('ajaxloadpost', 'failText'));
                });

                ajaxCall.always(function() {
                    loadBtn.removeClass('is-loading');
                    loadBtn.find('i').removeClass('fa-spin');
                });

            } else {
                loadBtn.find('span').text(Util.getBackendVar('ajaxloadpost', 'noMoreText'));
            }
        }

        function ajaxScrollEvent(){
            if (loadBtn.length) {
                if (( loadBtn.offset().top - $(window).scrollTop() - $(window).height()) <= $(window).height()*3) {
                    if (loadBtn.hasClass('is-active')) {
                        loadBtn.removeClass('is-active');
                        ajaxLoadPosts();
                    }
                }
            }
        }

        $(window).scroll(ajaxScrollEvent);


    }
    // End AJAX infinity scroll

    $(document).ready(function() {
        // AJAX infinity scroll
        md_ajaxIfninityScroll();
    });


    /* ============================================================================
     * Post like
     * ==========================================================================*/
    function postLikes() {
        $('body').on('click','.js-mdPostLike',function(event){
            event.preventDefault();
            var text = '<span class="hidden-xs">&nbsp;' + Util.getBackendVar('postLike', 'likeCountText') + '</span>';
            var heart = $(this);
            var post_id = heart.data("post_id");
            if (heart.hasClass('mdPostLike--compact')) {
                text = '';
            }
            heart.addClass("processing");
            
            $.ajax({
                type: "post",
                url: Util.getBackendVar('ajaxloadpost', 'ajaxurl'),
                data: "action=minimaldog_post_like&nonce=" + Util.getBackendVar('postLike', 'nonce') + "&minimaldog_post_like=&post_id=" + post_id,
                success: function(count){
                    heart.removeClass("processing");
                    if( count.indexOf( "already" ) !== -1 )
                    {
                        var lecount = count.replace("already","");
                        if (lecount === "0")
                        {
                            lecount = '';
                            text = '<span class="hidden-xs">&nbsp;' + Util.getBackendVar('postLike', 'likeText') + '</span>';
                        } else {
                            if (lecount === '1') {
                                text = '<span class="hidden-xs">&nbsp;' + Util.getBackendVar('postLike', 'likeCountTextSingular') + '</span>';
                            }
                            lecount = '&nbsp;'+lecount;
                        }
                        if (heart.hasClass('mdPostLike--compact')) {
                            text = '';
                        }
                        heart.prop('title', Util.getBackendVar('postLike', 'likeText'));
                        heart.removeClass("liked");
                        heart.html("<i class='fa fa-heart'></i><i class='fa fa-heart-o'></i>" + lecount + text);
                    }
                    else
                    {   
                        if (count === '1') {
                            text = '<span class="hidden-xs">&nbsp;' + Util.getBackendVar('postLike', 'likeCountTextSingular') + '</span>';
                        }
                        if (heart.hasClass('mdPostLike--compact')) {
                            text = '';
                        }
                        heart.prop('title', Util.getBackendVar('postLike', 'unlikeText'));
                        heart.addClass("liked");
                        heart.html("<i class='fa fa-heart'></i><i class='fa fa-heart-o'></i>&nbsp;"+ count + text);
                    }
                }
            });
        });
    }

    $(document).ready(function() {
        postLikes();
    });

    /* ============================================================================
     * Font Awesome CDN fallback
     * ==========================================================================*/
    function faFallBack() {
        var $check = $('.fa');
        if ($check.length) {
            if ( $check.css('fontFamily') !== 'FontAwesome' ) {
                // fon't awesome not loaded!
                // remove current css link
                $('#font-awesome-css').remove;
                // add the local version
                var local = '<link rel="stylesheet" type="text/css" href="' 
                + Util.getBackendVar('faFallBack', 'faURL') + '" />';
                $('head').append( local );
            }
        }
    };

    $(document).ready(function() {
        if (Util.getBackendVar('faFallBack', 'toggle') == '1') {
            faFallBack();
        }
    });

    /* ============================================================================
     * Logo and background images on hiDPI devices
     *===========================================================================*/
    function hiDPI() {
    
        // Detect HiDPI
        var hidpi = '',
            mediaQuery = "(-webkit-min-device-pixel-ratio: 1.5),(min--moz-device-pixel-ratio: 1.5),(-o-min-device-pixel-ratio: 3/2),(min-resolution: 1.5dppx)";

            if ( window.devicePixelRatio > 1 ) {
                hidpi = true;
            }
        
            if ( window.matchMedia && window.matchMedia(mediaQuery).matches ) {
                hidpi = true;
            }


        if ( hidpi ) {

            // Replace logo

            $('.siteLogo--image img').bind('load', function() {

                if ( $(this).is('[data-hidpi]') ) {
                    var src = $(this).attr('data-hidpi');
                    $(this).attr( 'src', src );

                    
                }

            });

            // Replace background images

            $('.o-backgroundImg, .u-hasBackgroundImg, #md-single-cover').each(function(){

                if ( $(this).is('[data-hidpi]') ) {

                    var src = $(this).attr('data-hidpi');
                    $(this).css( 'background-image', 'url(' + src + ')' );

                }

            });
        }
    }

    $(document).ready(function() {
        if (Util.getBackendVar('highResolution') == '1') {
            hiDPI();
        }
    });
    
    /* ============================================================================
     * Misc functions
     * ==========================================================================*/
    $(function () {
        
        $(document).ready(function() {

            // Popover
            $('.js-popover-toggle').click(function(e){
                e.stopPropagation();
                $('.js-popover.is-active').toggleClass('is-active');
                $(this).siblings('.js-popover').toggleClass('is-active');
            });
            $('.js-popover').click(function(e){
                e.stopPropagation();
            });
            $(document).on("click", function() {
                $('.js-popover').removeClass('is-active');
            });

            // User Actions btn
            $('.js-userActions-btn').click(function(e){
                e.stopPropagation();
                $(this).siblings('.userActions-popup').toggleClass('is-active');
            });
            $('.js-userActions-popup').click(function(e){
                e.stopPropagation();
            });
            $(document).on("click", function() {
                $('.js-userActions-popup').removeClass('is-active');
            });

            // Search toggle
            $('.js-searchToggle').on('click', function(e) {
                e.stopPropagation();
                $(this).toggleClass('isActive');
                $(this).siblings('.js-searchToggle').toggleClass('isActive');
                $(this).closest('.js-searchOuter').toggleClass('isSearchActive');
                $(this).closest('.js-searchOuter.isSearchActive').find('.searchField-form-input').focus();
            });
            $('.js-searchToggle').siblings('.searchField').click(function(e){
                e.stopPropagation();
            })
            $(document).on("click", function() {
                $('.js-searchToggle').removeClass('isActive').closest('.siteHeader-nav').removeClass('isSearchActive');
            });

            // AddThis
            if (typeof addthis !== 'undefined' ) {

                addthis.init();
            }

            // Tab
            $('.tabs-nav a').click(function (e) {
                e.preventDefault()
                var tabID = $(this).attr('href');
                $(this).parent('li').siblings('li.active').removeClass('active');
                $(this).parent('li').addClass('active');
                $(this).parents('.tabs-nav').siblings('.tabs-content').find('.tabs-content-section.active').removeClass('active');
                $(this).parents('.tabs-nav').siblings('.tabs-content').find(tabID).addClass('active').masonry('layoutItems');
                $(this).parents('.tabs-nav').siblings('.tabs-content').find(tabID).find('.js-masonry-grid').masonry('layout');
            });

            // Sticky sidebar
            if (Util.getBackendVar('stickySidebar', 'toggle') === '1') {
                $('.js-sticky-sidebar').theiaStickySidebar({
                  // Settings
                  additionalMarginTop: Util.getBackendVar('stickySidebar', 'offsetTop'),
                  additionalMarginBottom: 40
                });
            }           

            // Widget menu
            $('.widget_nav_menu .menu > li.menu-item-has-children').append(function(){
                return $('<div class="submenu-toggle"><i class="fa fa-angle-down"></i></div>').click(function(){
                    $(this).parent().children('.sub-menu').slideToggle(200);
                });
            });

            // Parallax carousel
            if ( $('.js-iscroll').length ) {
                var myScroll = new IScroll('.js-iscroll', {
                    eventPassthrough: true,
                    scrollX: true,
                    scrollY: false,
                    preventDefault: true,
                    indicators: {
                        el: document.getElementById('iscroll-bg'),
                        ignoreBoundaries: true,
                        interactive: false,
                        listenX: true,
                        listenY: false,
                        resize: false,
                        shrink: false,
                        speedRatioX: 0,
                    }
                }); 
            }
            
            // Featured slider
            var $featSlider = $('.js-feat-slider-peek');
            var autoplay = Util.getBackendVar('sliderOpts', 'autoplay');
            var timeout = Util.getBackendVar('sliderOpts', 'timeout');
            $featSlider.owlCarousel({
                items: 1,
                dots: true,
                nav: true,
                navText: ['<svg width="64" height="64" viewBox="0 0 64 64"><path id="arrow-left-1" d="M46.077 55.738c0.858 0.867 0.858 2.266 0 3.133s-2.243 0.867-3.101 0l-25.056-25.302c-0.858-0.867-0.858-2.269 0-3.133l25.056-25.306c0.858-0.867 2.243-0.867 3.101 0s0.858 2.266 0 3.133l-22.848 23.738 22.848 23.738z" /></svg>' , '<svg width="64" height="64" viewBox="0 0 64 64"><path id="arrow-right-1" d="M17.919 55.738c-0.858 0.867-0.858 2.266 0 3.133s2.243 0.867 3.101 0l25.056-25.302c0.858-0.867 0.858-2.269 0-3.133l-25.056-25.306c-0.858-0.867-2.243-0.867-3.101 0s-0.858 2.266 0 3.133l22.848 23.738-22.848 23.738z" /></svg>'],
                margin: 20,
                autoplay: autoplay,
                autoplayTimeout: timeout,
                autoplayHoverPause: true,
                loop: true,
            });
            var $featSliderFw = $('.js-feat-slider');
            $featSliderFw.owlCarousel({
                items: 1,
                dots: true,
                autoplay: autoplay,
                autoplayTimeout: timeout,
                autoplayHoverPause: true,
                loop: true,
            });

            // Widget slider
            $('.js-slider-widget').owlCarousel({
                items: 1,
                dots: true,
                nav: false,
            });

            // Scroll top button
            if ($('.js-scrolltop-btn').length) {
                $('.js-scrolltop-btn').on('click', function() {
                    $('html, body').animate({ scrollTop: 0 }, 500);
                });
            }
            
            // Off-canvas menu
            $('.js-menu-toggle').click(function(){
                $('#md_offCanvasMenu').addClass('is-opened');
                if ($('#md_canvasOverlay').length === 0) {
                    var overlay = $('<div id="md_canvasOverlay" class="is-active"></div>');
                    overlay.click( function(){
                        $('#md_offCanvasMenu').removeClass('is-opened');
                        $('#mdSidebar').removeClass('is-opened');
                        $(this).removeClass('is-active');
                    });
                    $('body').append(overlay);
                } else {
                    $('#md_canvasOverlay').addClass('is-active');
                }
            });

            $('.js-offCanvasClose').click(function(){
                $(this).parents('.md_offCanvas').removeClass('is-opened');
                $('#md_canvasOverlay').removeClass('is-active');
            });

            var subMenuToggle = $('<div class="subMenuToggle"><i class="fa fa-angle-down"></i></div>');
            subMenuToggle.click( function(e){
                e.preventDefault();
                $(this).find('i').toggleClass('fa-angle-left');
                $(this).find('i').toggleClass('fa-angle-down');
                //$(this).parent('a').siblings('.sub-menu').toggleClass('-is-expanded');
                $(this).parent('a').siblings('.sub-menu').slideToggle(200);
            });
            $('#md_offCanvasMenu').find('li.menu-item-has-children > a').append(subMenuToggle);
                
        });
                
    });
    
}( window.mdBone = window.mdBone || {}, jQuery ));