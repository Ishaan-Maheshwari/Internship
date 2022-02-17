<?php
echo "This is the program of Fibonacci Series.\n";
$n = readline('Enter the length of Fibonacci series : ');
while ($n < 0){
	echo "This is not a valid input. Please enter a positive number.\n";
	$n = readline('Enter the length of Fibonacci series : ');
}
$num1 = 0;
$num2 = 1;
$counter= 0; 
while($counter < $n){
	echo $num1."  ";
	$num3= $num2 + $num1;
	$num1= $num2;
	$num2= $num3;
	$counter= $counter+1;
}
?>