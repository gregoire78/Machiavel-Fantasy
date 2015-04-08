<?php
if(isset($_POST['ajax']))
{
    include_once('../accessoires/calendar.php');

    include_once('../accessoires/connect_bdd.php');
    $sql="SELECT date_event, title_event FROM event WHERE statut_event!=0 AND date_event >= SYSDATE()";//
    $query=$connect->prepare($sql);
    $query->execute();
    $total=$query->rowCount();
    $j=0;
    while ($data=$query->fetch(PDO::FETCH_ASSOC)){		//hour_event
        $datecal_day[$j]=date("d",strtotime ($data['date_event']));
        $datecal_month[$j]=date("m",strtotime ($data['date_event']));
        $datecal_year[$j]=date("Y",strtotime ($data['date_event']));
		$title_event[$j]=$data['title_event'];
        $j++;
    }
}
else
{
    include_once('accessoires/calendar.php');
}

/* Calendrier */
if(isset($_POST['moi']))
{
    $cur_month=$_POST['moi'];
}
else
{
    $cur_month=date('m');
}
if(isset($_POST['annee']))
{
    $cur_year=$_POST['annee'];
}
else
{
    $cur_year=date('Y');
}
for($b=0;$b<$total;$b++)
{
    if($cur_month==$datecal_month[$b] && $cur_year==$datecal_year[$b])
    {
        if ($datecal_day[$b] < 10)
        {
            $datecal_day[$b] = substr($datecal_day[$b],1);
        }
        $links[$datecal_day[$b]]='<a href="http://machiavel.fr/'.$datecal_day[$b].'/'.$datecal_month[$b].'/'.$datecal_year[$b].'" class="st1">'.$datecal_day[$b].'</a>';
    }
}
if(!isset($links))
{
    $links=array();
}
Calendrier($cur_month, $cur_year, $links);
?>
<script>
$(document).ready(function(){
    var moi = <?php echo $cur_month; ?>;
    var annee = <?php echo $cur_year; ?>;
    $('#fleche_gauche').click(function () {
        moi = moi-1;
        if(moi<1)
        {
            moi = 12;
            annee = annee-1;
        }

        var ajax =true;
        $.post('ajax/ajax_cal.php',{annee:annee,moi:moi,ajax:ajax},function(data){
            $('#cal').html(data);
        });
    });

    $('#fleche_droite').click(function () {
        moi = moi+1;
        if(moi>12)
        {
            moi = 1;
            annee = annee+1;
        }
        var ajax =true;
        $.post('ajax/ajax_cal.php',{annee:annee,moi:moi,ajax:ajax},function(data){
            $('#cal').html(data);
        });
    });

    /*pour empecher le scroll quand on est sur lee calendrier*/
    /*$('#cal').bind('mousewheel DOMMouseScroll', function(e)
    {
        var scrollTo = null;

        if (e.type == 'mousewheel')
        {
            scrollTo = (e.originalEvent.wheelDelta * -1);
        }
        else if (e.type == 'DOMMouseScroll')
        {
            scrollTo = 40 * e.originalEvent.detail;
        }

        if (scrollTo)
        {
            e.preventDefault();
            $(this).scrollTop(scrollTo + $(this).scrollTop());
        }


        if(e.originalEvent.wheelDelta /120 > 0)
        {
            moi = moi+1;
            if(moi>12)
            {
                moi = 1;
                annee = annee+1;
            }

            var ajax =true;
            $.post('ajax/ajax_cal.php',{annee:annee,moi:moi,ajax:ajax},function(data){
                $('#cal').html(data);
            });
        }
        else
        {
            moi = moi-1;
            if(moi<1)
            {
                moi = 12;
                annee = annee-1;
            }

            var ajax =true;
            $.post('ajax/ajax_cal.php',{annee:annee,moi:moi,ajax:ajax},function(data){
                $('#cal').html(data);
            });
        }
    });*/
});
</script>