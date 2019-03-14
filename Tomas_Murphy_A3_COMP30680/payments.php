<!DOCTYPE html>
<html>

<head>
    <title>Payments</title>
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

<body class="fixed-bg" id="fixed-bg-payment" onunload="unloadP('payScroll')">


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

        <div class="row">
            <div class="col-3"></div>
            <div class="col-6"></div>
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
try{
$sql = "SELECT checkNumber, paymentDate, amount, customerNumber FROM payments";
$result = $conn->query($sql);
}
catch(Exception $e){
  echo 'Please contact the IT team, as an error has occured retrieving data from the database. State the following error Message: ' .$e->getMessage();
}
 ?>

        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div id="products">

                    <h1>Payments</h1>

                    <table id="payTable" class="output-table output-table-rounded">
                        <thead>
                            <tr>
                                <th>Search Results:</th>
                                <th>
                                   
                                        <div><input type="radio" onclick="payFunction()" id="20" name="results" value="20" checked /><label for="20">20</label></div>
                                </th>
                                <th>
                                    <div><input type="radio" onclick="payFunction()" id="40" name="results" value="40" /><label for="40">40</label></div>
                                </th>
                                <th>
                                    <div><input type="radio" onclick="payFunction()" id="60" name="results" value="60" /><label for="60">60</label></div>
               
                </th>
                </tr>
                <tr>
                    <th>Check Number</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Customer Number</th>
                </tr>
                </thead>
                <tbody>
                    <?php try{
	if ($result->num_rows > 0){
    	 while($row = $result->fetch_assoc()){
    		echo '<tr>';
    		echo'<td>' . $row["checkNumber"] . '</td>';
    			echo'<td>' . $row["paymentDate"] . '</td>';
    			echo'<td>' . $row["amount"] . '</td>';
    			$custNum = $row["customerNumber"];
    			echo "<td><form action='payments.php' method = 'POST' name='payForm' id = 'payForm'><input type='hidden' value = '$custNum' name = 'customer'><button type='submit' name='submit' value='submit'>$custNum</button></form></td>";
    		echo'</tr>';

    		}
    		}

    		else {
        trigger_error("An error has occured with the database. Please contact the IT team.", E_USER_NOTICE);
    }
}
         catch(Exception $ex){
    echo "Please contact the IT team, as an error has occured retrieving data from the database. State the following error Message: " .$e->getMessage();
}
?>

                </tbody>
                </table>
            </div>
        </div>
        <div class="col-1"></div>
    </div>

    <?php
try{
    if(isset($_POST['submit'])) {
        $cusNo = $_POST['customer'];
        $sql = "SELECT customers.phone, customers.salesRepEmployeeNumber, customers.creditLimit, payments.amount FROM customers, payments WHERE customers.customerNumber = '$cusNo' AND payments.customerNumber = '$cusNo'";

        $result = $conn->query($sql);

    
   	echo '<div>';
    echo "<table id = 'paytable' class = 'output-table output-table-pop'>";
        echo '<thead>';
               echo '<tr>';
                echo '<th></th>';
                echo '<th></th>';
 		        echo '<th></th>';
                echo '<th></th>';
                    
                 echo '</tr>';
                  echo '<tr>';
                 	 echo "<th style='font-weight: bold; font-size: 120%'>Payments</th>";
                     echo "<th style='font-weight: bold; font-size: 120%'>Phone Number</th>";
                     echo "<th style='font-weight: bold; font-size: 120%'>Sales Rep</th>";
                     echo "<th style='font-weight: bold; font-size: 120%'>Credit Limit</th>";

                 echo '</tr>';
             echo '</thead>';
             echo '<tbody>';

        try{     
    	if ($result->num_rows > 0){
    	$total = 0;
         while($row = $result->fetch_assoc()){
            echo '<tr>';
            echo'<td>' . $row["amount"] . '</td>';
            	$total += $row["amount"];
                echo'<td>' . $row["phone"] . '</td>';
                echo'<td>' . $row["salesRepEmployeeNumber"] . '</td>';
                echo'<td>' . $row["creditLimit"] . '</td>';
            echo'</tr>';
        }
            
            echo'<tr>';
            	echo"<td style='font-size: 130%; font-weight: bold;'>Total Payments Amount:</td>";
            echo	'<td></td>';
            echo	'<td></td>';
            echo	"<td>&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' onclick='hideme()'>Close this window!</button></td>";
            echo '</tr>';
            echo '<tr>';
            echo	"<td style='font-weight: bold'>" . $total . "</td>";
            echo	'<td>';
            echo	'</td>';
            echo	'<td></td>';
            echo	'<td></td>';
            echo'</tr>';
        }
                else {
                     trigger_error("An error has occured retrieving data from the database. Please contact the IT team.", E_USER_NOTICE);
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

// Error handling: http://php.net/manual/en/function.set-error-handler.php
// error handler function

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
        echo "An connecting to the database has occured, please contact the IT team for support";
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

// <!-- Pop up alerts:
// https://stackoverflow.com/questions/13851528/how-to-pop-an-alert-message-box-using-php -->
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>


</body>



<script>

// 	JS function on load:
// https://stackoverflow.com/questions/3842614/how-do-i-call-a-javascript-function-on-page-load
// Set to 20 payments by default on load
    window.onload = payFunction();

    function payFunction() {
        //        Search tr td in table:
        //https://www.w3schools.com/howto/howto_js_filter_table.asp
        //https://stackoverflow.com/questions/42451865/how-do-i-iterate-through-each-td-and-tr-in-a-table-using-javascript-or-jquery
        var table, tr, td;
        table = document.getElementById("payTable");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];

            //            Hide a row:
            //https://stackoverflow.com/questions/5440657/how-to-hide-columns-in-html-table
            //
            //https://stackoverflow.com/questions/42451865/how-do-i-iterate-through-each-td-and-tr-in-a-table-using-javascript-or-jquery


            //            Radio button checked:
            //https://stackoverflow.com/questions/25314698/show-or-hide-a-table-row-based-on-a-radio-button-value
            //
            //https://stackoverflow.com/questions/1423777/how-can-i-check-whether-a-radio-button-is-selected-with-javascript


            if (document.getElementById('20').checked) {
                for (i = 0; i < tr.length; i++) {
                    // because th tr's
                    if (i < 22) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            } else if (document.getElementById('40').checked) {
                for (i = 1; i < tr.length; i++) {
                    if (i < 42) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            } else if (document.getElementById('60').checked) {
                for (i = 1; i < tr.length; i++) {
                    if (i < 62) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }

            }
        }
    }

    function hideme() {

        document.getElementById("paytable").style.display = "none";
        loadP('payScroll');

    }

//     Remember scroll position with cookies:
// http://blog.crondesign.com/2009/09/scrollfix-remember-scroll-position-when.html


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
