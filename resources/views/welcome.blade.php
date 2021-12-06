<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ur Saved Places</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <style>
            body{
                margin: 0;
                padding: 0;
            }
            
            #map{
                height: 100vh;
                width: 100vw;
            }
            /* .marker {
                background-image: url('https://docs.mapbox.com/help/demos/custom-markers-gl-js/mapbox-icon.png');
                background-size: cover;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                cursor: pointer;
            } */
            .mapboxgl-popup-content {
                text-align: center;
                font-family: 'Open Sans', sans-serif;
            }
        </style>
        {{-- ajax --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- mapbox bundle --}}
        <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet'>
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" type="text/css">
        {{-- js buat ajax --}}
        <script type="text/javascript" src="{{ URL::asset('js/test.js') }}" defer></script>
        <style>
            .mapboxgl-popup {
                max-width: 400px;
                font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
            }
    
            .filter-group {
                font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
                font-weight: 600;
                position: absolute;
                top: 65px;
                right: 125px;
                z-index: 1;
                border-radius: 3px;
                width: 120px;
                color: #fff;
            }
    
            .filter-group input[type='checkbox']:first-child + label {
                border-radius: 3px 3px 0 0;
            }
    
            .filter-group label:last-child {
                border-radius: 0 0 3px 3px;
                border: none;
            }
    
            .filter-group input[type='checkbox'] {
                display: none;
            }
    
            .filter-group input[type='checkbox'] + label {
                background-color: #5fde4b;
                display: block;
                cursor: pointer;
                padding: 10px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.25);
            }
    
            .filter-group input[type='checkbox'] + label {
                background-color: #3386c0;
                text-transform: capitalize;
            }
    
            .filter-group input[type='checkbox'] + label:hover,
            .filter-group input[type='checkbox']:checked + label {
                background-color: #5fde4b;
            }
    
            .filter-group input[type='checkbox']:checked + label:before {
                content: '✔';
                margin-right: 5px;
            }
        </style>
    </head>
    <body>
        <div id='map'></div>
        <nav id="filter-group" class="filter-group"></nav>

        {{-- modal --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form name="mapForm" action="{{ route('map.add') }}" method="post">
                @csrf
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="lat" name="lat">
                        <input type="hidden" class="form-control" id="long" name="long">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Place Name:</label>
                            <input required type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="col-form-label">Detail:</label>
                            <input required type="text" class="form-control" id="detail" name="detail">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="col-form-label">Category:</label>
                            {{-- <input required type="text" class="form-control" id="category" name="category"> --}}
                            <input type="text" list="category" class="form-control" name="category">
                            <datalist id="category">
                            @foreach ($maps as $map)
                                <option>{{ $map->category }}</option>
                            @endforeach
                            </datalist>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                    </div>
                  </div>
                </div>
            </form>
        </div>
    </body>
</html>
