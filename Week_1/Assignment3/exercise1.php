#!/usr/bin/php
<?php
	$inputPath = 'php://stdin';
	$colorToCheckOn = "Black";
	$colorNotToCheckOn ="White";
	$inputArray = readInputToArray($inputPath);
	$playersNumber = sizeof($inputArray);
	$EvenIsTrue = checkIfEvenAsStart($inputArray,$colorToCheckOn);
	if($EvenIsTrue)
		$outputArray=array($colorNotToCheckOn);
	else 
		$outputArray=array($colorToCheckOn);

	fillOutput($outputArray,$inputArray,$playersNumber,$colorToCheckOn,$colorNotToCheckOn,$EvenIsTrue);
	printOutput($outputArray);
	echo "YOU PASSED THE CHALLENGE".PHP_EOL;
	
	function fillOutput($outputArray,$inputArray,$playersNumber,$colorToCheckOn,$colorNotToCheckOn,$EvenIsTrue){
		global $outputArray;
		for( $indexReached=1; $indexReached < $playersNumber; $indexReached++){
			$colorPresence = countPresence( $outputArray,
											0,
											$indexReached-1,
											$colorToCheckOn)
							+ countPresence($inputArray,
											$indexReached+1,
											$playersNumber-1,
											$colorToCheckOn);
			if($colorPresence %2 == 0)
				$presentEven = 1;
			else 
				$presentEven = 0;
			if($presentEven)
				array_push($outputArray,$colorNotToCheckOn);
			else
				array_push($outputArray,$colorToCheckOn);
		}
	}
	function countPresence($array,$indexStart,$indexEnd,$colorToCheckOn){
		$occurrence = 0;
		for($i=$indexStart; $i<=$indexEnd; $i++){
			if($array[$i]==$colorToCheckOn)
				$occurrence+=1;
		}
		return $occurrence;
	}
	function checkIfEvenAsStart($array,$colorToCheckOn){
		$occurrence = 0;
		for($i=1; $i<sizeof($array); $i++){
			if($array[$i]==$colorToCheckOn)
				$occurrence+=1;
		}
		if($occurrence %2==0)
			return true;
		return false;
	}
	function readInputToArray($inputPath){
		$inputContent = fopen($inputPath,"r");
		// fill input in array
		if ($inputContent) {
		   $contentArray = explode("\n", fread($inputContent, filesize($inputPath)));
		}
		fclose($inputContent);
		return $contentArray;
	}
	function printOutput($array){
		foreach($array as $value)
			echo $value.PHP_EOL;
	}
?>