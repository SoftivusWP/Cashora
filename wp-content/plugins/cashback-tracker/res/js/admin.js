
jQuery(document).ready(function ($) {

    jQuery('.cbtrkr_percent_type').on('change', function(){
        
        if (jQuery(this).val() === 'flat_amount')
        {
            jQuery(this).siblings('.cbtrkr_currency').fadeIn();        
            jQuery(this).siblings('.cbtrkr_percentage_value').attr("placeholder", "Flat Amount");      
            jQuery(this).siblings('.cbtrkr_percentage_value').attr("max", "any");      
        } else {
            jQuery(this).siblings('.cbtrkr_currency').fadeOut();
            jQuery(this).siblings('.cbtrkr_percentage_value').attr("placeholder", "Percentage Value");      
            jQuery(this).siblings('.cbtrkr_percentage_value').attr("max", "1000");            
        }              
    });    

});