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
                <h2 style="color:red">Registered Workshops</h2>
                <?php
                    session_start();
                    if(isset($_POST['delete'])){
                        $id = $_POST['delete_rec_id'];
                        try{
                        $conn = new Mongo('localhost');
                        $db = $conn->itrix;
                        $collection = $db->workshops;
                        $collection->remove( array( '_id' => new MongoID($id) ) );
                        }
                        catch(MongoException $mongoException){
                            print $mongoException;
                            exit;
                        }
                    }
                    if(!isset($_SESSION['number'])){
                       header("Location: index.html");
                       exit("returned");
                    }
                    else{
                        $number = $_SESSION['number'];
                        try{
                            $conn = new Mongo('localhost');
                            $db = $conn->itrix;
                            $collection = $db->users;
                            $cursor = $collection->find(array("mobile" => $number));
                            foreach ( $cursor as $document ){
                                echo "<h3 style='font-family:verdana;'>Name :  ".$document["fname"];
                                echo "&nbsp";
                                echo $document["lname"]."</h3>";
                                echo "<h3 style='font-family:verdana;'>Email : ".$document["email"]."<h3>";
                                echo "<h3 style='font-family:verdana;'>College : ".$document["clg"]."<h3>";
                                echo "<h3 style='font-family:verdana;'>Department : ".$document["dept"]."<h3>";
                                echo "<h3 style='font-family:verdana;'>Year : ".$document["year"]."<h3>";
                                echo "<br>";
                                echo "<h3 style='font-family:verdana;'>Workshops :";
                                echo "<br>";
                            }
                            $collection = $db->workshops;
                            $cursor = $collection->find(array("mobile" => $number));
                            foreach ( $cursor as $document ){
                                echo $document["workshop"];
                                $id = $document["_id"];
                                ?>
           
                                <form id="delete" method="post" action="">
                                    <input type="hidden" name="delete_rec_id" value="<?php print $id; ?>" /> 
                                    <input type="submit" name="delete" value="Delete!" style="background-color:white; 
                                    border: solid 1px #FF0000;
                      height: 30px; 
                      font-size:18px; 
                       vertical-align:9px;color:#FF0000"  placeholder="Email" required/>    

                                </form>
                            <?php
                                echo "<br>";
                            }
                            echo "</h3>";
                            echo"<br><br>";
                            echo"<a href='workshop.html'>Register for another workshop</a>";
                            echo"<br><br>";
                            echo"<a href='/itrix/'>Home</a>";
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
