jQuery(document).ready(function(){
            if(jQuery('input[name="csm_appearance"]').prop('checked') == true){
                var inputValue1 = jQuery('input[name="csm_appearance"]').attr("value");
                if(inputValue1 == 'dis_more_option'){
                    jQuery(".chk_con").show();
                
                }else{
                    jQuery('.chk_con').hide();
                }
            }
            jQuery('input[name="csm_appearance"]').click(function(){
                var inputValue = jQuery(this).attr("value");
                if(inputValue == 'dis_more_option'){
                    jQuery(".chk_con").show();
                }else{
                    jQuery(".chk_con").hide();
                }
            });
            jQuery('input[name="csm_mode"]').change(function(){
                let mode = jQuery(this).val();
                 
                if(mode == 'live'){
                    jQuery('.csm-choose-page').hide();
                    jQuery('.csm-who-can-access').hide();
                    jQuery('.theme-compatibility').hide();
                }
                else{
                    jQuery('.csm-choose-page').css('display','table-row');
                    jQuery('.csm-who-can-access').css('display','table-row');
                    jQuery('.theme-compatibility').css('display','table-row');
                }
            })
        })
        jQuery(document).ready(function(){
            jQuery('input[name="csm_who_can_access"]').change(function(){
                let csm_who_can_access = jQuery(this).val();
                 
                if(csm_who_can_access == 'logged'){
                    jQuery('.csm-custom-roles').hide();
                }
                else{
                    jQuery('.csm-custom-roles').show();
                }
            })
        })
        // In your Javascript (external .js resource or <script> tag)
jQuery(document).ready(function() {
    jQuery('#csm_show_page').select2();
    jQuery('#csm_page').select2();
    jQuery('.select2').css('width','200px');
});