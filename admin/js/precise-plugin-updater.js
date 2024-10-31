(function($) {
	'use strict';

	$(function() {
		if ($('.ppu-container').length > 0) {
			var currentValues = Array.prototype.reduce.call(
				$('.ppu-container').find('input:checked'),
				function(acc, input) {
					acc[input.name] = input;
					return acc;
				},
				{}
			);

			$('input[name^="ppu_"]').change(function(evt) {
				evt.preventDefault();
				var self = this;
				var parentCell = $(self)
					.parent()
					.parent()
					.parent();
				parentCell.find('input').prop('disabled', true);
				$.ajax({
					url: ajaxurl,
					method: 'POST',
					data: {
						action: 'ppu_plugin_setting',
						nonce: $.trim($('#ppu-ajax-nonce').text()),
						name: self.name,
						value: self.value,
					},
					success: function(data) {
						if ($.trim(data) === '1') {
							parentCell.find('input').prop('disabled', false);
							parentCell.css('outline', '2px solid green');
							currentValues[self.name] = self;
							setTimeout(function() {
								parentCell.css('outline', 'none');
							}, 1000);
						} else {
							onError();
						}
					},
					error: onError,
				});

				function onError(e) {
					parentCell.find('input').prop('disabled', false);
					parentCell.css('outline', '2px solid red');
					$(currentValues[self.name]).prop('checked', true);
					setTimeout(function() {
						parentCell.css('outline', 'none');
					}, 1000);
				}
			});
		}
	});
})(jQuery);
