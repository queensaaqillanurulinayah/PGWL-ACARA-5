@extends('layouts.template')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #map {
            height: calc(100vh - 56px);
            /* menyesuaikan tinggi navbar */
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <!-- MAP -->
    <div id="map"></div>

    <!-- MODAL Form Edit-->
    <div class="modal" tabindex="-1" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('point.update', $id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Name</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Fill Name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Fill Description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geometry" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry" name="geometry" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image"
                                onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                        </div>

                        <div class="mb-3">
                            <img src="" alt="" id="preview-image-point" class="img-thumbnail"
                                width="400">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <script src="https://unpkg.com/@terraformer/wkt"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // inisialisasi map
        var map = L.map('map').setView([-7.7956, 110.3695], 12);

        // basemap OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
            maxZoom: 19
        }).addTo(map);

        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: false,
            edit: {
                featureGroup: drawnItems,
                edit: true,
                remove: false
            }
        });

        map.addControl(drawControl);

        map.on('draw:edited', function(e) {
            var layers = e.layers;

            layers.eachLayer(function(layer) {
                var drawnJSONObject = layer.toGeoJSON();
                console.log(drawnJSONObject);

                var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);
                console.log(objectGeometry);

                // layer properties
                var properties = drawnJSONObject.properties;
                console.log(properties);

                drawnItems.addLayer(layer);
                $('#nama').val(properties.nama);
                $('#description').val(properties.description);
                $('#geometry').val(objectGeometry);
                $('#preview-image').attr('src', "{{  asset('storage/images') }}/" + properties.image);

                $('#modalEdit').modal('show');
            });
        });

        // GeoJSON Point
        var points = L.geoJSON(null, {
            // Style

            // onEachFeature
            onEachFeature: function(feature, layer) {

                drawnItems.addLayer(layer);

                var properties = feature.properties;
                var objectGeometry = Terraformer.geojsonToWKT(feature.geometry);

                layer.on({
                    click: function(e) {
                        $('#nama').val(properties.nama);
                        $('#description').val(properties.description);
                        $('#geometry').val(objectGeometry);
                        $('#preview-image').attr('src', "{{  asset('storage/images') }}/" + properties.image);

                        $('#modalEdit').modal('show');
                    },
                });
            },

        });

        $.getJSON("{{ route('geojson_point', $id) }}", function(data) {
            points.addData(data);
            map.addLayer(points);
        });
    </script>
@endsection
