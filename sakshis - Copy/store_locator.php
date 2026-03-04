<!DOCTYPE html>
<html>
<head>
    <title>Store Locator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        #map { height: 500px; width: 100%; margin-top: 10px; }
        #search-box { padding: 8px; width: 300px; }
    </style>
</head>
<body>
    <h2>Find a Store</h2>
    <input type="text" id="search-box" placeholder="Enter city or store name">

    <div id="map"></div>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
    <script>
        let map;
        let markers = [];

        // Initialize map
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 19.0760, lng: 72.8777 }, // Default center (Mumbai)
                zoom: 5
            });
            loadStores(); // Load all stores initially
        }

        // Clear all markers from map
        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }

        // Load stores dynamically
        async function loadStores() {
            const search = document.getElementById('search-box').value;
            try {
                const response = await fetch('get_stores.php?search=' + encodeURIComponent(search));
                const data = await response.json();

                clearMarkers();

                if(data.length === 0){
                    map.setCenter({ lat: 19.0760, lng: 72.8777 });
                    map.setZoom(5);
                    return;
                }

                data.forEach(store => {
                    const marker = new google.maps.Marker({
                        position: { lat: parseFloat(store.lat), lng: parseFloat(store.lng) },
                        map: map,
                        title: store.name
                    });
                    const infoWindow = new google.maps.InfoWindow({
                        content: `<b>${store.name}</b><br>${store.address}<br>${store.city}, ${store.state} ${store.zip}`
                    });
                    marker.addListener('click', () => infoWindow.open(map, marker));
                    markers.push(marker);
                });

                // Center map to first store
                map.setCenter({ lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lng) });
                map.setZoom(10);

            } catch (err) {
                console.error(err);
            }
        }

        // Search as user types
        document.getElementById('search-box').addEventListener('input', loadStores);

        window.onload = initMap;
    </script>
</body>
</html>
