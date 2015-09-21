(function($) {
$(document).ready(function() {

var westco_widget = new Vue({

	el: '#westco-dashboard-widget',

	data: {
		settingsActive: false,
		buttonContent: 'Save Display Settings',
	},

	methods: {
		toggleSettings: function (){
			this.settingsActive = !this.settingsActive;
		},

		saveDisplaySettings: function (e)
		{
			e.preventDefault();
			this.buttonContent = this.buttonContent + ' <i class="fa fa-spinner fa-spin"></i>';
			// data = {
			// 	action: 'westco_dashboard_settings',
			var data = {
				action: 'westco_dashboard_settings',
				form: $('#westco_dashboard_settings_form').serializeArray(),
			};
			$.ajax({
				type: 'POST',
				data: data,
				url: ajaxurl,
				success: function(returnData) {
					location.reload();				
				},
			});
		}
	}

});

});
})(jQuery);
