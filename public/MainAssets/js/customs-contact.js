jQuery(function($) {

	"use strict";
		
	var mapStyles = [{"featureType":"all","elementType":"geometry","stylers":[{"color":"#eeeee7"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#4b4b4b"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"color":"#f5f1e6"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#c9b2a6"}]},{"featureType":"administrative.land_parcel","elementType":"geometry.stroke","stylers":[{"color":"#dcd2be"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#e3e3d7"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#e3e3d7"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#e3e3d7"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#93817c"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#527042"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#447530"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#f5f1e6"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#fac613"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#e9bc62"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#ff9900"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry.stroke","stylers":[{"color":"#db8555"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#fdfcf8"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#806b63"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e3e3d7"}]},{"featureType":"transit.line","elementType":"labels.text.fill","stylers":[{"color":"#8f7d77"}]},{"featureType":"transit.line","elementType":"labels.text.stroke","stylers":[{"color":"#eeeee7"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#e3e3d7"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#1e6aaa"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#1e6aaa"}]}];

	var contactMap, contactMapMarker;
	
	function init() {
	
		var mapCenter = new google.maps.LatLng(13.7563, 100.5018);

		contactMap = new google.maps.Map(document.getElementById('contact_map'), {
			zoom: 15,
			center: mapCenter,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			styles: mapStyles,
			scrollwheel: false,
			panControl: false,
			draggable: true,
		});
		

		var div = document.createElement('DIV');
		div.innerHTML = '<div class="contact-map-marker"><i class="ion-location"></i></div>';

		contactMapMarker = new RichMarker({
			map: contactMap,
			position: mapCenter,
			draggable: false,
			flat: true,
			anchor: RichMarkerPosition.MIDDLE,
			content: div
		});
		
	}

	// Register an event listener to fire when the page finishes loading.
	google.maps.event.addDomListener(window, 'load', init);
	
});
