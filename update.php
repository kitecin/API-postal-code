<?php
// $code is code zip submitted by user
if ($_POST){
	if (!preg_match("/^\d{3}\-\d{4}$/", $code)) {
		echo "Zip code must be as the following pattern: 3 digits - 4 digits.";
		return;
	}
	
	// FIRST: get Location
	$location= http_request ("http://api.zippopotam.us/JP/" . $code);

	if (!property_exists($location, "places")) {
			echo "Zip code entered is not correct.";
			return;	
	}		
	
	// SECOND get forecast
	$apiKey = "5df5146eb118459e82e7f85651001cb6";	
	$ApiUrl = "https://api.weatherbit.io/v2.0/forecast/daily?&postal_code=" . $code . "&country=JP&days=3&key=" . $apiKey;
	$data= http_request ($ApiUrl);		
	$currentTime = time();

	//THIRD get map
	$mapData= http_request("https://api.opencagedata.com/geocode/v1/json?q=" . $code . "&key=c9d72a90dfe0474fb75844e57da340df");
	$lat = $mapData->results[0]->geometry->lat;
	$lng = $mapData->results[0]->geometry->lng;
	
?>
		<div class="place">
			<h1><?php echo $location->places[0]->state ." ". $location->places[0]->{"place name"}; ?>				
		</div>
		<div class="report-container">
			<h3>3-day forecast</h3>
			<div id="forecasts">
				<?php foreach ($data->data as $item){ ?>
				<div style="display: inline-block; padding: 15; border: 1px solid black; margin-right: 15px;">
					<img src="https://www.weatherbit.io/static/img/icons/<?php echo $item->weather->icon; ?>.png" class="weather-icon" />
					<br/>
					<?php $dayofweek = date('D', strtotime($item->valid_date)); 						
					echo $item->valid_date ." ".$dayofweek;?>
					<br/>
					<h3><?php echo $item->weather->description; ?></h3>
					<br/>
					Max: <?php echo $item->app_max_temp; ?>ยบC <span class"min-temp"><?php echo $item->app_min_temp; ?>ยบC</span>
				</div>
				<?php } ?>
		</div>
		<input type="hidden" value="<?php echo $lat;?>" id="lat">
		<input type="hidden" value="<?php echo $lng;?>" id="lng">
		
		<div id="maps" >
			<div id="map1" class="maping">
				<h1> Map </h1>
				<div id="mapid" class="map">
			
				</div>
			</div>
			<div id="map2" class="maping">
				<h1> Antipodes </h1>
				<div id="mapidreverse" class="map">
				
				</div>
			</div>
		</div>
		<!-- map creation -->
		<script>
					var lat = document.getElementById("lat").value;
					var lng = document.getElementById("lng").value;
					var mymap = L.map('mapid').setView([lat, lng], 14);

					L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoia2l0ZWNpbiIsImEiOiJjanpsZHBvMzIwOTZsM2RvMmF2OTczdTJ1In0.k0sx0q7xhryP5d701iMgkg', {
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery ฉ <a href="https://www.mapbox.com/">Mapbox</a>',
						id: 'mapbox.streets',
					}).addTo(mymap);
					
					var circle = L.circle([lat, lng], {
						color: 'red',
						fillColor: '#f03',
						fillOpacity: 0.5,
						radius: 300
					}).addTo(mymap);
					
					var aLng = 0;
					
					if (lng > 0) {
						aLng = lng - 180;
					} else {
						aLng = lng + 180;
					}
					
					
					var mymaprev = L.map('mapidreverse').setView([-lat, aLng], 14);
					
					L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoia2l0ZWNpbiIsImEiOiJjanpsZHBvMzIwOTZsM2RvMmF2OTczdTJ1In0.k0sx0q7xhryP5d701iMgkg', {
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery ฉ <a href="https://www.mapbox.com/">Mapbox</a>',
						id: 'mapbox.streets',
					}).addTo(mymaprev);
					
					var circle = L.circle([-lat, aLng], {
						color: 'blue',
						fillColor: 'blue',
						fillOpacity: 0.5,
						radius: 300
					}).addTo(mymaprev);

		</script>
<?php } ?>