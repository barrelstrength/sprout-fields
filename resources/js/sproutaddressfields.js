jQuery(document).ready(function($) {

	jQuery('select.sproutAddressCountry').change(function() {
		alert('sadf');
		var countryCode = $(this).val();

		var sproutAddresBox = $(this).parents('.sproutaddressfield-box').children('.format-box');
		Craft.postActionRequest("sproutFields/sproutAddress",
			{ sproutAddressName: sproutAddressName, sproutAddress: sproutAddress, countryCode: countryCode },
			function(data) {
				sproutAddresBox.html(data);
		});
	})
});

