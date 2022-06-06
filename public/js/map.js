
var markers = [];
var Map;

function MapInit() {

    if(document.getElementById('map') !== null) {
        Map = new google.maps.Map(document.getElementById('map'), {
            zoom: 18,
            streetViewControl: false
        });

        if (typeof definedLocation !== 'object') {
            navigator.geolocation.getCurrentPosition(function (pos) {
                var position = {lat: pos.coords.latitude, lng: pos.coords.longitude};
                Map.setCenter(position);
            });
        }
        else {
            marker = new google.maps.Marker({
                position: definedLocation,
                map: Map
            });
            markers.push(marker);
            Map.setCenter(definedLocation);
        }

		if(route == 'kosanform'){
			google.maps.event.addListener(Map, 'click', function (event) {
				for (var i = 0; i < markers.length; i++)
					markers[i].setMap(null);
				marker = new google.maps.Marker({
					position: event.latLng,
					map: Map
				});
				document.getElementById('latitude').value = marker.position.lat();
				document.getElementById('longitude').value = marker.position.lng();
				markers.push(marker);
			});
		}
    }

    // Autocomplete
    var input = (document.getElementById('location-field'));
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.setTypes([]);
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (place.geometry) {
            document.getElementById('lat-search').value = place.geometry.location.lat();
            document.getElementById('lng-search').value = place.geometry.location.lng();
            document.getElementById('location-field').value = input.value;
        }
    });

}
