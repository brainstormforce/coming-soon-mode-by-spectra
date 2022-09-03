window.onload = function() {
    var csm_mode = document.querySelectorAll('input[name="csm_mode"]');
	var csm_access = document.querySelectorAll('input[name="csm_who_can_access"]');
	var csm_appearance = document.querySelectorAll('input[name="csm_appearance"]');
	csm_appearance.forEach((e) => {
		if(e.getAttribute('checked') == true){
			var inputValue1 = e.getAttribute("value");
			if(inputValue1 == 'dis_more_option'){
				document.querySelectorAll(".chk_con").forEach((e) => { e.style.display = "";})
			}else{
				document.querySelectorAll(".chk_con").forEach((e) => { e.style.display = "none";})
			}
		}
		e.addEventListener('click' , function(){
			var inputValue = e.getAttribute("value");
			if(inputValue == 'dis_more_option'){
				document.querySelectorAll(".chk_con").forEach((e) => { e.style.display = "";})
			}else{
				document.querySelectorAll(".chk_con").forEach((e) => { e.style.display = "none";})
			}
		});
	})
	csm_mode.forEach((e) => {
		e.addEventListener("change", function(){
			let mode = e.value;
			if(mode == 'live'){
				document.querySelectorAll('.csm-choose-page').forEach((e) => { e.style.display= "none";})
				document.querySelectorAll('.csm-who-can-access').forEach((e) => { e.style.display= "none";})
				document.querySelectorAll('.theme-compatibility').forEach((e) => { e.style.display= "none";})
			}
			else{
				document.querySelectorAll('.csm-choose-page').forEach((e) => { e.style.display= "table-row";})
				document.querySelectorAll('.csm-who-can-access').forEach((e) => { e.style.display= "table-row";})
				document.querySelectorAll('.theme-compatibility').forEach((e) => { e.style.display= "table-row";})
			}
		})
	})
	csm_access.forEach((e) => {
		e.addEventListener('change', function(){
			let csm_who_can_access = e.value;
			if(csm_who_can_access == 'logged'){
				document.querySelectorAll('.csm-custom-roles').forEach((e) => { e.style.display= "none";})
			}
			else{
				document.querySelectorAll('.csm-custom-roles').forEach((e) => { e.style.display= "";})
			}
		})
	})

}
(function($){
	$('#csm_show_page').select2({placeholder: "Select a page"});
    $('#csm_page').select2();
    $('.select2').css('width','200px');
}(jQuery))
