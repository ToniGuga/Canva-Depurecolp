/** declare transaltion functions */
const { __, _x, _n, _nx } = wp.i18n;

// __('__', 'my-domain');
// _x('_x', '_x_context', 'my-domain');
// _n('_n_single', '_n_plural', number, 'my-domain');
// _nx('_nx_single', '_nx_plural', number, '_nx_context', 'my-domain')


/**
 * per i link o pulsanti che devono aggiornare la pagina
 */
function refreshPage() {
    window.location.reload();
}


/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 *
 * jQuery.browser.mobile will be true if the browser is a mobile device
 *
 **/

window.mobileCheck = function() {
    let check = false;
    (function(a) { if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true; })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};



/* from http://www.quirksmode.org/js/cookies.html */
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}




/*!
 * Determine if an element is in the viewport
 * (c) 2017 Chris Ferdinandi, MIT License, https://gomakethings.com
 * @param  {Node}    elem The element
 * @return {Boolean}      Returns true if element is in the viewport
 */

function isInViewport(elem) {
    var distance = elem.getBoundingClientRect();
    return (
        distance.top >= 0 &&
        distance.bottom <= (window.innerHeight || document.documentElement.clientHeight)
    );
};


/**
 * funzioni per calcolare l'aspect ratio
 * @param {*} x
 * @param {*} y
 */
function gcd(x, y) {
    if (y == 0) { return x; }
    return gcd(y, x % y);
}

function viewPortRatio() {
    var ratioCalc = gcd($(window).width(), $(window).height());
    var ratio = ($(window).width() / ratioCalc) / ($(window).height() / ratioCalc);
    return ratio;
}



/**
 *
 * Lazy Embed Videos Youtube Vimeo
 *
 * demo site
 * https://www.jqueryscript.net/demo/Play-Youtube-Vimeo-Videos-When-Needed-embedvideos/
 *
 * code example youtube
 * <div class="embed-video" data-source="youtube" data-video-url="https://www.youtube.com/watch?v=C-Q7GeQG6iE"></div>
 *
 * code example vimeo
 * <div class="embed-video" data-source="vimeo" data-video-url="https://vimeo.com/211970798"></div>
 *
 * <?php echo do_shortcode('[video_lazy_emded video_url="' . get_field('video_url') . '" streaming_source="youtube" class=""]'); ?>
 *
 */

(function($) {
    window.kalturaLoaded = false;
    window.youtubeLoaded = false;
    window.youtubePlayers = [];
    $.fn.embedVideo = function(options) {
        $(this).each(function() {
            var settings = $.extend({
                uiconf: '11601208',
                wid: '102',
                kalturaServerURL: 'https://cloudvideo.cdn.net.co',
                maxWidth: ($(this).data('max-width')) ? $(this).data('max-width') : '1200px',
                video_id: $(this).data('video-id'),
                video_url: ($(this).data('video-url')) ? $(this).data('video-url') : null,
                html5: false,
                autoplay: ($(this).data('autoplay')) ? $(this).data('autoplay') : false,
                thumbnail: ($(this).data('thumbnail')) ? $(this).data('thumbnail') : false,
                width: ($(this).data('width')) ? $(this).data('width') : '100%',
                height: ($(this).data('height')) ? $(this).data('height') : '100%',
                container: $(this).attr('id'),
                video_src: ($(this).data('source')) ? $(this).data('source') : 'kaltura',
                extra_params: ($(this).data('params')) ? $(this).data('params') : false,
                cc_policy: ($(this).data('cc-policy')) ? $(this).data('cc-policy') : false,
                /*play : '<svg enable-background="new 0 0 34 34" height="34px" id="Layer_1" version="1.1" viewBox="0 0 34 34" width="34px" xml:space="preserve" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><path d="M17.078,0.25c-9.389,0-17,7.611-17,17s7.611,17,17,17s17-7.611,17-17S26.467,0.25,17.078,0.25z M14,23.963  V10.537l9,6.713L14,23.963z" fill="#FFF"/></svg>',*/
                play: '<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#fff" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm115.7 272l-176 101c-15.8 8.8-35.7-2.5-35.7-21V152c0-18.4 19.8-29.8 35.7-21l176 107c16.4 9.2 16.4 32.9 0 42z"/></svg>',
                playWidth: '48px',
                playHeight: '48px',
                playOpacity: '0.7'
            }, options);

            var video_cont = $(this);

            if (settings.video_src == 'kaltura') {
                if (!window.kalturaLoaded) {
                    var script = document.createElement('script');
                    script.type = 'text/javascript';
                    script.src = settings.kalturaServerURL + '/p/' + settings.wid + '/sp/' + settings.wid + '00/embedIframeJs/uiconf_id/' + settings.uiconf + '/partner_id/' + settings.wid;
                    document.getElementsByTagName('head')[0].appendChild(script);

                    window.kalturaLoaded = true;
                }
            } else if (settings.video_src == 'youtube') {
                if (!window.youtubeLoaded) {
                    var tag = document.createElement('script');
                    tag.src = 'https://www.youtube.com/iframe_api';
                    document.getElementsByTagName('head')[0].appendChild(tag);
                    window.youtubeLoaded = true;
                }
                /*var videoid = settings.video_url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);*/
                var videoid = settings.video_url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/embed\/)([^\s&]+)/);
                if (videoid != null) {
                    settings.video_id = videoid[1];
                }

            } else if (settings.video_src == 'vimeo') {
                settings.video_id = settings.video_url.split(/video\/|https?:\/\/vimeo\.com\//)[1].split(/[?&]/)[0];
            }

            // Get uniqid
            var n = Math.floor(Math.random() * 11);
            var k = Math.floor(Math.random() * 1000000);
            var m = String.fromCharCode(n) + k;
            m = settings.video_src + '_video_' + m;

            var video_styles = function() {
                video_cont.css({
                    width: '100%',
                    height: '100%',
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    'background-repeat': 'no-repeat',
                    'background-size': 'cover',
                    'background-position': '50% 50%',
                    'background-image': 'url("' + settings.thumbnail + '")'
                }).attr('id', m);
            }

            if (!settings.thumbnail) {
                if (settings.video_src == 'kaltura') {
                    settings.thumbnail = 'https://cloudvideo.cdn.net.co/p/' + settings.wid + '/thumbnail/entry_id/' + settings.video_id;
                    video_styles();
                } else if (settings.video_src == 'youtube') {
                    settings.thumbnail = 'https://img.youtube.com/vi/' + settings.video_id + '/hqdefault.jpg';
                    video_styles();
                } else if (settings.video_src == 'vimeo') {
                    $.getJSON('https://vimeo.com/api/v2/video/' + settings.video_id + '.json?callback=?', { format: "json" }, function(data) {
                        settings.thumbnail = data[0].thumbnail_large;
                        video_styles();
                    });
                }
            } else {
                video_styles();
            }

            var videoContainer = $('<div>').attr({
                'style': 'width: 100%; margin: 0 auto; max-width: ' + settings.maxWidth + ';',
                'class': 'videoContainer'
            });
            var frameVideoContainer = $('<div>').attr({
                'style': 'position: relative; height: 0; width: 100%; padding-bottom: 56.25%;',
                'class': 'framePlayerContainer'
            });
            var playIcon = $(settings.play);
            playIcon.attr({
                width: '100%',
                height: '100%'
            });

            var playButton = $('<a>').css({
                'position': 'absolute',
                'cursor': 'pointer',
                'width': settings.playWidth,
                'height': settings.playHeight,
                'top': 'calc(50% - 24px)',
                'margin-top': '-' + settings.playHeight + 'px',
                'left': 'calc(50% - 24px)',
                'margin-left': '-' + settings.playWidth + 'px',
                'text-decoration': 'none',
                'border': 'none',
                'border-radius': '50%',
                'box-shadow': '0 0 100px rgba(0, 0, 0, 0.7)',
                'opacity': settings.playOpacity
            }).append(playIcon);

            var parent = $(this).parent();

            playButton.appendTo($(this));

            $(this).wrap(frameVideoContainer);

            /*frameVideoContainer.wrap(videoContainer);*/
            /*videoContainer.appendTo(parent);*/

            var videoAutoPlay = (settings.autoplay) ? settings.autoplay : true;

            playButton.on('click', function() {
                var tag = 'iframe',
                    insideContent = '';
                if (typeof AMP !== 'undefined') {
                    tag = 'amp-iframe';
                    insideContent = '<amp-img layout="fill" src="' + settings.thumbnail + '" placeholder></amp-img>';
                }
                playButton.fadeOut(function() {
                    $(this).remove();
                    if (settings.video_src == 'kaltura' && window.kalturaLoaded) {
                        kWidget.embed({
                            'targetId': m,
                            'wid': '_' + settings.wid,
                            'uiconf_id': settings.uiconf,
                            'entry_id': settings.video_id,
                            'flashvars': {
                                'autoPlay': videoAutoPlay
                            }
                        });
                    } else if (settings.video_src == 'youtube') {
                        var YTConfig = {
                            width: '100%',
                            height: '100%',
                            videoId: settings.video_id,
                            events: {
                                'onReady': function(event) {
                                    if (videoAutoPlay) {
                                        event.target.playVideo();
                                    }
                                }
                            }
                        };
                        if (settings.autoplay || settings.cc_policy) {
                            YTConfig.playerVars = {};
                            if (settings.cc_policy) {
                                YTConfig.playerVars.cc_load_policy = settings.cc_policy;
                            }
                            if (settings.autoplay) {
                                YTConfig.playerVars.autoplay = settings.autoplay;
                            }
                        }
                        window.youtubePlayers[m] = new YT.Player(m, YTConfig);
                    } else if (settings.video_src == 'vimeo') {
                        var videoParams = '';
                        if (settings.extra_params) {
                            videoParams = '&' + settings.extra_params;
                        }
                        var video_player = '<' + tag + ' src="https://player.vimeo.com/video/' + settings.video_id + '?autoplay=' + videoAutoPlay + videoParams + '" width="' + settings.width + '" height="' + settings.height + '" sandbox="allow-scripts allow-presentation allow-same-origin" layout="responsive" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>' + insideContent + '</' + tag + '>';
                        video_cont.append(video_player);
                    }
                });
            });

        });
    }

    $(document).ready(function() { $('.embed-video').embedVideo(); });

})(jQuery);





// Gallery photoswipe immagini e video
(function() {

    var initPhotoSwipeFromDOM = function(gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements
        // (children of gallerySelector)
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                // linkEl,
                figureEl,
                size,
                item;

            for (var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element
                // include only element nodes
                if (figureEl.nodeType !== 1) {
                    continue;
                }

                // create slide object
                if ($(figureEl).data('type') == 'video') {
                    videosrc = $(figureEl).find('.video-embed').html();
                    console.log(videosrc);
                    item = {
                        // html: $(figureEl).data('video')
                        html: videosrc
                    };
                } else {
                    size = figureEl.getAttribute('data-size').split('x');
                    item = {
                        src: figureEl.getAttribute('data-url'),
                        w: parseInt(size[0], 10),
                        h: parseInt(size[1], 10)
                    };
                }

                // console.log(item);

                if (figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }

                if (figureEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = figureEl.children[0].getAttribute('src');
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
            // console.log(items);
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });

            if (!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if (childNodes[i].nodeType !== 1) {
                    continue;
                }

                if (childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }

            if (index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe(index, clickedGallery);
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        // var photoswipeParseHash = function() {
        //     var hash = window.location.hash.substring(1),
        //         params = {};

        //     if (hash.length < 5) {
        //         return params;
        //     }

        //     var vars = hash.split('&');
        //     for (var i = 0; i < vars.length; i++) {
        //         if (!vars[i]) {
        //             continue;
        //         }
        //         var pair = vars[i].split('=');
        //         if (pair.length < 2) {
        //             continue;
        //         }
        //         params[pair[0]] = pair[1];
        //     }

        //     if (params.gid) {
        //         params.gid = parseInt(params.gid, 10);
        //     }

        //     return params;
        // };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)
            options = {

                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.children[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect();
                    // console.log(thumbnail);

                    return {
                        x: rect.left,
                        y: rect.top + pageYScroll,
                        w: rect.width
                    };
                }

            };

            // PhotoSwipe opened from URL
            if (fromURL) {
                if (options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for (var j = 0; j < items.length; j++) {
                        if (items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if (isNaN(options.index)) {
                return;
            }

            if (disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();

            gallery.listen('close', function() {
                // $('.photoswipe-video').each(function() {
                //     $(this).empty();
                // });
                $('.pswp__item').find('.photoswipe-video').empty();
            });

        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);
        for (var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i + 1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        // var hashData = photoswipeParseHash();
        // if (hashData.pid && hashData.gid) {
        //     openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
        // }

    };

    // execute above function
    initPhotoSwipeFromDOM('.photoswipe-item');


})();


/**
 *
 * apre e chiude modale ricerca generica sito
 * Canva modal-search-menu
 * from fn-search.php
 *
 */

(function($) {
    $(document).on('click', '.modal-search-menu', function() {
        $(".modal-search, .modal").removeClass("hide");
        $(".modal-search").removeClass("fade-out");
        $("body").addClass("stop-scroll");
    });

    $(document).on('click', '.modal-close', function() {
        $(".modal-search").addClass("fade-out");
        setTimeout(function() {
            $(".modal-search").addClass("hide");
            $(".modal-search").removeClass("fade-out");
            $("body").removeClass("stop-scroll");
        }, 1000);
    });

    $(document).on('click', '.modal-open', function() {
        var modalContentClass = $(this).attr('data-modal-content');
        var modalContent = $('.' + modalContentClass).clone();
        $(document).find('.modal-container .modal-content-append').append(modalContent);
        $('.modal-container .modal-content-append .' + modalContentClass).removeClass('hide');

        $(".modal-container").removeClass("hide");
        $(".modal-container").removeClass("fade-out");
        $("body").addClass("stop-scroll");
    });

    $(document).on('click', '.modal-close', function() {
        $(".modal-container").addClass("fade-out");
        setTimeout(function() {
            $(".modal-container").addClass("hide");
            $(".modal-container").removeClass("fade-out");
            $("body").removeClass("stop-scroll");
            $(document).find('.modal-container .modal-content-append').children().remove();
        }, 1000);
    });

    //chiude la modale quando viene premuto il tasto
    $(document).on('keyup', 'body', function(e) {
        if (e.which === 27) {
            $(".modal-container").addClass("fade-out");
            setTimeout(function() {
                $(".modal-container").addClass("hide");
                $(".modal-container").removeClass("fade-out");
                $("body").removeClass("stop-scroll");
                $(document).find('.modal-container .modal-content-append').children().remove();
            }, 1000);

            $(".modal-search").addClass("fade-out");
            setTimeout(function() {
                $(".modal-search").addClass("hide");
                $(".modal-search").removeClass("fade-out");
                $("body").removeClass("stop-scroll");
            }, 1000);
        }
    });

})(jQuery);


/**
 *
 * canva_on_canvas_menu js
 * apre chiude il menu on canvas del sito
 * from f-site-menu.php
 *
 */

(function($) {

    $(window).on('scroll', function() {

        var scroll = $(window).scrollTop();
        var viewPortHeight = $(window).height();

        if (scroll < 300) {
            $(".site-navigation-fixed").addClass("hide-inside");
            $(".site-navigation-fixed").addClass("invisible");
        }

        if (scroll > viewPortHeight) {
            $(".site-navigation-fixed").removeClass("invisible");
            $(".site-navigation-fixed").removeClass("hide-inside");
        }

    });


    $(document).on('click', '.hamburger', function(e) {
        $('.off-canvas').toggleClass('is-open');
        if (!$(this).hasClass('is-closed')) {
            $('.on-canvas-navigation, .close-on-canvas').removeClass('is-closed');
            //$('.close-on-canvas').removeClass('is-closed');
            $('body').addClass('on-canvas-stop-scroll');
            $('.on-canvas-navigation').addClass('close-on-canvas is-opened');
        } else {
            $('.on-canvas-navigation').addClass('is-closed');
            $('body').removeClass('on-canvas-stop-scroll');
            $('.on-canvas-navigation').removeClass('is-opened');
        }
        $(this).toggleClass('is-closed');
        return false;
    });

    $(document).on('click', '.on-canvas-navigation .close-on-canvas', function(e) {
        if ($(this).hasClass('.close-on-canvas')) {
            $('.on-canvas-navigation').removeClass('is-opened');
            $('html').removeClass('on-canvas-stop-scroll');
            $('body').removeClass('on-canvas-stop-scroll relative');
            $('.on-canvas-navigation').addClass('is-closed');
        } else {
            $('.on-canvas-navigation').addClass('is-closed');
            $('body').removeClass('on-canvas-stop-scroll');
            $('.on-canvas-navigation').removeClass('is-opened');
            $('.hamburger').removeClass('is-closed');
        }

        $(this).toggleClass('is-closed');
        return false;
    });

    $(document).on('click', '.on-canvas-navigation li:not(.menu-item-has-children)', function(e) {
        $('.on-canvas-navigation').removeClass('is-opened');
        $('html').removeClass('on-canvas-stop-scroll');
        $('body').removeClass('on-canvas-stop-scroll relative');
        $('.on-canvas-navigation').addClass('is-closed');
        $('.hamburger').removeClass('is-closed');

        $(this).toggleClass('is-closed');
        return true;
    });


    $(document).on('click', '.hamburger-aux', function(e) {
        if (!$(this).hasClass('is-closed')) {
            $('.on-canvas-aux-menu, .close-on-canvas').removeClass('is-closed');
            //$('.close-on-canvas').removeClass('is-closed');
            $('body').addClass('on-canvas-stop-scroll');
            $('.on-canvas-aux-menu').addClass('close-on-canvas is-opened');
        } else {
            $('.on-canvas-aux-menu').addClass('is-closed');
            $('body').removeClass('on-canvas-stop-scroll');
            $('.on-canvas-aux-menu').removeClass('is-opened');
        }
        $(this).toggleClass('is-closed');
        return false;
    });

    $(document).on('click', '.on-canvas-aux-menu .close-on-canvas', function(e) {
        if ($(this).hasClass('.close-on-canvas')) {
            $('.on-canvas-aux-menu').removeClass('is-opened');
            $('html').removeClass('on-canvas-stop-scroll');
            $('body').removeClass('on-canvas-stop-scroll relative');
            $('.on-canvas-aux-menu').addClass('is-closed');
        } else {
            $('.on-canvas-aux-menu').addClass('is-closed');
            $('body').removeClass('on-canvas-stop-scroll');
            $('.on-canvas-aux-menu').removeClass('is-opened');
            $('.hamburger').removeClass('is-closed');
        }

        $(this).toggleClass('is-closed');
        return false;
    });

    $(document).on('click', '.on-canvas-aux-menu li:not(.menu-item-has-children)', function(e) {
        $('.on-canvas-aux-menu').removeClass('is-opened');
        $('html').removeClass('on-canvas-stop-scroll');
        $('body').removeClass('on-canvas-stop-scroll relative');
        $('.on-canvas-aux-menu').addClass('is-closed');
        $('.hamburger').removeClass('is-closed');

        $(this).toggleClass('is-closed');
        return true;
    });


    // $('a[href*="#"]')
    //     // Remove links that don't actually link to anything
    //     .not('[href="#"]')
    //     .not('[href="#0"]')
    //     .click(function(event) {
    //         // On-page links
    //         if (
    //             location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
    //             location.hostname == this.hostname
    //         ) {
    //             // Figure out element to scroll to
    //             var target = $(this.hash);
    //             target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    //             // Does a scroll target exist?
    //             if (target.length) {
    //                 // Only prevent default if animation is actually gonna happen
    //                 event.preventDefault();
    //                 $('html, body').animate({
    //                     scrollTop: target.offset().top
    //                 }, 1000, function() {
    //                     // Callback after animation
    //                     // Must change focus!
    //                     var $target = $(target);
    //                     $target.focus();
    //                     if ($target.is(":focus")) { // Checking if the target was focused
    //                         return false;
    //                     } else {
    //                         $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
    //                         $target.focus(); // Set focus again
    //                     };
    //                 });
    //             }
    //         }
    //     });

    /**
     * funzione che gestisce i sub menu del sito in versione desktop
     */

    //mostra info mega menu della voce
    $('.site-navigation li.menu-item-has-children').on('mouseenter', function() {
        var hasMegaMenu = $(this).find('.dropdown').find('.mega-menu');
        // $(this).find('.dropdown').find('.mega-menu').remove();

        if (hasMegaMenu > 0) {
            $(this).find('.dropdown').find('.mega-menu').remove();
        } else {
            // $('ul.menu', this).stop(false, false).slideToggle('500');
            $('ul.menu', this).removeClass('hide');
            $(this).toggleClass('exploded');
            var megaMenu = $(this).children('a').find('.data-for-mega-menu').children('.mega-menu').clone();
            $(this).find('.dropdown').append(megaMenu);
        }
    });

    // elimina info mega menu della voce
    $('.site-navigation li.menu-item-has-children').on('mouseleave', function() {
        // $('ul.menu', this).stop(false, false).slideToggle('500');
        $('ul.menu', this).addClass('hide');
        $(this).toggleClass('exploded').children('.dropdown').children('.mega-menu').remove();
    });

    //mostra info mega menu della sottovoce
    // $('.site-navigation li.menu-item-has-children ul.dropdown li').on('mouseenter', function() {
    //     // $(this).parent('.dropdown').children('.mega-menu').remove();
    //     var megaMenu = $(this).children('a').find('.data-for-mega-menu').children('.mega-menu').clone();
    //     if (megaMenu.length > 0) {
    //         $(this).parent('.dropdown').children('.mega-menu').remove();
    //         $(this).parent('.dropdown').append(megaMenu);
    //     } else {
    //         $(this).parent('.dropdown').children('.mega-menu').remove();
    //     }
    //     // console.log(megaMenu);
    // });

    //elimina info mega menu della sottovoce
    // $('.site-navigation li.menu-item-has-children ul.dropdown li').on('mouseleave', function() {
    //     var megaMenu = $(this).children('a').find('.data-for-mega-menu').children('.mega-menu').clone();
    //     if (megaMenu.length > 0) {
    //         //do nothing
    //     } else {
    //         $(this).parent('.dropdown').children('.mega-menu').remove();
    //         var megaMenu = $(this).parents().find('.menu-item-has-children').children('a').find('.data-for-mega-menu').children('.mega-menu').clone();
    //         var firstParent = $(this).parent();
    //         var megaMenu = firstParent.parent().children('a').find('.data-for-mega-menu').children('.mega-menu').clone();
    //         $(this).parent('.dropdown').append(megaMenu);
    //         // $(this).parent('.dropdown').children('.mega-menu').remove();
    //     }
    // });


    /**
     * funzione che gestisce i sub menu del sito in versione mobile
     */
    // $(document).on('click', '.on-canvas-navigation li.menu-item-has-children', function() {
    //     //mostra e nascondi sottomenu
    //     $(this).find("ul.menu").stop(false, false).slideToggle('fast');
    //     $(this).toggleClass('exploded');
    // });

})(jQuery);


/**
 * scroll to top
 * from fn-ui-interactive-elements.php
 */
(function($) {
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop();
        if (scroll <= 200) {
            $(".scroll-to-top").hide();
        }
        if (scroll >= 500) {
            $(".scroll-to-top").show();
        }
    });

    $(document).on('click', '.scroll-to-top', function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
})(jQuery);

/**
 *
 * toggleText for jquery
 */

jQuery.fn.extend({
    toggleText: function(a, b) {
        var that = this;
        if (that.text() != a && that.text() != b) {
            that.text(a);
        } else
        if (that.text() == a) {
            that.text(b);
        } else
        if (that.text() == b) {
            that.text(a);
        }
        return this;
    }
});

/**
 * show-more
 * from fn-ui-interactive-elements.php
 */
(function($) {

    $('.show-more').on('click', function() {
        var self = $(this).parent().find('.roller-up');
        self.toggleClass('roll-this-down');
        $(this).toggleClass('show-less');
        $(this).toggleText(__('Show more', 'canva-frontend'), __('Show less', 'canva-frontend'));
    });

    $(document).on("facetwp-loaded", function() {
        $('.show-more').on('click', function() {
            var self = $(this).parent().find('.roller-up');
            self.toggleClass('roll-this-down');
            $(this).toggleClass('show-less');
            $(this).toggleText(__('Show more', 'canva-frontend'), __('Show less', 'canva-frontend'));
        });

    });

    $(document).on("facetwp-refresh", function() {
        $('.show-more').on('click', function() {
            var self = $(this).parent().find('.roller-up');
            self.toggleClass('roll-this-down');
            $(this).toggleClass('show-less');
            $(this).toggleText(__('Show more', 'canva-frontend'), __('Show less', 'canva-frontend'));
        });
    });
})(jQuery);



/**
 * roller inner blocks
 * from fn-ui-interactive-elements.php
 */
(function($) {

    $(document).on('click', '.roller-toggler-click', function() {
        $('.roller-toggler').slideToggle('500');
    });

})(jQuery);



/**
 * ajax modal post opener
 * ui html in fn-ui-interactive-elements.php
 *
 */

// Hap start
/* Ci sono due versioni.

La prima gestisce la modale anche sei prima del
breakpoint verticale (240px) in modo che appaia dopo l'header.
Però ha un bug sullo scrolldown.

La seconda (commentata), copre l'header se sei prima dei 240px di scroll.
Nella seconda bisogna aggiungere il behavior per il mobile (viewport e resize).

*/
(function($) {

    $(window).on('scroll resize', function() {

        var scroll = $(window).scrollTop();
        var view_port_width = $(window).width();
        var header_height = 0;

        // $('.slide').css('z-index','49');

        // modificare il template ed eliminare la riga successiva
        $('.modal-close-button.times.fixed').removeClass('fixed').addClass('absolute');

        // modificare il css ed eliminare la riga successiva
        // $('#modal-post-opener').css('transition','.2s all linear');

        if (view_port_width < 960) { // Mobile

            $('#modal-post-opener').removeClass('absolute').addClass('fixed');
            header_height = $('.mobile-navigation').outerHeight();
            $('#modal-post-opener').css('height', 'calc(100% - ' + header_height + 'px)');

        } else { // Desktop

            if (scroll < 240) { // Main nav (Stesso breakpoint del menu fisso)

                $('#modal-post-opener').removeClass('fixed').addClass('absolute');

                if ($('#alert-bar-above-menu').length && $('#alert-bar-above-menu').is(':visible')) {

                    banner_height = $('#alert-bar-above-menu').outerHeight();
                    partial_header_height = $('header').outerHeight();
                    header_height = banner_height + partial_header_height;

                } else {

                    header_height = $('header').outerHeight();

                }

                $('#modal-post-opener').css('height', '100%');

            } else { // Fixed nav

                $('#modal-post-opener').removeClass('absolute').addClass('fixed');

                header_height = $('.site-navigation-fixed').outerHeight();
                $('#modal-post-opener').css('height', 'calc(100% - ' + header_height + 'px)');

            }

        }

        $('#modal-post-opener').css('top', header_height + 'px');

    });

})(jQuery);

/*
Questo codice fa la stessa cosa del precedente ma se sei prima
del breakpoint verticale di 240px usa la posizione fixed per #modal-post-opener
con position top 0 (qundi copre il menu)
(function($) {

	$(window).on('scroll', function() {

		var scroll = $(window).scrollTop();
		var header_height = 0;

		// modificare il template ed eliminare la riga successiva
		$('.modal-close-button.times.fixed').removeClass('fixed').addClass('absolute');

		// modificare il css ed eliminare la riga successiva
		$('#modal-post-opener').css('transition','.2s all linear .1s');

		if (scroll < 240) { // Stesso breakpoint del menu fisso

			$('.slide').css('z-index','100');

		} else {

			$('.slide').css('z-index','49');
			header_height = $( '.site-navigation-fixed' ).outerHeight();

		}

		$('#modal-post-opener').css( 'height', 'calc(100% - ' + header_height + 'px)' );
		$('#modal-post-opener').css( 'top', header_height + 'px');

	});

})(jQuery);
*/
// Hap end

$(document).on('click', '.modal-post-open', function(e) {

    e.preventDefault();

    var ajaxUrl = WPURLS.ajaxurl;
    var id = $(this).attr('data-post-id');
    var actionName = $(this).attr('data-action-name');
    var templateName = $(this).attr('data-template-name');
    var nonce = $(this).attr('data-nonce');
    var animationIn = $(this).attr('data-animation-in');
    var animationOut = $(this).attr('data-animation-out');
    var containerClass = $(this).attr('data-modal-container-class');

    $(document).ajaxStart(function() {
            $('.loading').show();
        })
        .ajaxStop(function() {
            $('.loading').hide();
        });

    $.ajax(ajaxUrl + '?action=' + actionName + '&id=' + id + '&template=' + templateName + '&nonce=' + nonce)
        .done(function(content) {
            $('body').addClass('on-canvas-stop-scroll relative');
            $('#modal-post-opener').find('.modal-content').append(content);
            $('#modal-post-opener').show();

            if (!animationIn) {
                $('#modal-post-opener').addClass('slide-on-from-right');
            } else {
                $('#modal-post-opener').addClass(animationIn);
                $('.modal-close-button').attr('data-animation-in', animationIn);
                $('.modal-close-button').attr('data-animation-out', animationOut);
                $('.modal-close-button').attr('data-modal-container-class', containerClass);
            }

            if (!containerClass) {
                $('#modal-post-opener').find('.modal-content').addClass('bg-white');
            } else {
                $('#modal-post-opener').find('.modal-content').addClass(containerClass);
            }

        });

    // var postUrl = $(this).data('url');
    // window.history.pushState("object or string", "Title", postUrl);

});

$(document).on('click', '.modal-close-button', function() {

    var animationIn = $(this).attr('data-animation-in');
    var animationOut = $(this).attr('data-animation-out');
    var containerClass = $(this).attr('data-modal-container-class');

    $('body').removeClass('on-canvas-stop-scroll relative');

    if (!animationOut) {
        $('#modal-post-opener').addClass('slide-off-from-right');
    } else {
        $('#modal-post-opener').addClass(animationOut);
    }

    $('#modal-post-opener').find('.modal-content').empty();

    setTimeout(function() {

        if (!animationIn) {
            $('#modal-post-opener').removeClass('slide-on-from-right');
        } else {
            $('#modal-post-opener').removeClass(animationIn)
        }

    }, 500);

    setTimeout(function() {

        if (!animationOut) {
            $('#modal-post-opener').removeClass('slide-off-from-right');
        } else {
            $('#modal-post-opener').removeClass(animationOut);
        }

        $('#modal-post-opener').hide();

        $('#modal-post-opener').find('.modal-content').removeClass(containerClass);

    }, 700);

});

$(document).on('keyup', 'body', function(e) {
    var animationIn = $('.modal-close-button').attr('data-animation-in');
    var animationOut = $('.modal-close-button').attr('data-animation-out');
    var containerClass = $('.modal-close-button').attr('data-modal-container-class');

    if (e.which === 27) {

        $('html').removeClass('on-canvas-stop-scroll');
        $('body').removeClass('on-canvas-stop-scroll relative');
        $('#modal-post-opener').addClass('slide-off-from-right');
        $('#modal-post-opener').find('.modal-content').empty();

        setTimeout(function() {

            if (!animationIn) {
                $('#modal-post-opener').removeClass('slide-on-from-right');
            } else {
                $('#modal-post-opener').removeClass(animationIn)
            }

        }, 500);

        setTimeout(function() {

            if (!animationOut) {
                $('#modal-post-opener').removeClass('slide-off-from-right');
            } else {
                $('#modal-post-opener').removeClass(animationOut);
            }

            $('#modal-post-opener').hide();

            $('#modal-post-opener').find('.modal-content').removeClass(containerClass);

        }, 700);

    }
});


/**
 * FacetWP Filtri e cotrolli mobile Canva
 */

(function($) {

    // $(document).on('facetwp-loaded', function() {
    //     $('.loading').hide();
    // });

    $(window).on('facetwp-loaded facetwp-refresh', function() {

        $('.loading').hide();

        var scroll = $(window).scrollTop();
        var viewPortWidth = $(window).width();
        var viewPortHeight = $(window).height();
        // var results = $('#facet-results'); // Hap

        if (viewPortWidth < 640) {

            $('.facetwp-filters-show').show();
            $('.facetwp-filters-hide').hide();
            $('.facetwp-filters-container').hide();

            $(document).on('click', '.facetwp-filters-show', function() {
                $('.facetwp-filters-container').slideDown();
                $('.facetwp-filters-show').hide();
                $('.facetwp-filters-hide').show();
                $('.facetwp-filters-container').addClass('overflow-y h-100vh');
            });

            $(document).on('click', '.facetwp-filters-hide', function() {
                $('.facetwp-filters-container').slideUp();
                $('.facetwp-filters-hide').hide();
                $('.facetwp-filters-show').show();
                $('.facetwp-filters-container').removeClass('overflow-y h-100vh');
                // $('html,body').animate({ scrollTop: results.offset().top }, 'slow'); // Hap
                $('.loading').show();
                setTimeout(function() {
                    $('.facetwp-filters-container').hide();
                    $('.loading').hide();
                }, 350);
            });

        }

    });


    $(window).on('facetwp-loaded facetwp-refresh scroll', function() {

        var scroll = $(window).scrollTop();
        var viewPortWidth = $(window).width();
        var viewPortHeight = $(window).height();
        var mobileNavigationBarHeight = $(".mobile-navigation").outerHeight();
        var filtersPosition = $('.facetwp-filters').position();

        if (viewPortWidth < 640 && filtersPosition) {

            if (scroll > (filtersPosition.top - mobileNavigationBarHeight)) {
                $('.facetwp-filters').removeClass('sticky');
                $('.facetwp-filters').css({
                    'position': 'fixed',
                    'z-index': '10',
                    'width': '100%',
                    'top': mobileNavigationBarHeight + 'px',
                    'left': '0',
                    'padding': '.5rem 1rem',
                    'border-bottom': '1px solid #b8b8b6',
                });

                $('.facetwp-filters-container').addClass('overflow-y h-100vh');

            } else {
                $('.facetwp-filters').removeAttr('style');
                $('.facetwp-filters-container').removeClass('overflow-y h-100vh');
            }

        } else {
            // metti sticky se i filtri in desktop stanno dentro il viewPortHeight
            if ($('.facetwp-filters').outerHeight < viewPortHeight) {
                $('.facetwp-filters').addClass('sticky');
            }

        }

    });

    /* invia il pageview a google analytics mentre si utilizzano i filtri */
    $(document).on('facetwp-loaded', function() {
        if (FWP.loaded) {
            ga('send', 'pageview', window.location.pathname + window.location.search);
        }
    });

})(jQuery);





/**
 * Canva load b-lazy
 * from fn-register-styles.php
 *
 */
(function($) {

    ;
    (function() {
        var bLazy = new Blazy({
            breakpoints: [{
                    /* max-width */
                    width: 639,
                    src: 'data-src-small'
                },
                {
                    /* max-width */
                    width: 959,
                    src: 'data-src-medium'
                },
            ]
        });
    })();

    $(document).on("facetwp-loaded", function() {

        if (FWP.loaded) {
            //blazy load
            ;
            (function() {
                var bLazy = new Blazy({
                    breakpoints: [{
                            width: 639, //max-width
                            src: 'data-src-small'
                        },
                        {
                            width: 959, //max-width
                            src: 'data-src-medium'
                        },
                    ]
                });
            })();
        }
    });
})(jQuery);


/**
 *
 * sharetools copy to clipboard
 *
 */

var clipboard = new ClipboardJS('.copythistoshare');

clipboard.on('success', function(e) {
    alert("Link copiato");
    e.clearSelection();
});