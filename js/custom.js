// JavaScript Document
jQuery(document).ready(function(){
	
	jQuery("#wgpob_download-comments").click(function(){
      jQuery("#wgpob_downloadtbl-comments").animate({
        height:'toggle'
      });
  });
  
  jQuery("#wgpob_donatehere-comments").click(function(){
      jQuery("#wgpob_donateheretbl-comments").animate({
        height:'toggle'
      });
  });
  
  jQuery("#wgpob_wfpm-comments").click(function(){
      jQuery("#wgpob_wfpmtbl-comments").animate({
        height:'toggle'
      });
  }); 
  
  jQuery("#wgpob_bflog-comments").click(function(){
      jQuery("#wgpob_bflogtbl-comments").animate({
        height:'toggle'
      });
  });
	
	jQuery("#wgpob_save_settings").click(function(){
		var gwidth = jQuery("#google_width").val();							
		if(gwidth<120 || gwidth >450)
		{
			alert(msg1);
			jQuery("#google_width").val('');
			jQuery("#google_width").focus()
			return false;
		}
		if(! jQuery.isNumeric(gwidth))
		{
			alert(msg2);
			jQuery("#google_width").val('');
			jQuery("#google_width").focus();
			return false;
		}
		return true;
	});	
	
	
	
						
});