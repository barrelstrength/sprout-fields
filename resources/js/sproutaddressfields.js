jQuery(document).ready(function($) {

	jQuery('select.sproutAddressCountry').change(function() {

		var countryCode = $(this).val();

		var sproutAddresBox = $(this).parents('.sproutaddressfield-box').children('.format-box');
		$.post('/' + cpTrigger + '/sproutaddressfield/form',
			{ sproutAddressName: sproutAddressName, sproutAddress: sproutAddress, countryCode: countryCode, sproutAddressNamespaceInputName: sproutAddressNamespaceInputName },
			function(data) {
				sproutAddresBox.html(data);
		});
	})
});

