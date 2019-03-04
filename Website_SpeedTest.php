<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <link ref="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Website SpeedTest</title>    
</head>


<body>
    <?php
        // this function calls the website and records the load time
        function callWebsite($url)
        {
            $my_timer = microtime();
            $time_parts = explode(' ', $my_timer);
            $time_right_now = $time_parts[1] + $time_parts[0];
            $starting_time = $time_right_now;
  
            echo "<script>var win; win = window.open('<?php echo $url; ?>'); win.close()</script>";
           
            $my_timer = microtime();
            $time_parts = explode(' ', $my_timer);
            $time_right_now = $time_parts[1] + $time_parts[0];
            $finishing_time = $time_right_now;
            $total_time_in_secs = ($finishing_time - $starting_time);

            return $total_time_in_secs;
        }

        // this function plots the line graph of the recorded load time
        function drawGraph($loadTime)
        {
        echo "<div class=\"container\">
        <canvas id=\"myChart\" width=\"500\" height=\"300\"></canvas>
        <script>
        var myChart = document.getElementById('myChart').getContext('2d');
        var popChart = new Chart(myChart,{
            type: 'line',
            data:{
                labels: ['Round1','Round2','Round3','Round4','Round5'],
                datasets:[{
                    label: 'Load Time(seconds)',
                    data :[
                            $loadTime[0],
                            $loadTime[1],
                            $loadTime[2],
                            $loadTime[3],
                            $loadTime[4]
                          ],

                 backgroundColor: [
                'rgba(54, 162, 235, 0.2)'
                                   ]
                }]            
            },
            options:{}
        });
    </script> 
    </div>";
        }
    ?>

    <form metod="post">
    <table>
        <tr>
            <td> Enter the url: </td>
            <td><input type ="text" id="txturl" name="txturl"/></td>
        </tr>
        
        <tr>
            <td colspan="2"><input type = "submit" name="submit" id="submit" value="Submit"/></td>
        </tr>

        <tr>
            <th colspan= "2">
            <?php
                if(isset($_REQUEST['submit']))
                {
                    $enteredURL = $_REQUEST['txturl'];
                    
                    // entered url is validated
                    if(filter_var($enteredURL, FILTER_VALIDATE_URL))
                    {
                        for($i =0; $i<5; $i++)                    
                        {
                            $loadTime[$i] = callWebsite($enteredURL);                     
                         }
                        drawGraph($loadTime);
                    }
                    
                    else
                    {
                        echo("$enteredURL is not a valid URL");
                    }

                }
            ?>
            </th>
        </tr>
    </table>
    </form>
</body>
</html>