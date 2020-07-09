<?php
$to_email = "iinnffooccoo@gmail.com";
$subject = "Report From INFOCO:";
$body = "L'utilisateur ".$argv[1]." a laissé le commentaire suivant: ";
if(sizeof($argv)>3){
for($x=3;$x<sizeof($argv);$x+=1){
	$body .= $argv[$x];
	$body .= " ";}}
$body .= ". Si vous désirez le contacter, utilisez l'email suivant: ".$argv[2];
$headers = "From: INFOCO";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}
?>