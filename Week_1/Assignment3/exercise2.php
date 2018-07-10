<?php $a=preg_grep("/^([asdfghjkl]*|[qwertyuiop]*|[zxcvbnm]*)$/",file('php://stdin'));if(!empty($a)){$l=array_map('strlen',$a);echo$a[array_search(max($l),$l)];}else echo 0;
