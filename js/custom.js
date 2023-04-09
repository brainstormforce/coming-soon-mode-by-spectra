document.addEventListener('DOMContentLoaded', function() {
    var csmAppearance = document.querySelector('input[name="csm_appearance"]');
    if (csmAppearance.checked) {
        var inputValue1 = csmAppearance.value;
        if (inputValue1 == 'dis_more_option') {
            document.querySelector('.chk_con').style.display = 'block';
        } else {
            document.querySelector('.chk_con').style.display = 'none';
        }
    }
    csmAppearance.addEventListener('click', function() {
        var inputValue = this.value;
        if (inputValue == 'dis_more_option') {
            document.querySelector('.chk_con').style.display = 'block';
        } else {
            document.querySelector('.chk_con').style.display = 'none';
        }
    });

    var csmMode = document.querySelectorAll('input[name="csm_mode"]');
    for (var i = 0; i < csmMode.length; i++) {
        csmMode[i].addEventListener('change', function() {
            var mode = this.value;
            if (mode == 'live') {
                document.querySelector('.csm-choose-page').style.display = 'none';
                document.querySelector('.csm-who-can-access').style.display = 'none';
                document.querySelector('.theme-compatibility').style.display = 'none';
            } else {
                document.querySelector('.csm-choose-page').style.display = 'table-row';
                document.querySelector('.csm-who-can-access').style.display = 'table-row';
                document.querySelector('.theme-compatibility').style.display = 'table-row';
            }
        });
    }

    var csmWhoCanAccess = document.querySelectorAll('input[name="csm_who_can_access"]');
    for (var i = 0; i < csmWhoCanAccess.length; i++) {
        csmWhoCanAccess[i].addEventListener('change', function() {
            var csm_who_can_access = this.value;
            if (csm_who_can_access == 'logged') {
                document.querySelector('.csm-custom-roles').style.display = 'none';
            } else {
                document.querySelector('.csm-custom-roles').style.display = 'block';
            }
        });
    }

    var select2js = document.createElement('script');
    select2js.src = 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js';
    select2js.onload = function() {
        var csmShowPage = document.querySelector('#csm_show_page');
        var csmPage = document.querySelector('#csm_page');
        jQuery(csmShowPage).select2();
        jQuery(csmPage).select2();
        jQuery('.select2').css('width','200px');
    };
    document.head.appendChild(select2js);
});
