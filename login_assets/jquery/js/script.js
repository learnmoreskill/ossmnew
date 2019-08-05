/** arrayform.com **/
$(function(){
    var sys_show_popup_login_admin = $(".sys_show_popup_login_admin"),
        sys_popup_common_admin = $("#sys_popup_common_admin");
        
	
    /* Open popup when click to:Login as Admin
	---------------------------------------------------------- */
    sys_show_popup_login_admin.on("click",function(){
        sys_popup_common_admin.fadeIn();
        $("body").on("keydown.closePopup",function(e){
            var getCode = e.keyCode ? e.keyCode : e.which;
            if(getCode == 27) {
                sys_popup_common_admin.find(".closePopup").trigger("click");
            }
        });
        return false;
    });
    sys_popup_common_admin.on("click.closePopup",".closePopup,.overlay-bl-bg",function(){
        sys_popup_common_admin.fadeOut(function(){
            $("body").off("keydown.closePopup");
        });
    });
    sys_popup_common_admin.on("click",".main-content",function(e){
        e.stopPropagation();
    });

    
    
});
