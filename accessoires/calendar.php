<?php
function Calendrier($month,$year,$links) {

  $MonthNames = array(1 => "Janvier","Février","Mars","Avril","Mai","Juin",
               "Juillet","Aout","Septembre","Octobre","Novembre","Décembre");
  $monthname = $MonthNames[$month+0];

  // on ouvre la table
  echo '<table class="cal col-md-12 col-sm-12 col-xs-12" cellspacing="1">';

  // Première ligne = mois et année ou link[0]
  $title = array_key_exists(0, $links) ? $links[0] : $monthname.' '.$year;
  echo '<tr><td colspan="7" class="cal_titre"><span id="fleche_gauche" class="glyphicon glyphicon-step-backward" title="mois précédent"></span> '.$title.' <span id="fleche_droite" class="glyphicon glyphicon-step-forward" title="mois suivant"></span></td>'."</tr>\n";

  // Seconde lignes = initiales des jours de la semaine
  $DayNames = array("L","M","M","J","V","S","D");
  $DayNamesComplete = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche");
  echo '<tr>'; for($i=0;$i<7;$i++) echo "<th title='".$DayNamesComplete[$i]."'>".$DayNames[$i].'</th>'; echo "</tr>\n";

  // On regarde si aujourd'hui est dans ce mois pour mettre un style particulier
  if ($year == date('Y') && $month == date('m'))
    $today = date('d');
  else
    $today = 0;

  $time = mktime(0,0,0,$month,1,$year); // timestamp du 1er du mois demandé
  $days_in_month = date('t',$time);     // nombre de jours dans le mois
  $firstday = date('w',$time);          // jour de la semaine du 1er du mois
  if ($firstday == 0) $firstday = 7;    // attention, en php, dimanche = 0

  $daycode = 1; // ($daycode % 7) va nous indiquer le jour de la semaine.
                // on commence par le lundi, c'est-à-dire 1.

  // on ouvre une première ligne pour le calendrier proprement dit :
  echo '<tr>';

  // on met des cases blanches jusqu'à la veille du 1er du mois :
  for ( ; $daycode<$firstday; $daycode++) echo '<td>&nbsp;</td>';

  // boucle sur tous les jours du mois :
  for ($numday = 1; $numday <= $days_in_month; $numday++, $daycode++) {
    // si on en est au lundi (sauf le 1er), 
    // on ferme la ligne précédente et on en ouvre une nouvelle 
    if ($daycode%7 == 1 && $numday != 1) echo "</tr>\n".'<tr>';
    // on ouvre la case (avec un style particulier s'il s'agit d'aujourd'hui)

    echo ($numday == $today ? '<td class="today" title="Aujourd\'hui : '.$numday.' '.$monthname.' '.$year.'">' : '<td title="'.$numday.' '.$monthname.' '.$year.'">');
    // on affiche le numéro du jour ou le contenu donné par l'utilisateur
    echo (array_key_exists($numday, $links) ? $links[$numday] : $numday);
    // on ferme la case
    echo '</td>';
    }

  // on met des cases blanches pour completer la dernière semaine si besoin :
  for ( ; $daycode%7 != 1; $daycode++) echo '<td>&nbsp;</td>';

  // on ferme la dernière ligne, et la table.
  echo '</tr>'; echo "</table>\n\n";
  }
?>