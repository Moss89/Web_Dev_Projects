<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	    <!--    Bootstrap grid system:
    https://www.w3schools.com/bootstrap4/bootstrap_grid_system.asp
    -->
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/styles/styles.css">
	<!-- https://fonts.google.com/ -->
	<link href="https://fonts.googleapis.com/css?family=Karma" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lobster+Two" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=News+Cycle" rel="stylesheet">
</head>
<body class = "fixed-bg" id = "fixed-bg-home">

<div class="container-fluid">

    <div class="row">
        <div class="col-3">
        	<!-- Logo: https://preview.freelogodesign.org/?lang=en&name=Classic%20Models%20Wexford%20&logo=31dff187-0b90-4502-a14f-d34961fddadd -->
        	<a target = "_blank" href="https://goo.gl/maps/PXqrnEHMdv92"><img class = "logo" src ="./images/logo.png"></a>
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
try
{
$sql = "SELECT productLine, textDescription FROM productlines";
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
 
    <h1>Our Product Line!</h1>

        <table class = "output-table output-table-rounded" >
            <thead>
                 <tr>
                     <th id = "row1">Product Line</th>
                    <th id = "row2">Description</th>
                </tr>
            </thead>
            <tbody>
<?php try {
		if ($result->num_rows > 0){
    	 	while($row = $result->fetch_assoc()){ 
    		echo'<tr>';
    		echo'<td id = "td-large">' .$row["productLine"] . '</td>';
    		echo'<td>' . $row["textDescription"] . '</td>';
    		echo'</tr>';
    	}
    }
    else {
    	trigger_error("An error retrieving data from the database has occurred, please contact the IT team for support", E_USER_NOTICE);
    
    }
}
    	 catch(Exception $ex){
	echo 'Please contact the IT team, as an error has occured retrieving data from the database. State the following error Message: ' .$ex->getMessage();
}
?>
           </tbody>
        </table>
        <?php $conn->close();?>
    </div>
</div>
<div class="col-1"></div>
</div>


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
// error handler function
// Error handling: http://php.net/manual/en/function.set-error-handler.php
// Deal with a variety of errors
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
//    Show errors in a pop up box
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>

</body>
<script>
	
</script>
</html>