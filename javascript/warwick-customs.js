$(document).ready(function()
{
	$("#id_sendstudentnotifications").val('0'); //set value of 'Notify student' to 'No'. Should be 'No' by default
	
	if ( $("#id_workflowstate").val()!="released" ) { // workflow isnt't Released
        hide_notify();
	}
				
	$("#id_workflowstate").change(function () {
		if ($(this).val() == "released") {
			show_notify();
		}
		else {
			hide_notify();
		}
	});

	toggle_ellipses();
	$(window).resize(function() {toggle_ellipses()})
	
	function hide_notify() {
		$("#id_sendstudentnotifications").val('0') //set value of 'Notify student' to 'No'
										 .hide(); // hide 'Notify student'
		$("label[for='id_sendstudentnotifications']").hide(); //hide the associated label
	}
	
	function show_notify() {
		$("#id_sendstudentnotifications").show() //show 'Notify student'
		$("label[for='id_sendstudentnotifications']").show(); // Show the label
	}
	
	function toggle_ellipses() {
		var ellipses1 = $("#ellipses");
		// var hiddencount = $("#bc1 li:hidden").length;
		var hiddencount = $('#bc1 li').not('li:nth-child(2)').filter(function() {
			var element = $(this);
			if(element.css('display') == 'none') {
				return true;
			}
			return false;
		}).length;

		if (hiddencount > 0) {
			//	if ($("#bc1 li:hidden").length > 0) {
			ellipses1.parent().css('display', 'inline');
			//console.log("hidden count: " + hiddencount + " => show")
		} else {
			ellipses1.parent().hide();
			//console.log("hidden count: " + hiddencount + " => hide")
		}
	}
	// ROLLOVER USER PROFILE BOX
	$('[data-toggle="popover"]').popover({
		trigger: 'manual',
		html: true,
		placement: 'top',
		template: '<div class="popover" onmouseover="$(this).mouseleave(function() {$(this).hide(); });"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
	}).mouseenter(function(e) {
		$(this).popover('show');
	}).on('mouseleave', function(e){
		var _this = this;
		setTimeout(function(){
			if(!$('.popover:hover').length){
				$(_this).popover("hide");
			}
		},100)
	});
	// END 
	

       // Responsive breadcrumbs (ensure course title doesn't disappear)
       $("li:has(.coursetitle)").css('display', 'inline');
});
