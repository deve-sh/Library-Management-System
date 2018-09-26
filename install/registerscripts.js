function check(){
	var pass1=document.getElementById('pass1').value;
	var pass2=document.getElementById('pass2').value;

	if((pass1==pass2)&&pass1.length>=8&&pass2.length>=8){
		document.getElementById('pass1').style.border='1px solid green';
		document.getElementById('pass2').style.border='1px solid green';
	}
	else{
		document.getElementById('pass1').style.border='1px solid red';
		document.getElementById('pass2').style.border='1px solid red';
	}
}