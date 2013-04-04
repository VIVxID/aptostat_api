<?php

$fil = file("pingdom.txt");
$stuff = array();

foreach ($fil as $line) {

	$stuff[] = "INSERT INTO Service (Name) VALUES ('".trim($line)."');\n";
}


$file = fopen("pingdom.sql","a+");

foreach ($stuff as $linje) {

	fwrite($file,$linje);

}
