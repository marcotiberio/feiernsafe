(function ($) {
    // generate map
    function new_map($el) {
        // var
        var $markers = $el.find('.marker');
        // vars
        var args = {
            zoom: 16,
            center: new google.maps.LatLng(0, 0),
            mapTypeId: 'roadmap',
            options: {
                scrollwheel: false,
                navigationControl: false,
                mapTypeControl: false,
                scaleControl: false,
                draggable: true,
                streetViewControl: false,
                fullScreenControl: false
            },
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            },
            styles: [{
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{
                        "hue": "#e9ebed"
                    }, {
                        "saturation": -78
                    }, {
                        "lightness": 67
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{
                        "hue": "#ffffff"
                    }, {
                        "saturation": -100
                    }, {
                        "lightness": 100
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [{
                        "hue": "#bbc0c4"
                    }, {
                        "saturation": -93
                    }, {
                        "lightness": 31
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{
                        "hue": "#ffffff"
                    }, {
                        "saturation": -100
                    }, {
                        "lightness": 100
                    }, {
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [{
                        "hue": "#e9ebed"
                    }, {
                        "saturation": -90
                    }, {
                        "lightness": -8
                    }, {
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{
                        "hue": "#e9ebed"
                    }, {
                        "saturation": 10
                    }, {
                        "lightness": 69
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "administrative.locality",
                    "elementType": "all",
                    "stylers": [{
                        "hue": "#2c2e33"
                    }, {
                        "saturation": 7
                    }, {
                        "lightness": 19
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "road",
                    "elementType": "labels",
                    "stylers": [{
                        "hue": "#bbc0c4"
                    }, {
                        "saturation": -93
                    }, {
                        "lightness": 31
                    }, {
                        "visibility": "on"
                    }]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels",
                    "stylers": [{
                        "hue": "#bbc0c4"
                    }, {
                        "saturation": -93
                    }, {
                        "lightness": -2
                    }, {
                        "visibility": "simplified"
                    }]
                },
                {
                    "featureType": "administrative.country",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "on"
                    }]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "on"
                    }]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "on"
                    }]
                },
                {
                    "featureType": "administrative.neighborhood",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels",
                    "stylers": [{
                        "visibility": "off"
                    }]
                },
                {
                    "featureType": "administrative.province",
                    "elementType": "labels.text",
                    "stylers": [{
                        "visibility": "on"
                    }]
                }


            ]
        };
        // create map	        	
        var map = new google.maps.Map($el[0], args);
        // add a markers reference
        map.markers = [];
        // add markers
        $markers.each(function () {
            add_marker($(this), map);
        });
        // center map
        center_map(map);
        return map;
    }

    // add the marker
    function add_marker($marker, map) {
        // var
        var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
        var customIcon = $marker.attr('data-icon');
        // create marker
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: customIcon
        });
        // add to array
        map.markers.push(marker);
        // if marker contains HTML, add it to an infoWindow
        if ($marker.html()) {
            // create info window
            var infowindow = new google.maps.InfoWindow({
                content: $marker.html()
            });
            // show info window when marker is clicked
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.open(map, marker);
            });
        }
    }

    // center the map
    function center_map(map) {
        // vars
        var bounds = new google.maps.LatLngBounds();
        // loop through all markers and create bounds
        $.each(map.markers, function (i, marker) {
            var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
            bounds.extend(latlng);
        });
        // only 1 marker?
        if (map.markers.length == 1) {
            // set center of map
            map.setCenter(bounds.getCenter());
            map.setZoom(16);
        } else {
            // fit to bounds
            map.fitBounds(bounds);
        }
    }

    // embed it
    var map = null;
    $(document).ready(function () {
        $('.acf-map').each(function () {
            // create map
            map = new_map($(this));
        });
    });
})(jQuery);
