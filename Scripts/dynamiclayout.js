matchWidth=function(){
	if (parseInt(navigator.appVersion)>3) {
	 if (navigator.appName=="Netscape") {
	  winW = window.innerWidth;
	  winH = window.innerHeight;
	 }
	 if (navigator.appName.indexOf("Microsoft")!=-1) {
	  winW = document.body.offsetWidth;
	  winH = document.body.offsetHeight;
	 }
	 else{
	  winW = document.body.offsetWidth;
	  winH = document.body.offsetHeight;		 
	 }
	}
	
	LayoutBody=document.getElementById('layoutBody');
	Ticker=document.getElementById('temp');
//	alert(Ticker.style.left);
	
	maxLayoutWidth=1000;
	if(winW>maxLayoutWidth){
		layoutWidth=maxLayoutWidth-0;
		LayoutBodyLeft=parseInt((winW-maxLayoutWidth)/2);
		
		LayoutBody.style.width=layoutWidth+'px';
		LayoutBody.style.left=LayoutBodyLeft+'px';
//		Ticker.style.left=LayoutBodyLeft+'px';
	}
	else{
		LayoutBody.style.width='778px';
		LayoutBody.style.left='0px';
		LayoutBody.style.top='0px';
//		alert(navigator.userAgent);
	}
}

window.onresize= function(){
	matchWidth();
}