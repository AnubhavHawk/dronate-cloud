<?php
header("Access-Control-Allow-Origin: *");
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
?>
<?php
	if(isset($_REQUEST['s']))
	{
		if($_REQUEST['s'] == 's')
		{
			?>
			<script>
				window.alert("We have noted your marked location. Someone will reach out to there shortly");
			</script>
			<?php
		}
		else
		{
			?>
			<script>
				window.alert("Failed to add location, please try again");
			</script>
			<?php
		}
	}
?>
<div class="row">
	<div class="col-sm-12 col-md-4 bg-light pl-3 pr-3 text-center pt-3 pb-2">
		<h6 title="Pick food from green marker and provide it to red markers" data-toggle="tooltip" ><b>Help sharing food in cities</b></h6>
		<div id="city-container">
			
		</div>
		<hr/>
		<b>Can't find your city?</b>
		<div>
			<small>Donate in your city: <a href="<?=baseurl()?>/donate.php">Click here</a></small>
		</div>
		<div>
			<small>Request in your city: <a href="<?=baseurl()?>/request.php">Click here</a></small>
		</div>
		<p class="p-5 m-4 message bg-white shadow-sm rounded">
			<b class="text-warning">Note</b><br>
			If you have received food from a location or have delivered it to some location, then please click that marker and click <i class="text-success">remove</i> so that other people don't reach there again.
		</p>
		<p class="text-center mt-5">Please download <a target="_blank" href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwi-7ML_jNbpAhXQeisKHSlmAOIQFjAAegQIAhAB&url=https%3A%2F%2Fplay.google.com%2Fstore%2Fapps%2Fdetails%3Fid%3Dnic.goi.aarogyasetu%26hl%3Den_IN&usg=AOvVaw0n2dF0gb2Rq5e5YvItOq7e">Arogya Setu</a> app</p>
	</div>
	<div class="col-sm-12 container-fluid m-0 p-4 col-md-8" style="height: 86vh;">
		<div class="mapContainer" id="mapContainer"></div>
	</div>
</div>
<?php
	include("includes/bottom-scripts.php");
	include("includes/footer.php");
?>
	<script>
		$.ajax({
		    type: 'GET',
		    url: "//dronate.000webhostapp.com/API/fetch_city.php",
		    success:function (data) {
		    	$('#city-container').html(data);
		    }
		});
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

		// Instantiate the default behavior, providing the mapEvents object:
		var behavior = new H.mapevents.Behavior(mapEvents);
		// group = new H.map.Group();

		function addMarkerToGroup(group, coords, html, color) {
			  var icon = new H.map.Icon('<?=baseurl()?>/assets/img/'+color+'-marker.png');
				marker = new H.map.Marker(coords, {icon:icon});
			  // add custom data to the marker
			  marker.setData(html);
			  group.addObject(marker);
			}
			function addInfoBubble(map, coords, color, description) {
			  var group = new H.map.Group();
			  map.addObject(group);
			  group.addEventListener('tap', function (evt) {
			    var bubble =  new H.ui.InfoBubble(evt.target.getGeometry(), {
			      // read custom data
			      content: evt.target.getData()
			    });
			    // show info bubble
			    ui.addBubble(bubble);
			  }, false);
			  addMarkerToGroup(group, coords, description, color);
			}


		function add_markers(coords, color, description)
		{
			var icon = new H.map.Icon('<?=baseurl()?>/assets/img/'+color+'-marker.png');
			addInfoBubble(map, coords, color, description);
			map.setCenter(coords);
		}
		window.addEventListener('resize', () => map.getViewPort().resize());
		$('#city-container').on("click",'.city-link',function(){
			var city = $(this).text();
			$('.message').fadeIn(1000)
			if(window.city_name == city)
			{
				alert("The results are already displaying for this city");
				return;
			}
			window.city_name = city;
			var donate_url = "//dronate.000webhostapp.com/API/fetch_donator.php"
			var request_url = "//dronate.000webhostapp.com/API/fetch_requestor.php"

			// AJAX call for finding donators
			$.ajax({
			    type: 'POST',
			    dataType: 'json',
			    url: donate_url,
			    data:{city:city},
			    success:  function (data) {
			      for(i = 0; i < data.length; i++)
			      {
			      	var description = "<b>"+data[i].user_name+"</b> ("+data[i].user_email+")<br><u>Mobile:</u> "+data[i].user_mobile+"<br><u>Additional Info:</u>"+data[i].description+'<br/><a href="#" class="text-success remove-link" onclick="work('+data[i].info_id+', \'donate\')">Remove</a>';
			      	add_markers({lat:data[i].latitude, lng: data[i].longitutde}, 'green', description);
			      }
			    },
			    fail: function(data)
			    {
			    	alert("Failed to laod information for the city");
			    }
			});
			// AJAX call for requesters
			$.ajax({
			    type: 'POST',
			    dataType: 'json',
			    url: request_url,
			    data:{city:city},
			    success:  function (data) {
			      for(i = 0; i < data.length; i++)
			      {
			      	var description = data[i].description+'<br/><a href="#" onclick="work('+data[i].request_id+', \'request\')" class="text-success remove-link">Remove</a>';
			      	add_markers({lat:data[i].latitude, lng: data[i].longitutde}, 'red', description);
			      }
			    },
			    fail: function(data)
			    {
			    	alert("Failed to load information for the city");
			    }
			});
		})
		function work(id, type)
		{
			var flag = false;
			if(type == "donate")
			{
				if(confirm("Are you sure that the food has been collected from there?"))
				{
					flag = true;
				}
			}
			else
			{
				if(confirm("Are you sure that food has been delivered there?"))
				{
					flag = true;
				}
			}
			if(flag)
			{
				$.ajax({
				    type: 'POST',
				    // dataType: 'jsonp',
				    url: "//dronate.000webhostapp.com/API/delete.php",
				    data:{id:id, type:type},
				    success:function (data) {
				    	window.alert(data);
				    	window.location.reload();
				    }
				});
			}
		}
	</script>
