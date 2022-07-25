// for async stuff
function initMap() {} // now it IS a function and it is in global

// funzione mappa google maps centro
(function($) {
    let map;

    // console.log($('#centroMap').attr('data-lat'));
    // console.log($('#centroMap').attr('data-lng'));

    initMap = function() {
        const mapOptions = {
            zoom: 18,
            center: {
                lat: parseFloat($('#centroMap').attr('data-lat')),
                lng: parseFloat($('#centroMap').attr('data-lng'))
            },
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: false,
            rotateControl: false,
            fullscreenControl: true,
            styles: google_maps_style,
        };

        let mapDiv = document.getElementById("centroMap");

        if (mapDiv) {
            map = new google.maps.Map(mapDiv, mapOptions);

            const marker = new google.maps.Marker({
                // The below line is equivalent to writing:
                // position: new google.maps.LatLng(xx.xxx, xx.xxx)
                position: {
                    lat: parseFloat($('#centroMap').attr('data-lat')),
                    lng: parseFloat($('#centroMap').attr('data-lng'))
                },
                map: map,
            });

            // You can use a LatLng literal in place of a google.maps.LatLng object when
            // creating the Marker object. Once the Marker object is instantiated, its
            // position will be available as a google.maps.LatLng object. In this case,
            // we retrieve the marker's position using the
            // google.maps.LatLng.getPosition() method.
            // const infowindow = new google.maps.InfoWindow({
            // 	content: "<p>Marker Location:" + marker.getPosition() + "</p>",
            // });

            // google.maps.event.addListener(marker, "click", () => {
            // 	infowindow.open(map, marker);
            // });
        }
    }

    // round modal
    $(document).on('click', '.round-modal-open', function() {

        $(this).addClass('active');
        $(this).children('span').hide();

        setTimeout(function() {
            $('.round-modal-wrap').fadeIn();
        }, 1000);

    });

    $(document).on('click', '.round-modal-close', function() {

        $('.round-modal-wrap').fadeOut();
        $('.round-modal-open').removeClass('active');

        setTimeout(function() {
            $('.round-modal-open').children('span').show();
        }, 2000);

    });

})(jQuery);

// funzioni per modificare facetwp
(function($) {
    // cambia il nome del pulsante dell cerca con autocomplete da vai in Cerca
    $(window).on('facetwp-loaded facetwp-refresh', function() {
        $('.facetwp-autocomplete-update').attr('value', 'Cerca');
    });
})(jQuery);


// funzione per attivare il reading time per gli articoli del blog
$(function() {
    $('.single-post article').readingTime({
        wordsPerMinute: 270,
        readingTimeTarget: $('.reading-time'),
        wordCountTarget: '.words',
        lang: 'it',
    });
});


(function($) {

	$(document).on('click', '._expand', function(){
		$(this).find("._persona-large-clip").animate({ height: '100%'}, 'slow');
		$(this).addClass('_unexpand');
		$(this).removeClass('_expand');
	});

	$(document).on('click', '._unexpand', function(){
		$(this).find("._persona-large-clip").animate({ height: '70%'}, 'slow');
		$(this).addClass('_expand');
		$(this).removeClass('_unexpand');
	});

})(jQuery);


