!function($){$(document).ready(function(){var t=new Vue({el:"#westco-dashboard-widget",data:{settingsActive:!1,buttonContent:"Save Display Settings"},methods:{toggleSettings:function(){this.settingsActive=!this.settingsActive},saveDisplaySettings:function(t){t.preventDefault(),this.buttonContent='Saving... <i class="fa fa-spinner fa-spin"></i>';var e={action:"westco_dashboard_settings",form:$("#westco_dashboard_settings_form").serializeArray()};$.ajax({type:"POST",data:e,url:ajaxurl,success:function(t){location.reload()}})}}})})}(jQuery);