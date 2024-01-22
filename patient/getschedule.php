<?php
session_start();
include_once '../assets/conn/dbconnect.php';
$q = $_GET['q'];
$res = mysqli_query($con,"SELECT ds.*, d.doctorFirstName as doctorFirstName, d.doctorLastName as doctorLastName, d.booking_price as booking_price, d.balance as doctor_balance FROM doctorschedule ds JOIN doctor d on d.doctorId=ds.doctorId WHERE scheduleDate='$q'");
$usersession1 = mysqli_query($con,"SELECT * FROM patient where icPatient=".$_SESSION['patientSession']);
$usersession = mysqli_fetch_array($usersession1);
if (!$res) {
die("Error running $sql: " . mysqli_error());
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if (mysqli_num_rows($res)==0) {
        echo "<div class='alert alert-danger' role='alert'>Doctor is not available at the moment. Please try again later.</div>";
        
        } else {
        echo "   <table class='table table-hover'>";
            echo " <thead>";
                echo " <tr>";
                    echo " <th>App Id</th>";
                    echo " <th>Doctor Name</th>";
                    echo " <th>Day</th>";
                    echo " <th>Date</th>";
                    echo "  <th>Start Time</th>";
                    echo "  <th>End Time</th>";
                    echo "  <th>Price</th>";
                    echo " <th>Availability</th>";
                    echo "  <th>Book Now!</th>";
                echo " </tr>";
            echo "  </thead>";
            echo "  <tbody>";
                while($row = mysqli_fetch_array($res)) {
                ?>
                <tr>
                    <?php
                    // $avail=null;
                    // $btnclick="";
                    if ($row['bookAvail']!='available') {
                    $avail="danger";
                    $btnstate="disabled";
                    $btnclick="danger";
                    } else {
                    $avail="primary";
                    $btnstate="";
                    $btnclick="primary";
                    }

                   
                    // if ($rowapp['bookAvail']!="available") {
                    // $btnstate="disabled";
                    // } else {
                    // $btnstate="";
                    // }
                    echo "<td>" . $row['scheduleId'] . "</td>";
                    echo "<td>" . $row['doctorFirstName']." ".$row['doctorLastName'] . "</td>";
                    echo "<td>" . $row['scheduleDay'] . "</td>";
                    echo "<td>" . $row['scheduleDate'] . "</td>";
                    echo "<td>" . $row['startTime'] . "</td>";
                    echo "<td>" . $row['endTime'] . "</td>";
                    echo "<td>" . $row['booking_price'] . "</td>";
                    echo "<td> <span class='label label-".$avail."'>". $row['bookAvail'] ."</span></td>";
                    if($usersession['patient_balance'] < $row['booking_price']){
                        echo "<td><a href='#' class='btn btn-".$btnclick." btn-xs' role='button' ".$btnstate." onclick='return alert(\"You dont have enough balance\")'>Book Now</a></td>";
                    } else {
                        echo "<td><a href='appointment.php?&appid=" . $row['scheduleId'] . "&scheduleDate=".$q."' class='btn btn-".$btnclick." btn-xs' role='button' ".$btnstate." onclick='return confirmBooking()'>Book Now</a></td>";
                        $usersession['patient_balance'] -= $row['booking_price'];
                        $row['doctor_balance'] += $row['booking_price'];
                    }
                    ?>
                    
                    </script>
                    <!-- ?> -->
                </tr>
                
                <?php
                }
                }
                ?>
            </tbody>
            <!-- modal start -->
            
            
            
            
            
        </body>
        <!-- <script>
            function confirmBooking() {
                alert('Are you sure you want to book this?');
            }
        </script> -->
    </html>
            
            
            
            
            
        </body>
        <script>
            function confirmBooking() {
                alert('Are you sure you want to book this?');
            }
        </script>
    </html>