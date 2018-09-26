<?php

$array1=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
// SMALL LETTERS

$array2=array();                                                     //CAPITAL LETTERS

for($i=0;$i<sizeof($array1);$i++){
	$array2[$i]=strtoupper($array1[$i]);  //CONVERSION OF array1 elements to uppercase and assignment to array2!
}

$array3=array('/','*','&','!','$','%','^','*',',','?','[',']','_');     //ARRAY OF SPECIAL CHARACTERS

$array4=array('1','2','3','4','5','6','7','8','9','0');

//NOW GENERATION OF RANDOM SALT OF LENGTH 7

$combinedarray=array_merge($array1,$array2,$array3,$array4);   //ARRAY OF CHARACTERS,NUMBERS AND SPECIAL CHARS

$chararray=array_merge($array1,$array2);  //ARRAY OF LOWERCASE AND UPPERCASE ALPHABETS

//SIMPLE CARD NUMBERS FOR MEMBERS - LENGTH 13

$capitalarray=array_merge($array2,$array3,$array4);

   $p=0;
   $cardid="";
   while($p<13){
     $randomnum=rand(0,sizeof($capital)-1);
     $cardid=$cardid.$chararray[$randomnum];
     $p=$p+1;
   }
   echo $cardid;
   return $cardid;


?>