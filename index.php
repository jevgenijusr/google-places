<!DOCTYPE html>
<html>
<head>
    <title>Jevgenijus</title>
    <style>
        a {
            color: #ff0;
        }
        .cover {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 2;
            width: 100%;
            height: 100%;
        }
        .cover .hi {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Roboto Slab', serif;
            font-size: 24px;
            line-height: 26px;
            text-align: center;
        }
    </style>
    <script>
        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

        var map;
        var infowindow;
        var lat = -33.867;
        var lng = 151.195;

        function initMap() {
            var pyrmont = {lat: lat, lng: lng};

            map = new google.maps.Map(document.getElementById('map'), {
                center: pyrmont,
                zoom: 15
            });

            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch({
                location: pyrmont,
                radius: 500,
                type: ['store']
            }, callback);
        }

        function callback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    createMarker(results[i]);
                }
            }
        }

        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(place.name);
                infowindow.open(map, this);
            });
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $(function () {

            $('form').on('submit', function (e) {

                e.preventDefault();

                var val = $('form').find('input[name="address"]').val();

                $.ajax({
                    type: 'post',
                    url: 'post.php?input=' + val,
                    data: $('form').serialize(),
                    success: function (data) {

                        var obj = jQuery.parseJSON( data );

                        lat = obj.lat;
                        lng = obj.lng;

                        initMap();
                    }
                });

            });

        });
    </script>
</head>
<body>
    <div class="cover">
        <div class="hi">
            <div style="height:400px; width: 600px;" id="map"></div>
            <form method="post">
                <input name="address" type="text"/>
                <input type="submit">
            </form>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALikotQ4kOr_KpOM2wmVYiYO4O1tVD0SA&libraries=places&callback=initMap" async defer></script>
        </div>
    </div>
</body>

</html>
