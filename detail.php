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
 <div class="content">

<form method="post" action="">
 <input type="text" name="feedurl" placeholder="Enter website feed URL">&nbsp;<input type="submit" value="Submit" name="submit">
</form>
 
 <article>
 
 <header>
  
 
 
</header>

<article>
 
 <?php include ("data.php");

$url = "https://news.google.com/rss/search?hl=fr&gl=FR&ceid=FR%3Afr&oc=11&q=data%20science";

if(isset($_POST['submit'])){
  if($_POST['feedurl'] != ''){
    $url = $_POST['feedurl'];
  }
}


$invalidurl = false;
if(@simplexml_load_file($url)){
 $feeds = simplexml_load_file($url);
}else{
 $invalidurl = true;
 echo "<h2>Enter a valid RSS feed in the box.</h2>";
}

$finalarray = [];
if(!empty($feeds)){

  if(sizeof($feeds->item) > 1){

    $buffer = 0;
    foreach ($feeds->item as $item) {
      $buffer = $buffer +1;
   
     echo "<h1> Item $buffer </h1> ";
     foreach($item->children() as $child){
       
       echo "<p> $child </p>";
     }
   }


  }
  else{

 
 $buffer = 0;

 foreach ($feeds->channel->item as $item) {
   $childrenitemarray = [];
   

  
  foreach($item->children() as $child){
    $childrenitemarray[] = "<p> $child </p>\n";
  }
  $FirstDate = (string)$item->pubDate;
  $FirstDate = substr($FirstDate,5,11);
  $format = "j M Y";
  $dateinteger = DateTime::createFromFormat($format, $FirstDate);
  $date = $dateinteger->format('Y-m-d H:i:s');
  $timestamp = strtotime($date);
  $finalarray[$timestamp] = $childrenitemarray;
}}
    ksort($finalarray);
    $reverse = array_reverse($finalarray);
    foreach($reverse as &$arrayindex ){
      $buffer = $buffer +1;
      echo "<h1> Item $buffer </h1> ";
      foreach($arrayindex as $elements){
        echo "$elements";

      }}
    
}
  ?>
</article>




 </body>
</html>