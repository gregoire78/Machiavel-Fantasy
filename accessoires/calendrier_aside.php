<?php
require("connect_bdd.php");
$sql="SELECT date_event FROM event WHERE statut_event!=0 AND date_event >= SYSDATE()"; // 
$query=$connect->prepare($sql);
$query->execute();
$total=$query->rowCount();
$j=0;
while ($data=$query->fetch(PDO::FETCH_ASSOC)){		//hour_event
    $datecal_day[$j]=date("d",strtotime ($data['date_event']));
    $datecal_month[$j]=date("m",strtotime ($data['date_event']));
    $datecal_year[$j]=date("Y",strtotime ($data['date_event']));
    $j++;
}
?>
<div id="cal"><?php include_once('ajax/ajax_cal.php'); ?></div>

