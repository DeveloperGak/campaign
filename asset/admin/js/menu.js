$(function(){
	//디바이스사이즈 
	var deviceSize = document.body.clientWidth;

	//메뉴 클릭이벤트
	if (deviceSize> 768) { //768px사이즈 이상 
		$(".menu-trigger").on("click",function(){
			if($(".sidebar_wrapper").hasClass("on")){
				$(".sidebar_wrapper").removeClass("on");
				$(".menu-trigger").css("left","308px");
				$(".main_content").css("margin","70px 73px 20px 310px");
			}else{
				$(".sidebar_wrapper").addClass("on");
				$(".main_content").css("margin","70px 73px 20px 30px");
				$(".menu-trigger").css("left","30px");
			}	
		});
	}else{ //768px사이즈 미만 
		$(".menu-trigger").on("click",function(){
			if($(".sidebar_wrapper").hasClass("mobileon")){
				$(".sidebar_wrapper").removeClass("mobileon");
				$("body").removeClass("sidebarshow");
			}else{
				$(".sidebar_wrapper").addClass("mobileon");
				$("body").addClass("sidebarshow");
			}	
		});

		$("body").on("click",function(e){
			if($(e.target).hasClass('sidebarshow')){
				$(".sidebarshow").removeClass("sidebarshow");
				$(".sidebar_wrapper").removeClass("mobileon");
			}
		});
	}

	//right menu 클릭이벤트
	$(".right_info_txt").on("click",function(){
		if($(".dropdownmenu").hasClass("on")){
			$(".dropdownmenu").removeClass("on");
		}else{
			$(".dropdownmenu").addClass("on");
		}	
		
	});
	//right menu 닫기 이벤트
	$("body").on("click",function(e){
		if(!$(e.target).hasClass('right_info_txt')){
			$(".dropdownmenu").removeClass("on");
		}
	});
	$(".loginoutbtn").on("click",function(e){
		$(location).attr('href', '/admin/logout');
	});
});