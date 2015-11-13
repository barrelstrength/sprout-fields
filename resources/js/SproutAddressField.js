(function ($) {
	Craft.SproutAddressField = Garnish.Base.extend(
		{
			init: function(sproutAddress)
			{
				$('select.sproutAddressCountry').change(function() {

					var countryCode = $(this).val();
					var sproutAddressNamespaceInputName = $(this).data('namespace');
					var sproutAddress = $(this).data('address');

					var sproutAddresBox = $(this).parents('.sproutaddressfield-box').children('.format-box');
					Craft.postActionRequest("sproutFields/sproutAddress",
						{ sproutAddressNamespaceInputName: sproutAddressNamespaceInputName, sproutAddress: sproutAddress, countryCode: countryCode },
						function(data) {
							sproutAddresBox.html(data);
						});
				})
			}
		})

})(jQuery);
