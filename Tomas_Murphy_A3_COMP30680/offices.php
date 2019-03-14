<!DOCTYPE html>
<html>

<head>
    <title>Offices</title>
        <!--    Bootstrap grid system:
    https://www.w3schools.com/bootstrap4/bootstrap_grid_system.asp
    -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/styles/styles.css">
    <!-- https://fonts.google.com/ -->
    <link href="https://fonts.googleapis.com/css?family=Karma" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=News+Cycle" rel="stylesheet">


</head>

<!--    Set cookie when page is unloaded-->
<body class="fixed-bg" id="fixed-bg-office" onunload="unloadP('officeScroll')">

    <div class="container-fluid">

        <div class="row">
            <div class="col-3">
                <a target="_blank" href="https://goo.gl/maps/PXqrnEHMdv92"><img class="logo" src="./images/wexlogo.png"></a>
            </div>
            <div class="col-6">
                <nav>
                    <?php include 'menu.php';?>
                </nav>
            </div>
            <div class="col-3"></div>
        </div>

<?php 
// Error handling: http://php.net/manual/en/function.set-error-handler.php
set_error_handler("myErrorHandler");
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'classicmodels';

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
    die("Please contact the IT team, as an error has occured connecting to the database. State the following error Message: " .$conn->connect_error);
}

try
{
$sql = "SELECT DISTINCT city, addressLine1, addressLine2, phone, officeCode FROM offices ORDER BY officeCode";
$result = $conn->query($sql);
}
catch(Exception $e){
  echo 'Please contact the IT team, as an error has occured retrieving data from the database. State the following error Message: ' .$e->getMessage();
}
 ?>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div id="officess">

                    <h1>Offices</h1>

                    <table id="officetable" class="output-table output-table-rounded">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>Employees</th>
                            </tr>
                        </thead>
                        <tbody>

        <?php try {
        if ($result->num_rows > 0){
         while($row = $result->fetch_assoc()){ 
            echo'<tr>';
                echo'<td>' . $row["city"] . '</td>';
                echo'<td>' . $row["addressLine1"] . " " . $row["addressLine2"] . '</td>';
                echo'<td>' . $row["phone"] . '</td>'; 
                $emplID = $row["officeCode"];
//                Image as submit button:
//            https://stackoverflow.com/questions/7935456/input-type-image-submit-form-value
                

//               Remove button background:
//                https://stackoverflow.com/questions/11497094/remove-border-from-buttons

                echo "<td><form action= 'offices.php' method = 'POST' name= 'officeForm' id = 'offForm'><input type= 'hidden' value = '$emplID' name = 'offices'> <button type= 'submit' name= 'submit' value= 'submit' style= 'border: 0; padding: 0; background:none;'><img src= './images/employees.png' style = 'width:100%; height: auto; cursor: pointer;' alt='submit'></button></form></td>";
            echo '</tr>';
            }
            }
          

    else {
        trigger_error("An error has occured with the database. Please contact the IT team.", E_USER_NOTICE);
    }
}
         catch(Exception $ex){
    echo 'Please contact the IT team, as an error has occured retrieving data from the database. State the following error Message: ' .$e->getMessage();
}
?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-1"></div>
        </div>

<?php
try
{
  
    if(isset($_POST['submit'])) {
        $empId = $_POST['offices'];
        $sql = "SELECT officeCode, firstName, lastName, jobTitle, employeeNumber, email FROM employees WHERE officeCode = '$empId' ORDER BY jobTitle";
        $result = $conn->query($sql);

        
        echo '<div>';
            
            echo "<table id='emptable' class='output-table output-table-pop'>";
                echo '<thead>';
                    echo '<tr>';
                    echo'<th></th>';
                        echo'<th></th>';
                        echo'<th></th>';
                        echo"<th style='font-size: 100%; font-family: News Cycle, sans-serif';>&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' onclick='hideme()'>Close this window!</button></th>";
                    echo'</tr>';
                    echo'<tr>';
                        echo"<th style='font-weight: bold; font-size: 120%'>Full Name</th>";
                        echo"<th style='font-weight: bold; font-size: 120%'> Job Title</th>";
                        echo"<th style='font-weight: bold; font-size: 120%'>Employee Number</th>";
                        echo"<th style='width: 40%; font-weight: bold; overflow-x: auto; font-size: 120%'>Email Address</th>";

                    echo'</tr>';
                echo'</thead>';
                echo'<tbody>';



        try {
        if ($result->num_rows > 0){
         while($row = $result->fetch_assoc()){ 
            echo '<tr>';
                echo "<td>" . $row["firstName"] . " " . $row["lastName"] . "</td>";
                echo "<td>" . $row['jobTitle'] . "</td>";
                echo "<td>" . $row['employeeNumber'] . "</td>"; 
                echo "<td style='width: 40%; overflow-x: auto;'>" . $row['email'] . "</td>"; 
            echo '</tr>';
                                            }
                                 }

                else {
                     trigger_error("An error has occured retrieving results from the database. Please contact the IT team.", E_USER_NOTICE);
                     }
                             }
        
             catch(Exception $ex){
        echo 'Please contact the IT team, as an error has occured retrieving data from the database. State the following error Message: ' .$ex->getMessage();
                                 }

}

}
catch(Exception $exc){
  echo 'Please contact the IT team, as an error has occured retrieving data from the database. State the following error Message: ' .$exc->getMessage();
}




            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            $conn->close();
    ?>

        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <footer>
                    <?php include 'footer.php';?>
                </footer>
            </div>
            <div class="col-4"></div>
        </div>
  
    </div>
<?php

//Error handling: http://php.net/manual/en/function.set-error-handler.php
//error handler function

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return false;
    }

    switch ($errno) {
    case E_USER_ERROR:
        alert("Oops, something has gone wrong with the website. Please contact the internal IT team for support!");
        error_log("Error: [$errno] $errstr . Fatal error on line $errline in file $errfile",0);
        exit(1);
        break;

    case E_USER_WARNING:
        echo "An connecting to the database has occurred, please contact the IT team for support";
       error_log("Error: [$errno] $errstr",0);
  
        break;

    case E_USER_NOTICE:
        
        alert("An error retrieving data from the database has occurred, please contact the IT team for support");
        error_log("Error: [$errno] $errstr",0);
  
        break;

    default:

    alert("An unknown error has occured, please contact the IT team for support");
        error_log("Error: [$errno] $errstr",0);
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;


}

//Pop up alerts:
//https://stackoverflow.com/questions/13851528/how-to-pop-an-alert-message-box-using-php

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>

</body>
<script>
    function hideme() {
        document.getElementById("emptable").style.display = "none";
        loadP('officeScroll');
    }

//     Remember scroll position with cookies:
// http://blog.crondesign.com/2009/09/scrollfix-remember-scroll-position-when.html

// Setting cookies so that when the user clicks off the more info tables, they will return to where they were beforehand.

    function getScrollXY() {
        var x = 0,
            y = 0;
        if (typeof(window.pageYOffset) == 'number') {
            // Netscape
            x = window.pageXOffset;
            y = window.pageYOffset;
        } else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
            // DOM
            x = document.body.scrollLeft;
            y = document.body.scrollTop;
        } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
            // IE6 standards compliant mode
            x = document.documentElement.scrollLeft;
            y = document.documentElement.scrollTop;
        }
        return [x, y];
    }

    function setScrollXY(x, y) {
        window.scrollTo(x, y);
    }

    function createCookie(name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else var expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function loadP(pageref) {
        x = readCookie(pageref + 'x');
        y = readCookie(pageref + 'y');
        setScrollXY(x, y)
    }

    function unloadP(pageref) {
        s = getScrollXY()
        createCookie(pageref + 'x', s[0], 0.1);
        createCookie(pageref + 'y', s[1], 0.1);
    }

</script>

</html>
