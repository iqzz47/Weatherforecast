<?php
$url="https://api.openweathermap.org/data/2.5/forecast?q=Paris&appid=af50c67f9e47865cdcf16c454622209e&units=metric";

$contents = file_get_contents($url);
$w = json_decode($contents);

$n=$w->list[1]->main->temp;
$city=$w->city->name;


echo $city;
echo "\n";

$i=0;
while($i<40)
{
    $dt=$w->list[$i]->dt;
    $temp=$w->list[$i]->main->temp;
    echo "\n";
    $feels_like=$w->list[$i]->main->feels_like;
    $temp_max=$w->list[$i]->main->temp_max;
    $temp_min=$w->list[$i]->main->temp_min;
    $pressure=$w->list[$i]->main->pressure;
    $sea_level=$w->list[$i]->main->sea_level;
    $grnd_level=$w->list[$i]->main->grnd_level;
    $humidity=$w->list[$i]->main->humidity;
    $temp_kf=$w->list[$i]->main->temp_kf;
    $id=$w->list[$i]->weather[0]->id;
    $main= $w->list[$i]->weather[0]->main;
    $description=$w->list[$i]->weather[0]->description;
    $icon=$w->list[$i]->weather[0]->icon;
    $speed=$w->list[$i]->wind->speed;
    $deg=$w->list[$i]->wind->deg;
    $gust=$w->list[$i]->wind->gust;
    $visibility=$w->list[$i]->visibility;
    




$date= new DateTime($w->list[$i]->dt_txt);
$d = $date->format('n/j/Y');
$time= $date->format('H:i');
$dt= strtotime($d);
$day=date("l",$dt);
$d = $date->format('Y-n-j');
$link=mysqli_connect("localhost","root","","weatherinfo");

if($link===false){
    
die("Could not connect".mysqli_connect_error());
}

$sql="INSERT INTO weather(dt, temp, feels_like,temp_max,temp_min,pressure,sea_level,grnd_level,humidity,temp_kf,id,main,description,icon,speed,deg,gust,visibility,time,day,date,city ) VALUES ('$dt','$temp','$feels_like','$temp_max','$temp_min','$pressure','$sea_level','$grnd_level','$humidity','$temp_kf','$id','$main','$description','$icon','$speed','$deg','$gust','$visibility', '$time','$day','$d','$city')";
if (mysqli_query($link,$sql)){
    echo"success";
}
else{
    echo"fail to execute" .mysqli_error($link);
}

mysqli_close($link);

  
   $i++;
}

?>




