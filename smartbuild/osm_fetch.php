<?php
set_time_limit(60);

if(isset($_POST['product'], $_POST['area'])){
    $product = urlencode($_POST['product']); 
    $area = urlencode($_POST['area']);

    // Step 1: Nominatim API (Get lat/lon)
    $nominatim_url = "https://nominatim.openstreetmap.org/search?q=$area&format=json&limit=1";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $nominatim_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "HomeBuilderProductPredictor/1.0"); // Required
    $json = curl_exec($ch);
    if(curl_errno($ch)){
        echo "Error fetching location data: " . curl_error($ch);
        exit;
    }
    curl_close($ch);

    $locData = json_decode($json, true);
    if(empty($locData)){
        echo "Invalid area / city.";
        exit;
    }

    $lat = $locData[0]['lat'];
    $lon = $locData[0]['lon'];
    $radius = 10000; // 10 km

    // Step 2: Overpass API
    $overpass_url = "https://overpass-api.de/api/interpreter?data=[out:json];node[shop=$product](around:$radius,$lat,$lon);out;";

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $overpass_url);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_USERAGENT, "HomeBuilderProductPredictor/1.0");
    $response = curl_exec($ch2);
    if(curl_errno($ch2)){
        echo "Error fetching stores: " . curl_error($ch2);
        exit;
    }
    curl_close($ch2);

    $data = json_decode($response, true);

    if(!empty($data['elements'])){
        echo "<table>";
        echo "<tr><th>Store Name</th><th>Street</th><th>City</th><th>Country</th></tr>";
        foreach($data['elements'] as $element){
            $name = $element['tags']['name'] ?? 'Unnamed Store';
            $street = $element['tags']['addr:street'] ?? '-';
            $city = $element['tags']['addr:city'] ?? '-';
            $country = $element['tags']['addr:country'] ?? '-';
            echo "<tr>
                    <td>$name</td>
                    <td>$street</td>
                    <td>$city</td>
                    <td>$country</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No stores found in this area for selected product.";
    }
} else {
    echo "Invalid request.";
}
?>
