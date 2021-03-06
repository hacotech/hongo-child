  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <!--Leaflet 1.0.3-->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/assets/css/leaflet.css" />
  <script src="<?php echo get_template_directory_uri() ?>/assets/js/leaflet.js"></script>
  <!--Leaflet Plugins-->
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/assets/css/L.VisualClick.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/assets/css/stores.css" />
  <script src="<?php echo get_template_directory_uri() ?>/assets/js/L.VisualClick.js"></script>
  <script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.2.0/leaflet-omnivore.min.js'></script>
  <script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-hash/v0.2.1/leaflet-hash.js'></script>
<!--   <script src='https://npmcdn.com/@turf/turf/turf.min.js'></script> -->
<?php get_header() ?>

<div id="app">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php the_content() ?>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
    	<div class="col-md-5">
			<div class='sidebar'>
			<div id="searchbox" style="display:none;">
				<input type="text" id="search-input" autofocus/>
			</div>
			  <div class=''>	  
				<span id="searchIcon"><i class="fa fa-search"></i></span>
			  </div>
			  <div id="storeinfo"><i id="infoClose" class="fa fa-times"></i>
				<div id="infoDivInner"></div>
			  </div>
			  <div id='listingDiv' class='listings'></div>
			</div>	
		</div>
		<div class="col-md-7">
			<div class="map-wrapper">
				<div id='map' class='map'></div>
			</div>	
		</div>
		</div>
	</div>
</div>
<br><br><br>
<script>



	//basic map setup map and basemap
	//     var map = L.map('map')
	//       .setView([32.92209882293009, 53.99010666323974], 6);

	var map = L.map('map', {
		center: [33.46961599448429, 53.07513083970446],
		zoom: 60
	});

	//L.hash(map);
	var blackandwhite = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {

	}).addTo(map);

	// 	var googlemap = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {

	//     	subdomains:['mt0','mt1','mt2','mt3']
	//     }).addTo(map);  

	var openstreetmap = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

	}).addTo(map);

	//     var googleStreets = L.gridLayer.googleMutant({
	//       type: 'roadmap' // valid values are 'roadmap', 'satellite', 'terrain' and 'hybrid'
	//     }).addTo(map);

	//layer control
	var baselayers = {

		//"Google Street" : googleStreets,
		"????????"			: openstreetmap,
		"???????? ?? ????????"	 : blackandwhite,
		// 		"???????? ????"			: googlemap,
		
	};

	var layerControl = new L.control.layers(baselayers, null).addTo(map);

	//end basic map

	//show search on search icon click
	//global variables - could add more here
	var locationLat = [];
	var locationLng = [];
	var locMarker;
	var infoDiv = document.getElementById('storeinfo');
	var infoDivInner = document.getElementById('infoDivInner');
	var toggleSearch = document.getElementById('searchIcon');
	var hasCircle = 0;
	var circle = [];
	//close store infor when x is clicked
	var userLocation;
	$("#infoClose").click(function() {
		$("#storeinfo").hide();
		if (map.hasLayer(circle)) {
			map.removeLayer(circle);
		}
	});
	var listings = document.getElementById('listingDiv');
	var stores = L.geoJson().addTo(map);
	var storesData = omnivore.csv('<?php echo get_template_directory_uri() ?>/assets/data/stores.csv');

	function setActive(el) {
		var siblings = listings.getElementsByTagName('div');
		for (var i = 0; i < siblings.length; i++) {
			siblings[i].className = siblings[i].className
				.replace(/active/, '').replace(/\s\s*$/, '');
		}
		el.className += ' active';
	}

	function sortGeojson(a,b,prop) {
		return (a.properties.name.toUpperCase() < b.properties.name.toUpperCase()) ? -1 : ((a.properties.name.toUpperCase() > b.properties.name.toUpperCase()) ? 1 : 0);
	}

	storesData.on('ready', function() {

		var storesSorted = storesData.toGeoJSON();
		//console.log(storesSorted);
		var sorted = (storesSorted.features).sort(sortGeojson)
		//console.log(sorted);
		storesSorted.features = sorted;
		//console.log(storesSorted)
		stores.addData(storesSorted);

		map.fitBounds(stores.getBounds());
		toggleSearch.onclick = function() {
			var s = document.getElementById('searchbox');
			if (s.style.display != 'none') {
				s.style.display = 'none';
				toggleSearch.innerHTML = '<i class="ti-search"></i>';
				$("#search-input").val("");

				//search.collapse();
				document.getElementById('storeinfo').style.display = 'none';
				$('.item').show();
			} else {
				toggleSearch.innerHTML = '<i class="fa fa-times"></i>';
				s.style.display = 'block';

				//attempt to autofocus search input field when opened
				$('#search-input').focus();
			}
		};
		stores.eachLayer(function(layer) {

			//New jquery search
			$('#searchbox').on('change paste keyup', function() {
				var txt = $('#search-input').val();
				$('.item').each(function() {
					if ($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			});

			// Shorten layer.feature.properties to just `prop` so we're not
			// writing this long form over and over again.
			var prop = layer.feature.properties;
			var layerx = layer.getLatLng().lat;
			var layery = layer.getLatLng().lng;

			////console.log(locationLat);
			// Each marker on the map.
			var popup = '<h2>' + prop.name + '</h2>' + 
				'<ul><li>????????:' + prop.address + '</li><hr /></ul>' +
				'<p id="directions"><i class="ti-location-pin"></i><a href="https://www.google.com/maps/dir//?saddr=My+Location' + '&daddr=' + layerx + ',' + layery + '" target="_blank">??????????????</a></p>';
			var listing = listings.appendChild(document.createElement('div'));
			listing.className = 'item';
			var link = listing.appendChild(document.createElement('a'));
			link.href = '#';
			link.className = 'title';
			link.innerHTML = prop.name;
			if (prop.products) {
				link.innerHTML += '<br /><small class="quiet">' + prop.products + '</small>';
			}
			var details = listing.appendChild(document.createElement('div'));
			details.innerHTML = prop.address;
			var linkClick = 0;
			link.onclick = function() {
				linkClick = 1;
				setActive(listing);

				//console.log(locationLat);
				// When a menu item is clicked, animate the map to center
				// its associated layer and open its popup.
				map.setView(layer.getLatLng(), 18);
				layer.fire('click');
				infoDiv.style.display = 'block';

				//layer.openPopup();
				//		    sidebar.setContent(popup);
				//		    sidebar.show();
				return false;
			};
			// Marker interaction
			layer.on('click', function(e) {
				if (map.hasLayer(userLocation)) {
					map.removeLayer(userLocation)
				}
				//console.log(e.latlng);
				if (linkClick != 1) {
					map.setView([e.latlng.lat, e.latlng.lng], 12);
				}
				linkClick = 0;
				$(".item").show();
				$("#searchbox").hide();
				toggleSearch.innerHTML = '<i class="fa fa-search"></i>';
				if (map.hasLayer(circle)) {
					map.removeLayer(circle);
					hasCircle = 0;
				}
				// 1. center the map on the selected marker.
				//map.setView(layer.getLatLng(), map.getZoom());
				// use this forr polygons and lines - map.panTo(layer.getBounds().getCenter());
				// 2. Set active the markers associated listing.
				setActive(listing);
				// sidebar.setContent(popup);
				infoDiv.style.display = "block";
				infoDivInner.innerHTML = '<div class="row"><img class="col-md-6" src="' + prop.photo + '" style="float: left;"><div class="col-md-6"><h2>' + prop.name + '</h2>' + 
					'<ul><li>???????? ????????: ' + prop.phone + ' - 0' + prop.code + '</li>' +
					'<li>??????: ' + prop.fax + ' - 0' + prop.code + '</li>' +
					'<li>?????????? ????????: ' + prop.index + '</li></ul></div>';
				// sidebar.show();
				xy = layer.getLatLng();
				setTimeout(function() {
					circle = new L.circleMarker(xy, {
						color: 'transparent',
						fillColor: 'transparent',
						fillOpacity: 0,
						radius: 50,
					}).addTo(map);
				}, 200);
			});
			popup += '</div>';
			layer.bindPopup(popup);
			layer.setIcon(L.icon({
				iconUrl: '<?php echo get_template_directory_uri() ?>/assets/marker.png',
				iconSize: ['auto', 'auto'],
				iconAnchor: [40, 50],
				popupAnchor: [-30, -47]
			}));
		}); //end eachLayer

		map.locate({
			setView: true,
			maxZoom: 6
		});

		map.on('locationfound', function(e) {
			console.log(e);
			//8046.72 meters = 5 miles
			var radius = 80000;
			//       var rmiles = (radius/1609.34).toFixed(0); 
			var range = 10;
			userLocation = new L.Circle(e.latlng, radius, {
				color: 'cadetblue',
				fillColor: 'cadetblue',
				fillOpacity: 0,
				radius: 30
			});
			var point = turf.point([e.longitude,e.latitude]);

			var storesWithin = storesSorted.features.map(function(store) {
				var newpoint = turf.feature(store.geometry);
				console.log(turf.distance(newpoint, point, {units: 'miles'}));
				if (turf.distance(newpoint, point, {units: 'miles'}) <= range) {
					return store
				}
			});
			console.log(storesWithin);

			//       var within = turf.featureCollection(stores.eachLayer(function(store) {
			//         console.log(store);
			//         var newpoint = turf.feature(store.feature.geometry);
			//         console.log(turf.distance(newpoint, point, {units: 'miles'}));
			//         if (turf.distance(newpoint, point, {units: 'miles'}) <= range) return true;
			//       }));
			//       console.log(within);
			//       var size = Object.keys(within.features._layers).length;
			//       console.log(size);
			var nearest = turf.nearest(point, stores.toGeoJSON());
			console.log(nearest);
			if (nearest.properties.name) {
				$("#infoDivInner").html("Location found!<br>Your nearest store is " + "<strong>" + nearest.properties.name + "</strong>");
				circle = new L.circleMarker([nearest.geometry.coordinates[1],nearest.geometry.coordinates[0]], {
					color: 'red',
					fillColor: '#f03',
					fillOpacity: 0,
					radius: 50,
				}).addTo(map);
				console.log(circle);
				hasCircle = 1;
			}
			$("#storeinfo").show();
		})
	}); //end on ready function
	//setTimeout(function() {        

	//sidebar.hide();
	//}, 500);
	map.on('click', function() {
		if (map.hasLayer(userLocation)) {
			map.removeLayer(userLocation)
		}
		if (map.hasLayer(circle)) {
			////console.log('circle');
			map.removeLayer(circle);
			hasCircle = 0;
		}
	});
</script>
<?php get_footer(); ?>