<?php
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
?>
<div class="row">
	<div class="col-sm-12 pl-5 pr-5 pt-4 col-md-4 bg-light">
		<h3>Donator's form</h3>
		<small><a href="#" id="donate-link">Mark location to continue</a></small>
		<p class="message">Please adjust the marker to point the donator's location. By default the marker is at your current location. And fill the below form</p>
		<form class="mt-4" id="my-form" method="POST">
			<fieldset class="row" disabled>
				<div class="form-group col-12">
					<label>Name</label>
					<input type="text" name="name" class="form-control" id="name" required>
				</div>
				<div class="form-group col-6">
					<label>Email</label>
					<input type="email" name="email" class="form-control" id="email" required>
				</div>
				<div class="form-group col-6">
					<label>Mobile</label>
					<input type="text" name="mobile" class="form-control" id="mobile" required>
				</div>
		        <div class="form-group col-12">
		        	<textarea name="description" placeholder="Please give information about the food, like what do you have, in what amount etc." class="form-control"></textarea>
		        </div>
		        <input type="hidden" name="lat" id="hidden-lat">
		        <input type="hidden" name="long" id="hidden-long">
		        <div class="form-group col-12">
		        	<label>City</label>
			        <input type="text" name="city" class="form-control" id="hidden-city" required>
			    </div>
		        <div class="col-12 text-center">
		        	<input type="submit" name="submit" class="btn btn-warning" id="submit-btn" value="Mark this place for food availability"/>
		        </div>
			</fieldset>
		</form>
		<p class="text-center mt-5">Please download <a target="_blank" href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwi-7ML_jNbpAhXQeisKHSlmAOIQFjAAegQIAhAB&url=https%3A%2F%2Fplay.google.com%2Fstore%2Fapps%2Fdetails%3Fid%3Dnic.goi.aarogyasetu%26hl%3Den_IN&usg=AOvVaw0n2dF0gb2Rq5e5YvItOq7e">Arogya Setu</a> app</p>
	</div>
	<div class="col-sm-12 m-0 p-4 col-md-8" style="height: 86vh;">
		<div class="mapContainer" id="mapContainer"></div>
	</div>
</div>
<?php
	include("includes/bottom-scripts.php");
	include("includes/footer.php");
?>
	<script>
		var platform = new H.service.Platform({'apikey':'Q8YJrd6nSQYp_S8WNXt0r1EzGWvTv4KkssNS5eEooow'});
		var defaultLayers = platform.createDefaultLayers();

		var map = new  H.Map(
			document.getElementById('mapContainer'),
			defaultLayers.vector.normal.map,
			{
				zoom: 10,
				center: {lat: 26.8467, lng: 80.9462 }
			}
		)
		var ui = H.ui.UI.createDefault(map, defaultLayers);
		// Enable the event system on the map instance:
		var mapEvents = new H.mapevents.MapEvents(map);

		// Add event listeners:
		map.addEventListener('tap', function(evt) {
		    // Log 'tap' and 'mouse' events:
		    console.log(evt);
		});

		// Instantiate the default behavior, providing the mapEvents object:
		var behavior = new H.mapevents.Behavior(mapEvents);
		group = new H.map.Group();

		// add a resize listener to make sure that the map occupies the whole container
		window.addEventListener('resize', () => map.getViewPort().resize());
		var final_lat, final_long, city;
		// functionality for donatation
		$('#donate-link').click(()=>{
			// Create an icon, an object holding the latitude and longitude, and a marker:
			var lat, long;
			navigator.geolocation.getCurrentPosition((e)=>{
				lat = e.coords.latitude
				long = e.coords.longitude
				var coords = {lat: lat, lng: long },
				// now create a draggable marker
				marker = new H.map.Marker(coords, {volatility: true});
				marker.draggable = true;
				map.addObject(marker);
		  		document.getElementById('hidden-long').value = long;
		  		document.getElementById('hidden-lat').value = lat;
				$('.message').fadeIn();
				$('#donate-link').hide();
				$('fieldset').prop("disabled", false);
				map.setCenter(coords);
				map.addEventListener('dragstart', function(ev) {
					var target = ev.target,
					pointer = ev.currentPointer;
					if (target instanceof H.map.Marker) {
						var targetPosition = map.geoToScreen(target.getGeometry());
						target['offset'] = new H.math.Point(pointer.viewportX - targetPosition.x, pointer.viewportY - targetPosition.y);
						behavior.disable();
					}
				}, false);
				// re-enable the default draggability of the underlying map
			  	// when dragging has completed
			  	map.addEventListener('dragend', function(ev) {
				  	var target = ev.target;
				  	if (target instanceof H.map.Marker) {
				  		behavior.enable();
				  		$('.form-control[name="name"]').focus();
				  		final_lat = marker.b.lat;
				  		final_long = marker.b.lng;
				  		// console.log(final_lat + ", "+final_long)
				  		document.getElementById('hidden-long').value = final_long;
				  		document.getElementById('hidden-lat').value = final_lat;
				  		$.ajax({
						  url: 'https://reverse.geocoder.ls.hereapi.com/6.2/reversegeocode.json',
						  type: 'GET',
						  dataType: 'jsonp',
						  jsonp: 'jsoncallback',
						  data: {
						    prox: final_lat+','+final_long,
						    mode: 'retrieveAddresses',
						    maxresults: '1',
						    gen: '9',
						    apiKey: 'Q8YJrd6nSQYp_S8WNXt0r1EzGWvTv4KkssNS5eEooow'
						  },
						  success: function (data) {
						    document.getElementById('hidden-city').value = data.Response.View[0].Result[0].Location.Address.City;
						    // console.log(document.getElementById('hidden-city').value)
						  },
						  fail: function(data){
						  	document.getElementById('hidden-city').value = 'undefined';
						  }
						});
				  	}
				  }, false);

			  	// Listen to the drag event and move the position of the marker
				// as necessary
				map.addEventListener('drag', function(ev) {
				  	var target = ev.target,
				  	pointer = ev.currentPointer;
				  	if (target instanceof H.map.Marker) {
				  		target.setGeometry(map.screenToGeo(pointer.viewportX - target['offset'].x, pointer.viewportY - target['offset'].y));
				  	}
				  }, false);
			})
		})
		$('#submit-btn').click(function(e){
			e.preventDefault();
			if($('#name').val() == '')
			{
				alert("please enter name");
				$('.form-control[name="name"]').focus();
				return false;
			}
			else if($('#email').val() == '')
			{
				alert("please enter your email");
				$('.form-control[name="email"]').focus();
				return false;
			}
			else if($('#mobile').val() == '')
			{
				alert("please enter your mobile number");
				$('.form-control[name="mobile"]').focus();
				return false;
			}
			else if($('#hidden-city').val() == "")
			{
				alert("please enter city");
				$('.form-control[name="city"]').focus();
				return false;
			}
			var form_data = $('#my-form').serialize();
			$.ajax({
				url: "//dronate.000webhostapp.com/API/insert_donator.php",
				data : form_data,
				type : "POST",
				success: function(data){
					alert(data);
					$('#my-form').trigger('reset');
					window.location.reload();
				}
			})
		})

	</script>
