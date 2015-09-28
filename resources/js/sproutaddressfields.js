jQuery(document).ready(function($) {
	jQuery('select.sproutAddressCountry').change(function() {

		var countryCode = $(this).val();

		$.post('/' + cpTrigger + "/sproutaddressfield/form",
			{ sproutAddressName: sproutAddressName, sproutAddress: sproutAddress, countryCode: countryCode },
			function(data) {
			$(".sproutaddressfield-box .format-box").html(data);
		});
	})
});

