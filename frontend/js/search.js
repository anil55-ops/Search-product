jQuery(document).ready(function(){
var base_url = window.location.origin;	
var site_url_get = jQuery(".site_url_get").val();
jQuery('.search_input_field').on("keyup",function(){
var current_val_search = jQuery(this).val();
 if(current_val_search){
jQuery('.search_data_show').show();		
}
else{
jQuery('.search_data_show').hide();	
}
jQuery.ajax({
             type : "POST",
             url : site_url_get+"/wp-admin/admin-ajax.php",
             data : {action: "get_search_data",current_val_search:current_val_search
			 },
             success: function(response) {
                 jQuery('.search_data_show').html(response); 
                }  
        });     

});   
});
   