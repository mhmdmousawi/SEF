<?php

$file_logAccess_path = "/var/log/apache2/access.log";
$file_logAccess_content = fopen($file_logAccess_path,"r")
							or die ("Unable to open file");
							//never use die

//echo fread($file_logAccess_content, filesize($file_logAccess_path))
while(!feof($file_logAccess_content)){
	if($line = fgets($file_logAccess_content)){	

		$Parameters = explode(" ", $line);

		$IP_ADDRESS = $Parameters[0];
		$DATE  = substr($Parameters[3],1,strlen($Parameters[3]));
		$RESPONSE_TYPE =  $Parameters[5]." ".$Parameters[6] ." ".$Parameters[7]; 
		$RESPONCE_CODE  = $Parameters[8];

		//change date fromat to be displayed
		$DATE_FORMAT_OLD = DateTime::createFromFormat('j\/M\/Y:H:i:s',$DATE);
		$DATE_FORMAT_NEEDED = $DATE_FORMAT_OLD->format('l, F d Y : h-i-s');

		$outputNeeded = $IP_ADDRESS." -- ".
						$DATE_FORMAT_NEEDED." -- ".
						$RESPONSE_TYPE." -- ".
						$RESPONCE_CODE;

		echo "$outputNeeded\n";	
	}

}

fclose($file_logAccess_content);

?>