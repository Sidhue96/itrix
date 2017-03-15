<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>ITRIX</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS: You can use this stylesheet to override any Bootstrap styles and/or apply your own styles -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom Fonts from Google -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    
    
</head>

<body>
	<!-- Header -->
    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <?php
                    session_start();
                    if(isset($_POST['submit'])){
                        $number=$_POST['number'];
                        $_SESSION['number']=$number;
                        try{
                            $conn = new Mongo('localhost');
                            $db = $conn->itrix;
                            $collection = $db->workshops;
                            $doc = $collection->findOne(array("mobile" => $number));
                            if(!empty($doc)){
                                header("Location: workshop_registered.php");
                                exit("redirected");
                            }
                            $collection = $db->users;
                            $doc = $collection->findOne(array("mobile" => $number));
                            if(!empty($doc)){
                                header("Location: workshop.html");
                            }
                            else{
                                header("Location: registration.html");
                            }
                            $conn->close();
                        }
                        catch(MongoConnectionException $e){
                            die('Error connecting to MongoDB server');
                        }
                        catch(MongoException $e){
                            die('Error: '.$e->getMessage());
                        }
                    }
                ?>
             </div>
        </div>
    </header>
    <!-- jQuery -->
    <script src="js/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    
    <!-- Custom Javascript -->
    <script src="js/custom.js"></script>

</body>

</html>
