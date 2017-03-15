<?php
    if(isset($_POST['submit'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $number = $_POST['number'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $clg = $_POST['clg'];
        $dept = $_POST['dept'];
        $year = $_POST['year'];
        
        try{
            $conn = new Mongo('localhost');
            $db = $conn->itrix;
            $collection = $db->users;
            $doc = array(
                "fname" => $fname,
                "lname" => $lname,
                "mobile" => $number,
                "gender" => $gender,
                "email" => $email,
                "clg" => $clg,
                "dept" => $dept,
                "year" => $year
            );
            $collection->insert($doc, array("safe" => true));
            $conn->close();
            header("Location: workshop.html");
        }
        catch(MongoConnectionException $e){
            die('Error connecting to MongoDB server');
        }
        catch(MongoException $e){
            die('Error: '.$e->getMessage());
        }
    }
?>