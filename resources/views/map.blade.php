@extends('layouts.template')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <style>
        /* HALAMAN */
        html,
        body {
            height: 100%;
            margin: 0;
            background: #eef4ff;
            font-family: 'Segoe UI', sans-serif;
        }

        /* MAP */
        #map {
            height: calc(100vh - 56px);
            width: 100%;
            border-radius: 22px;
            overflow: hidden;
            border: 5px solid #ffffff;
            box-shadow: 0 12px 35px rgba(13, 110, 253, .25);
            transition: .3s ease;
        }

        #map:hover {
            box-shadow: 0 16px 40px rgba(13, 110, 253, .35);
        }

        /* ZOOM + DRAW TOOL */
        .leaflet-bar {
            border: none !important;
            border-radius: 16px !important;
            overflow: hidden;
            box-shadow: 0 6px 18px #3a65db26;
        }

        /* TOOL DRAW */
        .leaflet-draw-toolbar a {
            background-color: #ccddf8 !important;
            border-bottom: 1px solid #ffffff30 !important;
            transition: .3s;
        }

        /* Hover */
        .leaflet-draw-toolbar a:hover {
            background-color: #4da3ff !important;
        }

        /* Tombol aktif */
        .leaflet-draw-toolbar .leaflet-draw-toolbar-button-enabled {
            background-color: #083d99 !important;
        }

        /* Container */
        .leaflet-draw-toolbar {
            border-radius: 14px !important;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(13, 110, 253, .25);
        }

        /* CONTROL LAYER */
        .leaflet-control-layers {
            border: none !important;
            border-radius: 18px !important;
            background: rgba(255, 255, 255, .95) !important;
            box-shadow: 0 8px 24px rgba(13, 110, 253, .18);
            padding: 10px;
        }

        .leaflet-control-layers-expanded {
            color: #244b88;
            font-weight: 500;
        }

        /* POPUP */
        .leaflet-popup-content-wrapper {
            background: linear-gradient(180deg, #ffffff, #f5f9ff);
            border-radius: 18px !important;
            box-shadow: 0 10px 25px rgba(13, 110, 253, .18);
            border-top: 5px solid #0d6efd;
        }

        .leaflet-popup-content {
            margin: 18px;
            font-size: 14px;
            line-height: 1.8;
            color: #34495e;
        }

        .leaflet-popup-tip {
            background: #ffffff;
        }

        /* GAMBAR POPUP */
        .leaflet-popup-content img {
            border-radius: 14px;
            margin-top: 10px;
            border: 3px solid #dbeafe;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .12);
        }

        /* BUTTON POPUP */
        .leaflet-popup-content .btn {
            border-radius: 10px;
            transition: .25s;
            font-weight: 600;
        }

        .leaflet-popup-content .btn:hover {
            transform: translateY(-2px);
        }

        /* ATTRIBUTION */
        .leaflet-control-attribution {
            background: rgba(255, 255, 255, .92) !important;
            border-radius: 12px;
            padding: 5px 12px;
            color: #0d47a1;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .10);
        }

        /* SCROLLBAR POPUP */
        .leaflet-popup-content::-webkit-scrollbar {
            width: 6px;
        }

        .leaflet-popup-content::-webkit-scrollbar-thumb {
            background: #60a5fa;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <!-- MAP -->
    <div id="map"></div>

    <!-- MODAL Input untuk point-->
    <div class="modal" tabindex="-1" id="modalInputPoint">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('points.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
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
                            <label for="geometry_point" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_point" name="geometry_point" rows="3"></textarea>
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

    <!-- MODAL Input untuk polyline-->
    <div class="modal" tabindex="-1" id="modalInputPolyline">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polyline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polylines.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
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
                            <label for="geometry_polyline" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polyline" name="geometry_polyline" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image"
                                onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
                        </div>

                        <div class="mb-3">
                            <img src="" alt="" id="preview-image-polyline" class="img-thumbnail"
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

    <!-- MODAL Input untuk polygon-->
    <div class="modal" tabindex="-1" id="modalInputPolygon">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polygon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('polygons.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
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
                            <label for="geometry_polygon" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geometry_polygon" name="geometry_polygon" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image"
                                onchange="document.getElementById('preview-image-polygon').src = window.URL.createObjectURL(this.files[0])">
                        </div>

                        <div class="mb-3">
                            <img src="" alt="" id="preview-image-polygon" class="img-thumbnail"
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
            draw: {
                position: 'topleft',
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },
            edit: false
        });

        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;

            console.log(type);

            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            console.log(drawnJSONObject);
            console.log(objectGeometry);

            if (type === 'polyline') {
                console.log("Create " + type);

                //Set value geometry to geometry_polyline textarea
                $('#geometry_polyline').val(objectGeometry);

                //Show Modal Input Polyline
                $('#modalInputPolyline').modal('show');

                //Modal dismiss reload page
                $('#modalInputPolyline').on('hidden.bs.modal', function() {
                    location.reload();
                });

            } else if (type === 'polygon' || type === 'rectangle') {
                console.log("Create " + type);

                //Set value geometry to geometry_polygon textarea
                $('#geometry_polygon').val(objectGeometry);

                //Show Modal Input Polygon
                $('#modalInputPolygon').modal('show');

                //Modal dismiss reload page
                $('#modalInputPolygon').on('hidden.bs.modal', function() {
                    location.reload();
                });

            } else if (type === 'marker') {
                console.log("Create " + type);

                //Set value geometry to geometry_point textarea
                $('#geometry_point').val(objectGeometry);

                //Show Modal Input Point
                $('#modalInputPoint').modal('show');

                //Modal dismiss reload page
                $('#modalInputPoint').on('hidden.bs.modal', function() {
                    location.reload();
                });
            } else {
                console.log('__undefined__');
            }

            drawnItems.addLayer(layer);
        });

        // GeoJSON Point
        var points = L.geoJSON(null, {
            // Style

            // onEachFeature
            onEachFeature: function(feature, layer) {
                //Route delete point
                var routedelete = "{{ route('points.delete', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);

                //Route edit point
                var routeedit = "{{ route('point.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);

                // variable popup content
                var popup_content =
                    "Nama: " + feature.properties.nama + "<br>" +
                    "Description: " + feature.properties.description + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.properties.image +
                    "' alt='Image Point' class='img-thumbnail' width='600'>" +
                    "<br><br>" +
                    "<div class='row'>" +
                    "<div class='col-2'>" +
                    "<form action='" + routedelete + "' method='post'>" +
                    '@csrf' +
                    '@method('delete')' +
                    "<button type='submit' class='btn btn-sm btn-danger' title='Delete feature' onclick='return confirm(`Are you sure want to delete this feature?`)'>" +
                    "<i class='fa-solid fa-trash'></i>" +
                    "</button>" +
                    "</form>" +
                    "</div>" +

                    "<div class='col-2'>" +
                    "<a href='" + routeedit + "' class='btn btn-warning btn-sm' title='Edit Points'>" +
                    "<i class='fa-solid fa-pen-to-square'></i>" +
                    "</a>" +
                    "</div>" +

                    "</div>";

                layer.on({
                    click: function(e) {
                        points.bindPopup(popup_content);
                    },
                });
            },

        });

        var polylines = L.geoJSON(null, {
            // Style

            // onEachFeature
            onEachFeature: function(feature, layer) {
                //Route delete polylines
                var routedelete = "{{ route('polylines.delete', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);

                var routeedit = "{{ route('polyline.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);

                // variable popup content
                var popup_content = "Nama: " + feature.properties.nama + "<br>" +
                    "Description: " + feature.properties.description + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.
                properties.image + "' alt='Image Polyline' class='img-thumbnail' width='600'>" +
                    "<br><br>" + "<div class='row'>" +
                    "<div class='col-2'>" +
                    "<form action='" + routedelete + "' method='post'>" +
                    '@csrf' +
                    '@method('delete')' +
                    "<button type='submit' class='btn btn-sm btn-danger' title='Delete feature' onclick='return confirm(`Are you sure want to delete this feature?`)'>" +
                    "<i class='fa-solid fa-trash'></i>" +
                    "</button>" +
                    "</form>" +
                    "</div>" +

                    "<div class='col-2'>" +
                    "<a href='" + routeedit + "' class='btn btn-warning btn-sm' title='Edit Polylines'>" +
                    "<i class='fa-solid fa-pen-to-square'></i>" +
                    "</a>" +
                    "</div>" +

                    "</div>";

                layer.on({
                    click: function(e) {
                        polylines.bindPopup(popup_content);
                    },
                });
            },

        });

        var polygons = L.geoJSON(null, {
            // Style

            // onEachFeature
            onEachFeature: function(feature, layer) {
                //Route delete polygons
                var routedelete = "{{ route('polygons.delete', ':id') }}";
                routedelete = routedelete.replace(':id', feature.properties.id);

                var routeedit = "{{ route('polygon.edit', ':id') }}";
                routeedit = routeedit.replace(':id', feature.properties.id);

                // variable popup content
                var popup_content = "Nama: " + feature.properties.nama + "<br>" +
                    "Description: " + feature.properties.description + "<br>" +
                    "Dibuat: " + feature.properties.created_at + "<br>" +
                    "<img src='{{ asset('storage/images') }}/" + feature.
                properties.image + "' alt='Image Polygons' class='img-thumbnail' width='600'>" +
                    "<br><br>" + "<div class='row'>" +
                    "<div class='col-2'>" +
                    "<form action='" + routedelete + "' method='post'>" +
                    '@csrf' +
                    '@method('delete')' +
                    "<button type='submit' class='btn btn-sm btn-danger' title='Delete feature' onclick='return confirm(`Are you sure want to delete this feature?`)'>" +
                    "<i class='fa-solid fa-trash'></i>" +
                    "</button>" +
                    "</form>" +
                    "</div>" +

                    "<div class='col-2'>" +
                    "<a href='" + routeedit + "' class='btn btn-warning btn-sm' title='Edit Points'>" +
                    "<i class='fa-solid fa-pen-to-square'></i>" +
                    "</a>" +
                    "</div>" +

                    "</div>";

                layer.on({
                    click: function(e) {
                        polygons.bindPopup(popup_content);
                    },
                });
            },

        });

        $.getJSON("{{ route('geojson_points') }}", function(data) {
            points.addData(data);
            map.addLayer(points);
        });

        $.getJSON("{{ route('geojson_polylines') }}", function(data) {
            polylines.addData(data);
            map.addLayer(polylines);
        });

        $.getJSON("{{ route('geojson_polygons') }}", function(data) {
            polygons.addData(data);
            map.addLayer(polygons);
        });

        // Control Layer
        var baseMaps = {};

        var overlayMaps = {
            "Points": points,
            "Polylines": polylines,
            "Polygons": polygons,
        };

        var controllayer = L.control.layers(baseMaps, overlayMaps);
        controllayer.addTo(map);
    </script>
@endsection
