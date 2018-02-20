function initMap() 
{
  // Carte de France
    var france = {lat: 46.864, lng:  2.349};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            maxZoom: ((who == 'nat') ? 12 : 7),
            center: france,
            zoomControl: ((who == 'nat') ? true : false),
            zoomControlOptions: {
              position: google.maps.ControlPosition.RIGHT_CENTER
            },
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
        
        // Marker clusterer
        var markers = locations.map(function(location, i) {
                  var marker = new google.maps.Marker({
                    position: location,
                    icon: '/nao/web/bundles/naocore/img/marker.png'
                  });

                  // Affichage des infos
                  var info = new google.maps.InfoWindow({
                        content: '<div id="photoContent">' + '<img id="birdPhotoMap" src="/nao/web/uploads/img/' + birds[i].filename + '" alt="' + birds[i].alt + '">'  + '</div><br>' +
                        '<p><strong>' + birds[i].birdname.toUpperCase() + '</strong><br>(' + birds[i].species +  ')</p>' +
                        '<p>Observé par :  ' + birds[i].firstname + '  ' + birds[i].lastname + ' <br> le : ' + birds[i].date + '</p><p><strong>Latitude</strong> : ' +  ((who == 'nat') ? birds[i].lat : '-')  + '<br><strong>Longitude</strong> : ' +  ((who == 'nat') ? birds[i].lng: '-')  + '<p><p><a href="https://fr.wikipedia.org/wiki/' + birds[i].birdname.toLowerCase() + '">Wikipédia</a></p>'
                      });

                  marker.addListener('click', function() {
                     info.open(map, marker);
                  });

                  return marker;

                }, birds);
      
      // Marqueur clusterer
          var markerCluster = new MarkerClusterer(map, markers,
                      {imagePath: '/nao/web/bundles/naocore/img/m',
                      zoomOnClick: ((who == 'nat') ? true : false)
              });
}

// Tableau des oiseaux
var birds = [];

// Tableau de localisation
var locations = [];

// Récupération des données d'observation
var obsQuantity = document.getElementById('obsQuantity').value;

var who = document.getElementById('who').value;

for (var i = 1; i <= parseInt(obsQuantity); i++)
{
        var birdnameVal = document.getElementById('birdname' + i).value;
        var speciesVal = document.getElementById('species' + i).value;

        var latVal = document.getElementById('lat' + i).value;

        if (parseFloat(latVal) < 0)
        {
            var latVal = document.getElementById('lat' + i).value.substr(0, 6);
        }
        else
        {
            var latVal = document.getElementById('lat' + i).value.substr(0, 5);
        }

        var lngVal = document.getElementById('lng' + i).value;

        if (parseFloat(lngVal) < 0)
        {
            var lngVal = document.getElementById('lng' + i).value.substr(0, 6);
        }
        else
        {
            var lngVal = document.getElementById('lng' + i).value.substr(0, 5);
        }

        var filenameVal = document.getElementById('filename' + i).value;
        var altVal = document.getElementById('alt' + i).value;
        var dateVal = document.getElementById('date' + i).value;
        var firstnameVal = document.getElementById('firstname' + i).value;
         var lastnameVal = document.getElementById('lastname' + i).value;

         locations.push({lat: parseFloat(latVal), lng: parseFloat(lngVal)});

         birds.push(
          {birdname: birdnameVal, species: speciesVal, filename: filenameVal, alt: altVal, date: dateVal, firstname: firstnameVal, lastname: lastnameVal, lat: latVal, lng: lngVal}
          );
}
