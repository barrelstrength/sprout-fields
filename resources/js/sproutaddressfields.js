jQuery(document).ready(function($) {

	jQuery('select.sproutAddressCountry').change(function() {

		var countryCode = $(this).val();
		var sproutAddressNamespaceInputName = $(this).data('namespace');
		var sproutAddress = $(this).data('address');

		var sproutAddresBox = $(this).parents('.sproutaddressfield-box').children('.format-box');
		$.post("actions/sproutFields/sproutAddress",
			{ sproutAddressNamespaceInputName: sproutAddressNamespaceInputName, sproutAddress: sproutAddress, countryCode: countryCode },
			function(data) {
				sproutAddresBox.html(data);
			});
	})
});

