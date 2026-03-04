<!DOCTYPE html>
<html>
<head>
    <title>Home Builder Product Predictor (OSM)</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table { width:100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border:1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        #loading { font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
<h2>Home Builder Product Predictor</h2>

<label>Product Type:</label>
<select id="product">
    <option value="">--Select--</option>
    <option value="hardware">Hardware / Tiles / Tools</option>
    <option value="doityourself">Paint / DIY</option>
    <option value="furniture">Furniture</option>
</select>

<label>Area / City:</label>
<input type="text" id="area" placeholder="Enter area or city">

<button id="search">Search</button>

<div id="loading" style="display:none;">Loading stores...</div>
<div id="results"></div>

<script>
$(document).ready(function(){
    $('#search').click(function(){
        var product = $('#product').val();
        var area = $('#area').val();

        if(product && area){
            $('#results').html('');
            $('#loading').show();

            $.ajax({
                url: 'osm_area_fetch.php',
                type: 'POST',
                data: {product: product, area: area},
                success: function(data){
                    $('#loading').hide();
                    $('#results').html(data);
                },
                error: function(){
                    $('#loading').hide();
                    $('#results').html('Error fetching stores. Try again later.');
                }
            });
        } else {
            alert("Please select product and enter area/city.");
        }
    });
});
</script>
</body>
</html>
