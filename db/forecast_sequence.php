<?php
    session_start();

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        // retrieving userID from session variable
        $userID = $_SESSION['userID'];
        // echo "userID: " . $userID . "<br/>";

        // retrieving forecast period from dropdown selection
        $period = $_REQUEST['forecastperiod'];
        // echo "period: " . $period;

        // running the python script & retrieving forecast result
        $output = shell_exec('python "C:\\Applications\\XAMPP\\htdocs\\StockFlow IMS (FINAL YEAR PROJECT)\\src\\forecast_model.py" ' . $userID . ' ' . $period . ' 2>&1');
        // $output = shell_exec('python "C:\\Applications\\XAMPP\\htdocs\\StockFlow IMS (FINAL YEAR PROJECT)\\src\\forecast_model.py" ' . $userID . ' ' . $period);
        // DEBUGGING HEREEEEEEE !!!!!
        // debugging
        // $output = shell_exec('python --version 2>&1');
        echo "just came out of shell_exec()";
        // CONTINUE DEBUGGING. NOTHING BEING OUTPUT FROM PYTHON

        // extracting python script output (sent back as JSON)
        $forecast = json_decode($output, true);  // 'true' tells json_decode to return data as associative array 
                                                 // instead of PHP object
        
        // test
        echo $forecast;

        // sending forecast result to the frontend in JSON format
        // echo json_encode($output);
    }
?>