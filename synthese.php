<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

 <head>
  <meta charset="UTF-8" />
  <title>LP SID - Serveur - TD1</title>
  <link rel="stylesheet" type="text/css" href="style.css" title="Normal" />
  <style>
   table {margin: auto}
   td,th {border: 1px solid #333}
   tfoot {background-color: #333;color: #fff;}
   #aujourdhui {background-color: rgb(250,250,200); font-weight: bold}
  </style>
 </head>
 
 <body>
 
 <article>
 
 <header>
  
 
 
</header>

<article>
 <h1>Test Tableau en question</h1>
 <table>
  <thead>
    <tr>
        <th colspan="2">Synthese</th>
    </tr>
</thead>
<tbody>

<?php include ("data.php");

 
  // Récupération du fichier XML
  for($i = 0; $i < 6;$i++){
    $rss_feed = simplexml_load_file($ArrayURL[$i]);
    $buffer = 0;
    if(!empty($rss_feed)){
      $itemlength = sizeof($rss_feed->item);
      if ($itemlength == 0){
      $itemlength = sizeof($rss_feed->channel->item);    
      echo "<tr><td>$ArrayURL[$i]</td><td>$itemlength item</td></tr> \n";
      }
      else{
        echo "<tr><td>$ArrayURL[$i]</td><td>$itemlength item</td></tr> \n";

      }
    }
  }
  ?>
  </tbody>
 </table>
  <table>
  <thead>
    <tr>
        <th colspan="2">Synthese selon date</th>
    </tr>
</thead>
<tbody>
  <?php 
  
  for($i = 0; $i < 6;$i++){
    $array = [];
    echo "<tr><td>$ArrayURL[$i]</td><td>";
  
    $rss_feed = simplexml_load_file($ArrayURL[$i]);
    $buffer = 0;
    $FirstDate = 0;
    if(!empty($rss_feed)){
      $itemlength = sizeof($rss_feed->item);
      if ($itemlength == 0){
        foreach($rss_feed->channel->item as $itemize){
        if($buffer == 0){
          $FirstDate = (string)$itemize->pubDate;
          $FirstDate = substr($FirstDate,5,11);
        }
          
          $CurrentDate = (string)$itemize->pubDate;
          $CurrentDate = substr($CurrentDate,5,11);
      
      if ($FirstDate != $CurrentDate){
        $format = "j M Y";
        $dateinteger = DateTime::createFromFormat($format, $FirstDate);
        $date = $dateinteger->format('Y-m-d H:i:s');
        $timestamp = strtotime($date);
        $array[$timestamp] = "<tr><td>$FirstDate</td><td>$buffer item</td></tr> \n";
        $FirstDate = (string)$itemize->pubDate;
        $FirstDate = substr($FirstDate,5,11);
        $buffer = 0;

      }
      $buffer = $buffer + 1;
    }
    $format = "j M Y";
    $dateinteger = DateTime::createFromFormat($format, $FirstDate);
    $date = $dateinteger->format('Y-m-d H:i:s');
    $timestamp = strtotime($date);
    $array[$timestamp] = "<tr><td>$FirstDate</td><td>$buffer item</td></tr> \n";
    ksort($array);
    $reverse = array_reverse($array);
      
        foreach($reverse as &$value ){
          echo $value;
        }
      }
      else{
        foreach($rss_feed->item as $itemize){
          $dc = $itemize->children('http://purl.org/dc/elements/1.1/');
          if($buffer == 0){
            $FirstDate = date_parse($dc->date);
          }
            
            $CurrentDate = date_parse($dc->date);
            
        
        if ($FirstDate["day"] != $CurrentDate["day"] || $FirstDate["month"] != $CurrentDate["month"]|| $FirstDate["year"] != $CurrentDate["year"]){
          $dateObj   = DateTime::createFromFormat('!m', $FirstDate["month"]);
          $monthName = $dateObj->format('F');
          $day = $FirstDate["day"];
          $year = $FirstDate["year"];
          $FirstDate = substr($monthName,0,3);
          echo "<tr><td>$day $FirstDate $year </td><td>$buffer item</td></tr> \n";

          
          $FirstDate = date_parse($dc->date);
          $buffer = 0;
  
        }
        $buffer = $buffer + 1;
      }
        $dateObj   = DateTime::createFromFormat('!m', $FirstDate["month"]);
          $monthName = $dateObj->format('F');
          $day = $FirstDate["day"];
          $year = $FirstDate["year"];
          $FirstDate = substr($monthName,0,3);  
          echo "<tr><td>$day $FirstDate $year </td><td>$buffer item</td></tr> \n";
      }
    }
    echo "</td><td>";
  }

  
 ?>
</tbody>
</table>
</article>



 </body>
</html>