(function($) {

	Craft.PhoneInputMask = Garnish.Base.extend(
	{
		init: function(id, mask, inputMask, inputDefault) {

			var sproutPhoneFieldId     = '#' + id;
			var sproutPhoneButtonClass = '.' + id;

			// We use setTimeout to make sure our function works every time
			setTimeout(function() {

				var phoneNumber = $(sproutPhoneFieldId).val();

				var data = {
					'mask':  mask,
					'value': phoneNumber
				}

				// Determine if we should show Phone link on initial load
				validatePhoneNumber($(sproutPhoneFieldId), phoneNumber, data);
			}, 500);

			var maskOptions = {
				checked:   {
					"mask":                 mask,
					"clearIncomplete":      false,
					"clearMaskOnLostFocus": false,
					"placeholder":          "#",
					"autoUnmask":           false, // removes characters and accept digits only
					"oncomplete":           function(res) {

						var phoneNumber = res.target.value;
						$(sproutPhoneFieldId).addClass('complete');
						showCallText(phoneNumber, this);

					},
					'onKeyDown':            function(res) {
						// Remove if delete and backspace key is input
						if (res.keyCode == 8 || res.keyCode == 46) {
							// hide call text if incomplete
							$(sproutPhoneButtonClass).html('');
							$(sproutPhoneFieldId).removeClass('complete');
						}
					},
					"onincomplete":         function(res) {
						$(sproutPhoneButtonClass).html('');
						$(sproutPhoneFieldId).removeClass('complete');
					},
					"definitions":          {
						'#': {
							validator:   "[0-9]",
							cardinality: 1
						}
					}
				},
				unchecked: {
					// Allow the first input to be a plus sign and up to a total of 20 digits
					"mask":            "[+]" + inputDefault + "{1,16}",
					"clearIncomplete": false,
					"placeholder":     "#",

					"removeMaskOnSubmit": true,
					"definitions":        {
						'#': {
							validator:   "[0-9]",
							cardinality: 1
						},
						'+': {
							validator:   "[+]",
							cardinality: 1,
						}
					}
				}
			}

			if (inputMask == 'checked') {
				var maskingOption = maskOptions.checked;
				$(sproutPhoneFieldId).inputmask(maskingOption);
			}

			$(sproutPhoneFieldId).on('input', function() {
				var currentPhoneField = this;
				var phoneNumber       = $(this).val();
				var data              = {
					'mask':  mask,
					'value': phoneNumber
				}
				validatePhoneNumber(currentPhoneField, phoneNumber, data);
			});

			function validatePhoneNumber(currentPhoneField, phoneNumber, data) {

				Craft.postActionRequest('sprout-fields/sprout-fields/phone-validate', data, function(response) {
					if (response) {
						showCallText(phoneNumber, currentPhoneField);
					}
					else {
						$(currentPhoneField).next('.sprout-phone-button').html('');
					}
				})
			}

			// Show Call Phone Text
			function showCallText(phoneNumber, currentPhoneField) {

				if (phoneNumber == '') {
					return;
				}

				$(currentPhoneField).next('.sprout-phone-button').addClass('fade');

				$(currentPhoneField).next('.sprout-phone-button').html('<a href="tel:' + phoneNumber +
				'" target="_blank" class="sproutfields-icon">&#xe801;</a>');

				$(currentPhoneField).addClass('complete');
			}
		}
	});

})(jQuery);


