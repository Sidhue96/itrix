<?php
    session_start();
    if(isset($_POST['submit'])){
        $number = $_POST['number'];
        $_SESSION['number']=$number;
        $workshop = $_POST['workshop'];
        
        try{
            $conn = new Mongo('localhost');
            $db = $conn->itrix;
            $collection_users=$db->users;
            $doc = $collection_users->findOne(array("mobile" => $number));
            if(empty($doc)){
                                header("Location: registration.html");
                                exit("redirected");
                            }
            $collection = $db->workshops;
            $doc = array(
                "mobile" => $number,
                "workshop" => $workshop
            );
            $collection->insert($doc, array("safe" => true));
            $conn->close();
            header("Location: workshop_registered.php");
        }
        catch(MongoConnectionException $e){
            die('Error connecting to MongoDB server');
        }
        catch(MongoException $e){
            die('Error: '.$e->getMessage());
        }
    }
?>