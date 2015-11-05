<!--
window.name = "master";
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
 var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
   var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
   if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function mmLoadMenus() {
	if (window.mm_menu_menu0_0) return;
	window.mm_menu_menu3_3 = new Menu("root",120,20,"Arial",11,"#ffffff","#ffff00","#3464a5","#3d7bc8","left","middle",2,0,500,0,0,true,true,true,2,true,true);
	mm_menu_menu3_3.addMenuItem("<b>E&nbsp;L</b>","window.open('#','_self');");
	mm_menu_menu3_3.addMenuItem("<b>C&nbsp;L</b>","window.open('#','_self');");
	mm_menu_menu3_3.childMenuIcon="images/black_arrow.gif";
	mm_menu_menu3_3.hideOnMouseOut=true;
	mm_menu_menu3_3.menuBorder=0;
	mm_menu_menu3_3.menuLiteBgColor='#f0f0f0';
	mm_menu_menu3_3.menuBorderBgColor='';
	mm_menu_menu3_3.bgColor='#e9e9e9';	
	
	window.mm_menu_menu2_2 = new Menu("root",120,20,"Arial",11,"#ffffff","#ffff00","#3464a5","#3d7bc8","left","middle",2,0,500,0,0,true,true,true,2,true,true);
	mm_menu_menu2_2.addMenuItem("<b>Releaving&nbsp;Letter</b>","window.open('#','_self');");
	mm_menu_menu2_2.addMenuItem("<b>Appointment&nbsp;Letter</b>","window.open('#','_self');");
	mm_menu_menu2_2.childMenuIcon="images/black_arrow.gif";
	mm_menu_menu2_2.hideOnMouseOut=true;
	mm_menu_menu2_2.menuBorder=0;
	mm_menu_menu2_2.menuLiteBgColor='#f0f0f0';
	mm_menu_menu2_2.menuBorderBgColor='';
	mm_menu_menu2_2.bgColor='#e9e9e9';	
	
	window.mm_menu_menu1_1 = new Menu("root",120,20,"Arial",11,"#ffffff","#ffff00","#3464a5","#3d7bc8","left","middle",2,0,500,0,0,true,true,true,2,true,true);
	mm_menu_menu1_1.addMenuItem("<b>By&nbsp;Department</b>","window.open('employee_management_system.htm','_self');");
	mm_menu_menu1_1.addMenuItem("<b>Advance&nbsp;Search</b>","window.open('search_employee.htm','_self');");
	mm_menu_menu1_1.childMenuIcon="images/black_arrow.gif";
	mm_menu_menu1_1.hideOnMouseOut=true;
	mm_menu_menu1_1.menuBorder=0;
	mm_menu_menu1_1.menuLiteBgColor='#f0f0f0';
	mm_menu_menu1_1.menuBorderBgColor='';
	mm_menu_menu1_1.bgColor='#e9e9e9';	
	
	window.mm_menu_menu0_0 = new Menu("root",120,20,"Arial",11,"#ffffff","#ffff00","#3464a5","#3d7bc8","left","middle",2,0,500,0,0,true,true,true,2,true,true);
	mm_menu_menu0_0.addMenuItem("<b>Add&nbsp;New</b>","window.open('add_new_employee_details.htm','_self');");
	mm_menu_menu0_0.addMenuItem("<b>View&nbsp;Exiting</b>","window.open('employee_management_system.htm','_self');");
	mm_menu_menu0_0.childMenuIcon="images/black_arrow.gif";
	mm_menu_menu0_0.hideOnMouseOut=true;
	mm_menu_menu0_0.menuBorder=0;
	mm_menu_menu0_0.menuLiteBgColor='#f0f0f0';
	mm_menu_menu0_0.menuBorderBgColor='';
	mm_menu_menu0_0.bgColor='#e9e9e9';	
	
	mm_menu_menu3_3.writeMenus();
} // mmLoadMenus()
//-->