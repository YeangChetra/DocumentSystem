$(function () {
	$('.loading-content').fadeIn();
     setTimeout(RemoveClass,200);
     //
     function RemoveClass(){
        $('.loading-content').fadeOut();
     }
});