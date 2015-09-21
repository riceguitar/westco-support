(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/ir8d7knt';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
window.intercomSettings = {
	app_id: "ir8d7knt",
	widget: {
		activator: ".intercom-activate"
	}
};
(function() {
	jQuery(document).ready(function() {
		jQuery('#wp-admin-bar-support').find('.ab-item').on('click', function() {
			Intercom('show');
		});
	});
})();
