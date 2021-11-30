mapboxgl.accessToken = 'pk.eyJ1IjoicmFwb295IiwiYSI6ImNrdzZtZ2JudDJ4OGYyb21xdTdyY2lvODEifQ.4r-kFtr5K0mssK_1c22R9A'

var map, curLng, curLat, places_temp, places

var layerIDs = []; // Will contain a list used to filter against.
var filterGroup = document.getElementById('filter-group');

navigator.geolocation.getCurrentPosition(successLocation, errorLocation, {
    enableHighAccuracy: true,
})

function goHere(lng1, lat1, lng2, lat2) {
    deleteExistingRoute()
    deleteExistingDistanceLabel()

    const _url = `https://api.mapbox.com/directions/v5/mapbox/driving-traffic/` + lng1 + `,` + lat1 + `;` + lng2 + `,` + lat2 + `?overview=full&geometries=geojson&access_token=` + mapboxgl.accessToken
    console.log(_url)

    $.ajax({
        url: _url,
        method: 'get',
        success: function (response) {

            map.addLayer({
                id: 'route',
                type: 'line',
                source: {
                    'type': 'geojson',
                    'data': {
                        'type': 'Feature',
                        'properties': {},
                        'geometry': {
                            'type': 'LineString',
                            'coordinates': response.routes[0].geometry.coordinates,
                        },
                    }
                },
                layout: {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                paint: {
                    'line-color': '#FF0000',
                    'line-width': 8
                }
            })

            // add distance label
            map.addSource('distanceLabel', {
                'type': 'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': [{
                            'type': 'Feature',
                            'geometry': {
                                'type': 'Point',
                                'coordinates': [
                                    parseFloat(lng2), parseFloat(lat2)
                                ]
                            },
                            'properties': {
                                'description': response.routes[0].distance + " m"
                            }
                        }
                    ]
                }
            });

            map.addLayer({
                'id': 'distanceLabelLayer',
                'type': 'symbol',
                'source': 'distanceLabel',
                'layout': {
                    'text-field': ['get', 'description'],
                    'text-font': [
                        'Open Sans Semibold',
                        'Arial Unicode MS Bold'
                    ],
                    'text-offset': [0, -9],
                    'text-anchor': 'top'
                }
            });

            map.flyTo({center:[lng2, lat2]})
        }
    });

}

function deleteExistingRoute(){
    try {
        map.removeLayer('route')
        map.removeSource('route')
    } catch(err) {
        console.log(err)
    }
}

function deleteExistingDistanceLabel(){
    try {
        map.removeLayer('distanceLabelLayer')
        map.removeSource('distanceLabel')
    } catch(err) {
        console.log(err)
    }
}

function createPost() {
    var id = $('#post_id').val()
    var lat = $('#lat').val()
    var long = $('#long').val()
    var name = $('#name').val()
    var detail = $('#detail').val()
    var category = $('#category').val()

    let _url     = `/store`
    let _token   = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        url: _url,
        type: "POST",
        data: {
            lat: lat,
            long: long,
            name: name,
            detail: detail,
            category: category,
            _token: _token
        },
        success: function(response) {
            // if(response.code == 200) {
                if(id != ""){
                // $("#row_"+id+" td:nth-child(2)").html(response.data.title);
                // $("#row_"+id+" td:nth-child(3)").html(response.data.description);
                // } else {
                // $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.id+'</td><td>'+response.data.title+'</td><td>'+response.data.description+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editPost(event.target)" class="btn btn-info">Edit</a></td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deletePost(event.target)">Delete</a></td></tr>');
                }
                // $('#title').val('');
                // $('#description').val('');
                $('#post_id').val('')
                $('#lat').val('')
                $('#long').val('')
                $('#name').val('')
                $('#detail').val('')
                $('#category').val('')
                $('#exampleModal').modal('hide')
                alert("successfully added.")

            // }
        },
        error: function(response) {
            alert("successfully added.")
            $('#exampleModal').modal('hide')
            // places.features.push({
            //     'type': 'Feature',
            //     'geometry': {
            //         'type': 'Point',
            //         'coordinates': [112.79736595588975, -7.279610131414344]
            //     },
            //     'properties': {
            //         'description':
            //         '<strong>Informatika</strong><p>Dalam perkuliahan di Informatika ITS, mahasiswa mendapatkan banyak ilmu dan pengalaman terkait komputer, pemrograman terstruktur, dan dalam tahap sarjana mahasiswa berhak memilih program studi yang disediakan.</p><p>https://www.instagram.com/hmtc_its/</p>',
            //     'icon': 'foods'
            //     }
            // })
        //     $('#titleError').text(response.responseJSON.errors.title);
        //     $('#descriptionError').text(response.responseJSON.errors.description);
        }
    })
}

function successLocation(position) {
    console.log(position)
    curLng = position.coords.longitude
    curLat = position.coords.latitude
    setupMap([position.coords.longitude, position.coords.latitude])
}

function errorLocation(position) {
    //default long lat jakarta
    setupMap([106.82715278978065, -6.175480714788165]) 
}

function setupMap(center) {
    var _url = "/getMapData" 
    $.ajax({
        url: _url,
        type: "GET",
        async: false,
        success: function(response) {
            if(response) {
                places_temp = response.data
            }
        }
    })
    // var markerdata = {
    //     'type': 'Feature',
    //     'geometry': {
    //         'type': 'Point',
    //         'coordinates': [112.79736595588975, -7.279610131414344]
    //     },
    //     'properties': {
            // 'description':
            //     '<strong>Informatika</strong><p>Dalam perkuliahan di Informatika ITS, mahasiswa mendapatkan banyak ilmu dan pengalaman terkait komputer, pemrograman terstruktur, dan dalam tahap sarjana mahasiswa berhak memilih program studi yang disediakan.</p><p>https://www.instagram.com/hmtc_its/</p>',
            // 'icon': 'foods'
    //     }
    // }
    var marker = []
    for (let i = 0; i < places_temp.length; i++) {
        marker.push({
            'type': 'Feature',
            'geometry': {
                'type': 'Point',
                'coordinates': [
                    places_temp[i].long,
                    places_temp[i].lat
                ]
            },
            'properties': {
                'description':
                    '<h2>' + places_temp[i].name + '</h2>' + '<p>' + places_temp[i].detail + '</p>' + '<p>category: ' + places_temp[i].category + '</p>',
                'icon': places_temp[i].category
            }

        })
        
    }
    places = {
        'type': 'FeatureCollection',
        'features': marker 
    }   

    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: center,
        zoom: 12
    })

    // for (const feature of places.features) {
    //     // create a HTML element for each feature
    //     const el = document.createElement('div');
    //     el.className = 'marker';

    //     // make a marker for each feature and add it to the map
    //     new mapboxgl.Marker(el)
    //       .setLngLat(feature.geometry.coordinates)
    //       .setPopup(
    //         new mapboxgl.Popup({ offset: 25 }) // add popups
    //           .setHTML(
    //             `<p>${feature.properties.description}</p>`
    //           )
    //       )
    //       .addTo(map);
    //   }

    map.on('style.load', function() {
        map.on('click', function(e) {
            var coordinates = e.lngLat;
            new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(`
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Save
            </button> <br>
            <button type="button" class="btn btn-info" onclick="goHere(`+ curLng + ',' + curLat + ',' + coordinates.lng + ',' +  coordinates.lat +`)">
                Go Here
            </button>
            `)
            .addTo(map);
            document.getElementById("lat").value = coordinates.lat;
            document.getElementById("long").value = coordinates.lng;
        })
    })
    map.on('load', function () {
        map.loadImage(
            'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',
            // Add an image to use as a custom marker
            function (error, image) {
                if (error) throw error;
                map.addImage('custom-marker', image);

                map.addSource('places', {
                    'type': 'geojson',
                    'data': places
                });

                places.features.forEach(function (feature) {
                    var symbol = feature.properties['icon'];
                    var layerID = 'poi-' + symbol;
                    console.log

                    // Add a layer for this symbol type if it hasn't been added already.
                    if (!map.getLayer(layerID)) {
                        map.addLayer({
                            'id': layerID,
                            'interactive': 'true',
                            'type': 'symbol',
                            'source': 'places',
                            'layout': {
                                'icon-image': 'custom-marker',
                                'icon-allow-overlap': true,
                            },
                            'filter': ['==', 'icon', symbol]
                        });

                        // Add checkbox and label elements for the layer.
                        var input = document.createElement('input');
                        input.type = 'checkbox';
                        input.id = layerID;
                        input.checked = true;
                        filterGroup.appendChild(input);

                        var label = document.createElement('label');
                        label.setAttribute('for', layerID);
                        label.textContent = symbol;
                        filterGroup.appendChild(label);

                        // When the checkbox changes, update the visibility of the layer.
                        input.addEventListener('change', function (e) {
                            map.setLayoutProperty(
                                layerID,
                                'visibility',
                                e.target.checked ? 'visible' : 'none'
                            );
                        });

                        // Create a popup, but don't add it to the map yet.
                        var popup = new mapboxgl.Popup({
                            closeButton: false,
                            closeOnClick: false
                        });

                        map.on('mouseenter', layerID, function (e) {
                            // Change the cursor style as a UI indicator.
                            map.getCanvas().style.cursor = 'pointer';

                            var coordinates = e.features[0].geometry.coordinates.slice();
                            var description = e.features[0].properties.description;

                            // Ensure that if the map is zoomed out such that multiple
                            // copies of the feature are visible, the popup appears
                            // over the copy being pointed to.
                            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                            }

                            // Populate the popup and set its coordinates
                            // based on the feature found.
                            popup.setLngLat(coordinates).setHTML(description).addTo(map);
                        });

                        map.on('mouseleave', layerID, function () {
                            map.getCanvas().style.cursor = '';
                            popup.remove();
                        });

                        layerIDs.push(layerID);
                    }
                });
            }
        );
    });

    const coordinatesGeocoder = function(query) {
        // Match anything which looks like
        // decimal degrees coordinate pair.
        const matches = query.match(
            /^[ ]*(?:Lat: )?(-?\d+\.?\d*)[, ]+(?:Lng: )?(-?\d+\.?\d*)[ ]*$/i
        );
        if (!matches) {
            return null;
        }

        function coordinateFeature(lng, lat) {
            return {
                center: [lng, lat],
                geometry: {
                    type: 'Point',
                    coordinates: [lng, lat]
                },
                place_name: 'Lat: ' + lat + ' Lng: ' + lng,
                place_type: ['coordinate'],
                properties: {},
                type: 'Feature'
            };
        }

        const coord1 = Number(matches[1]);
        const coord2 = Number(matches[2]);
        const geocodes = [];

        if (coord1 < -90 || coord1 > 90) {
            // must be lng, lat
            geocodes.push(coordinateFeature(coord1, coord2));
        }

        if (coord2 < -90 || coord2 > 90) {
            // must be lat, lng
            geocodes.push(coordinateFeature(coord2, coord1));
        }

        if (geocodes.length === 0) {
            // else could be either lng, lat or lat, lng
            geocodes.push(coordinateFeature(coord1, coord2));
            geocodes.push(coordinateFeature(coord2, coord1));
        }

        return geocodes;
    };

    map.addControl(
        new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            localGeocoder: coordinatesGeocoder,
            zoom: 12,
            placeholder: 'Try: -40, 170',
            mapboxgl: mapboxgl,
            reverseGeocode: true
        })
    )

    map.addControl(
        new mapboxgl.GeolocateControl({
        positionOptions: {
        enableHighAccuracy: true
        },
        // When active the map will receive updates to the device's location as it changes.
        trackUserLocation: true,
        // Draw an arrow next to the location dot to indicate which direction the device is heading.
        showUserHeading: true
        })
    );

    map.addControl(new mapboxgl.NavigationControl())
}