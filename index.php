<!DOCTYPE html>
<html>
<head>
    <title>Place searches</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        html, body, #container, #right {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 100%;
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
        var history;

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

                        lat = obj.location.lat;
                        lng = obj.location.lng;

                        $('#history').html(obj.history);

                        initMap();
                    }
                });

            });

            $( document ).ready(function() {
                $('form').submit();
            });

        });
    </script>
</head>
<body>
<div id="container" style="width:100%;">
    <div id="left" style="float:left; width:50%; text-align: center; margin-top: 100px;">
        <form method="post">
            <input name="address" value="Pyongyang" type="text"/>
            <input type="submit">
        </form>
        <br/><br/><br/><br/>
        Search history (last 10 searches): <br/><br/>
        <div id="history"></div>
    </div>
    <div id="right" style="float:right; width:50%;"> <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALikotQ4kOr_KpOM2wmVYiYO4O1tVD0SA&libraries=places&callback=initMap" async defer></script> </div>
</div>



</body>
</html>