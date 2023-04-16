<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./fontawesome-free-6.4.0-web/css/all.css">

</head>

<body>
<form action="" method="post">
  <input type="text" name="search" placeholder="Enter city name" class="search">
  <input type="submit" name="submit" value="Search" class="search">
</form>



<div class="l">
<div class="current">

   
    
    
    <?php


                           if (isset($_POST['submit'])) {
                             $country_name = $_POST['search'];
                                   }

                                 

                            $link=mysqli_connect("localhost","root","","weatherinfo");

                            if($link===false)
                            {
                
                            die("Could not connect".mysqli_connect_error());
                            
                            }
                            if (isset($country_name)) {
                                $sql = "SELECT * FROM weather WHERE city = '{$country_name}' LIMIT 1";
                              } else {
                                $sql = "SELECT * FROM weather WHERE city = 'Dhaka' LIMIT 1";
                              }
                          
                              $result = $link->query($sql);
                              $row = $result->fetch_assoc();
                          
                              
                              if ($row['main'] == 'Clear') {
                                echo "<img src='./img/Clear_sky.png' class='imag'>";
                            } else if ($row['main'] == 'Clouds') {
                                echo "<img src='./img/Overcast_cloud.png' class='imag'>";
                            } else if ($row['main'] == 'Rain') {
                                echo "<img src='./img/light-rain.png' class='imag'>";
                            } else {
                                // default image
                                echo "<img src='./img/default.png' class='imag'>";
                            }



                        
                            echo "<h1 class=temperature>" .  $row['temp']. "°"."</h1>";
                            echo   "<h1 class=cname>". $row['city']."</h1>";
                            echo " <p class=dt>".$row['day']."</p>";

                            
                          ?>
   
   
  
   
</div>
<div class="current1">
   
    <div>
    <p class="dt">Feels like:</p>
    
    <p class="dt">Humidity:</p>
   
    <p class="dt">Speed:</p>
   
    <p class="dt">Pressure:</p>
    </div>

    <div class="k">
       
        <?php  
    echo " <p class=m>".$row['feels_like']. "°"."</p>";
    echo " <p class=m>".$row['humidity']."%"."</p>";
    echo " <p class=m>".$row['speed']."mph"."</p>";
    echo " <p class=m>".$row['pressure']. "in"."</p>";
    
    ?>
       

    </div>

    <div>
        <p class="dt">Min-temp:</p>
        
        
        <p class="dt">Max-temp:</p>
        </div>

        <div class="k">


        <?php  
    echo " <p class=m>".$row['temp_min']. "°"."</p>";
    echo " <p class=m>".$row['temp_max']. "°"."</p>";
   
    ?>
          
    
        </div>
   
</div>
</div>





  <div class="list">
   


        <?php
           $link = mysqli_connect("localhost", "root", "", "weatherinfo");

           if (!$link) {
               die("Could not connect: " . mysqli_connect_error());
           }

           if (isset($country_name)) {
            $sql = "SELECT *  FROM weather WHERE time = '{$row['time']}'AND city = '{$country_name}'";
          } else {
            $sql = "SELECT * FROM weather WHERE time = '{$row['time']}'AND city = 'Dhaka'";
          }
           
          
           $result = mysqli_query($link, $sql);
           
           if (!$result) {
               die("Query failed: " . mysqli_error($link));
           }
           
           while ($row = mysqli_fetch_assoc($result)) {
            $date= new DateTime($row['date']);

            $d = $date->format('j');
            echo "<div class='container'>
                    <div class='text'>".$row['day']." $d"."</div>
                    <div class='weather-box'>";


            if ($row['main'] == 'Clear') {
                echo "<img src='./img/Clear_sky.png' class='images'>";
            } else if ($row['main'] == 'Clouds') {
                echo "<img src='./img/Overcast_cloud.png' class='images'>";
            } else if ($row['main'] == 'Rain') {
                echo "<img src='./img/light-rain.png' class='images'>";
            } else {
                // default image
                echo "<img src='./img/default.png' class='images'>";
            }


         
            echo "<h1 class='temperature'>".$row['temp']. "°"."</h1>
                    <p class='weather-name'>".$row['main']."</p>
                </div>
            </div>";
        }
        
          
           
            

        ?>


<?php
$con = new mysqli("localhost","root","","weatherinfo");


if (isset($country_name)) {
    $myquery1 = "select time from weather where day='Sunday' AND city = '{$country_name}'";
  } else {
    $myquery1 = "select time from weather where day='Sunday' AND city = 'Dhaka'";
  }

$result1 = mysqli_query($con, $myquery1);

$rowsDate = mysqli_fetch_all($result1, MYSQLI_ASSOC);


$xValues = array_map(function ($item) {
    return $item['time'];
}, $rowsDate);

if (isset($country_name)) {
    $myquery2 = "select temp from weather where day='Sunday' AND city = '{$country_name}'";
  } else {
    $myquery2 = "select temp from weather where day='Sunday' AND city = 'Dhaka'";
  }

$result2 = mysqli_query($con, $myquery2);

$rowsAtd = mysqli_fetch_all($result2, MYSQLI_ASSOC);

$yValues = array_map(function ($item) {
    return $item['temp'];
}, $rowsAtd);
?>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="myChart" width="50%" height="15%"></canvas>

<script>
    const x = <?php echo json_encode($xValues) ?>;
const y = <?php echo json_encode($yValues) ?>;

const ctx = document.getElementById("myChart").getContext("2d");

new Chart(ctx, {
  type: "line",
  data: {
    labels: x,
    datasets: [{
      label: "TempVSTime",
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'white',
      borderWidth: 2,
      data: y,
    }, ],

  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: "top",
        labels: {
          color: 'white'
        }
      },
      title: {
        display: true,

      },

    },

    scales: {
      y: {
        grid: {
          borderColor: "rgba(0, 0, 0, 0.1)",
          borderWidth: 2,
        },
        ticks: {
          color: 'white'
        }
      },
      x: {
        grid: {
          borderColor: "rgba(0, 0, 0, 0.1)",
          borderWidth: 2,
        },
        ticks: {
          color: 'white'
        }
      },
    },
  },
});

</script>





       
     


   

</body>

</html>

