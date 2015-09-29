(function ($) {
	Craft.SproutAddressField = Garnish.Base.extend(
		{
			init: function(sproutAddress, sproutAddressName, sproutAddressNamespaceInputName)
			{
				$('select.sproutAddressCountry').change(function() {

					var countryCode = $(this).val();

					var sproutAddresBox = $(this).parents('.sproutaddressfield-box').children('.format-box');
					Craft.postActionRequest("sproutFields/sproutAddress",
						{ sproutAddressNamespaceInputName: sproutAddressNamespaceInputName, sproutAddressName: sproutAddressName, sproutAddress: sproutAddress, countryCode: countryCode },
						function(data) {
							sproutAddresBox.html(data);
						});
				})
			}
		})

})(jQuery);
