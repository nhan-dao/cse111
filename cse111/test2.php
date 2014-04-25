<?php

echo '<td><form method="post" action="'. $_SERVER['PHP_SELF'] .'"> <input type="hidden" name="id" value="'. $id .'" /><input type="checkbox" name="checkinsat" value="1"'. ($data['checkinsat'] == '1'? 'checked' : '') .'<input type="submit" ></form></td>';
if($data['checkinsat'] == '1') 
  echo 'checked />';
 echo '<input type="submit" ></form></td>';
?>