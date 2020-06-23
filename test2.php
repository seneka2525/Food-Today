<?php
$a = 1;
if(1 === $a){
  global $a;
  echo $a;
}
// echo "ありがとう";
?>