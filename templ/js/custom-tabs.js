jQuery(function() {
		jQuery( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		
		jQuery("#tabs ul li").click(function() {
			jQuery("#tabs ul li").removeClass("active");
			jQuery(this).addClass("active");
			jQuery(".tab_block").hide();
			
			var activeTab = jQuery(this).find("a").attr("href");
			jQuery(activeTab).fadeIn();
			return false;
		});
});