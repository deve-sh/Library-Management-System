var openmenu=function()
{
	// Opening Function
	if(screen.width<700)
	{
	    document.getElementById("mySidenav").style.width = "100vw";
	}
	else
	{
		document.getElementById("mySidenav").style.width = '250px';
	}
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function set()
  {
    var firstheight=document.getElementById('topmenu').offsetHeight;

    document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
    document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";

    if((document.getElementsByClassName('main')[0].offsetHeight-document.getElementById('topmenu').offsetHeight)<window.innerHeight)
    {
      document.getElementsByClassName('main')[0].style.height=window.innerHeight-document.getElementById('topmenu').offsetHeight;
    }
  }