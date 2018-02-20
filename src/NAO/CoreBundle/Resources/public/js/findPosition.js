function initMap()
{
	// Positionnement de la carte sur la France par defaut
        var france = {lat: 48.000, lng:  2.349};
        var map = new google.maps.Map(document.getElementById('findPosition'), {
        		zoom: 6,
        		center: france,
                  styles: [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.country",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.locality",
        "elementType": "all",
        "stylers": [
            {
                "color": "#5c821a"
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "all",
        "stylers": [
            {
                "color": "#5c821a"
            },
            {
                "weight": "0.01"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "all",
        "stylers": [
            {
                "weight": "9.39"
            }
        ]
    },
    {
        "featureType": "landscape.natural",
        "elementType": "all",
        "stylers": [
            {
                "saturation": "0"
            },
            {
                "lightness": "-10"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi.attraction",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi.business",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi.government",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi.medical",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "labels",
        "stylers": [
            {
                "color": "#333333"
            },
            {
                "weight": "0.01"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "transit.station",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#77c9d4"
            },
            {
                "visibility": "on"
            }
        ]
    }
]
        	});

        // Marqueur
        marker = new google.maps.Marker({
            map: map,
            icon: '/nao/web/bundles/naocore/img/marker.png',
            position: france,
            draggable: true 
        }); 

        // Récupération des données lors d'un déplacement du marqueur 
        var geocoder = new google.maps.Geocoder();
        var info = new google.maps.InfoWindow();
 
        geocoder.geocode({'latLng': france }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK)
                {
                        if (results[0])
                        {
                                $('#nao_birdbundle_observation_latitude, #nao_birdbundle_observation_longitude').show();
                                $('#nao_birdbundle_observation_latitude').val(marker.getPosition().lat());
                                $('#nao_birdbundle_observation_longitude').val(marker.getPosition().lng());
                        }
                }
        });

        google.maps.event.addListener(marker, 'dragend', function() {

                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK)
                        {
                                 if (results[0])
                                 {
                                         $('#nao_birdbundle_observation_latitude').val(marker.getPosition().lat());
                                         $('#nao_birdbundle_observation_longitude').val(marker.getPosition().lng());
                                }
                        }
                    });
        });
}
