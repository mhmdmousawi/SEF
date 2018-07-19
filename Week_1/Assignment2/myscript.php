<?php

//get the directory path given as the second argument
$directory = $argv[2];
//need to replace argv with getopt to specify the format of the input
//getopt(options)

//function that takes a directory path to list its files names
function listFiles($dir){
	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != ".."){
				$entryFullPath = $dir ."/" . $entry;
				if(is_dir($entryFullPath))
					listFiles($entryFullPath);
				else
					echo "$entry\n";
			}
		}
		closedir($handle);
	}else{
		echo "Error Opening Directory..";
	}
}
listFiles($directory);

?>