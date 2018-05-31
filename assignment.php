<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

    <h1>UQ Solar Data</h1>

    <?php

    //PHP Code Compiled By Tom Clarkson and Michael Postan
        // SETUP PHP CONNECTION
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "uqsolar";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("<h3>Connection failed: ".$conn->connect_error."</h3>");
        }
    ?>

<?php echo "This webpage is created with the aim of providing an interactive GUI for which you can browse The UQ Solar data. the UQ solar data contains information about various aspects of the project such as:";
echo "<br>";
echo "- The researchers";
echo "<br>";
echo "- The maintenance staff";
echo "<br>";
echo "- The facilities";
echo "<br>";
echo "- The assets (solar panels and batteries)";
echo "<br>";
echo "- The readings";
echo "<br>";
echo "- The maintenance log";
echo "<br>";
echo "Below a table is shown of the staff who work on the project.";
?>



    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">Staff ID</th>
            <th scope="col">Name</th>
            <th scope="col">Salary</th>
            <th scope="col">Date of Birth</th>
            <th scope="col">Gender</th>
            <th scope="col">Title</th>
            <th scope="col">Facility ID</th>
        </tr>
        </thead>
        <tbody id="staff">
        <?php
        // FILL TABLE WITH DATA ON CLICK
        if(isset($_POST["submit"])) {
            // get staff with five times higher salary than others
            $query0 = "SELECT * FROM staff";
            $result0 = mysqli_query($conn, $query0);
            // put all our results into a html table
            while ($rows = mysqli_fetch_array($result0)) {
                echo "<tr>";
                echo "<td>".$rows["ID"]."</td>";
                echo "<td>".$rows["sname"]."</td>";
                echo "<td>".$rows["salary"]."</td>";
                echo "<td>".$rows["DOB"]."</td>";
                echo "<td>".$rows["gender"]."</td>";
                echo "<td>".$rows["title"]."</td>";
                echo "<td>".$rows["fid"]."</td>";

                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <form action="" method="post">
        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Get Data" style="text-align:right;margin:10px" />
    </form>


<?php
    echo "<br>";
    echo "Functionality has been included that allows staff members to be inserted into the Table using the code below. Staff can also be deleted below via their IDs.";
    ?>

    <?php

    if(isset($_POST["Submitbutton"])) {
        if ((($_POST["operator"] == '>')and($_POST["constraintvalue"]<$_POST["salary"]))or(($_POST["operator"] == '<')and($_POST["constraintvalue"]>$_POST["salary"]))){
            $sql = "INSERT INTO staff (ID, sname, salary, DOB, gender, title, fid)
    VALUES (" . $_POST['id'] . ", '" . $_POST['sname'] . "', " . $_POST['salary'] . ", '" . $_POST['dob'] . "','" . $_POST['gender'] . "', '" . $_POST['title'] . "', " . $_POST['facilityid'] . ")";


            if (mysqli_query($conn, $sql)) {
                echo "<strong>New record created successfully</strong>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "<strong>Check constraint failed, new entry not added.</strong>";
        }
    }

    ?>


    <form action = '' method = 'post'>

        <strong> <br>Enter details for the staff member to be added <br></strong>
        ID:<br>
      <input type="text" name="id"><br>
      Staff name:<br>
      <input type="text" name="sname"><br>
        Salary:<br>
        <input type="text" name="salary"><br>

        Select a Salary constraint <br>
        <select name='operator'>
            <option value= '<'> Less than (<)</option>
            <option value= '>'> Greater than (>)</option>

        <input type="text" name="constraintvalue"><br>
        Date Of Birth:<br>
        <input type="text" name="dob"><br>
        Gender: (M or F)<br>
        <input type="text" name="gender"><br>
        Title:<br>
        <input type="text" name="title"><br>



        <?php
        $facilid = "SELECT fid FROM facility";
        $facilidresult = mysqli_query($conn, $facilid);

        echo "Select a facility <br>";
        echo "<select name='facilityid'><br>";

        while ($row = mysqli_fetch_array($facilidresult)) {
            echo '<option value="'.$row['fid'].'">'.$row['fid'].'</option>';
         echo "<br>";
        }
        ?>



        <input type = 'submit' name= 'Submitbutton' value = 'Insert Data'>
    </form>









    <?php
    $staffid = "SELECT ID FROM staff";
    $staffidresult = mysqli_query($conn, $staffid);
    echo "<form action='' method='post'>";
    echo "<strong>Choose a staff ID to Delete<br></strong>";
    echo "<select name='staffID'>";

    while ($row = mysqli_fetch_array($staffidresult)) {
        echo '<option value="'.$row['ID'].'">'.$row['ID'].'</option>';
    }
    echo "</select>";

    echo "<input type='submit' name='deletionsubmit' value='Delete the following staff' />";
    echo "</form>";


    // sql to delete a record
    if(isset($_POST["deletionsubmit"])) {

        $deleted = mysqli_real_escape_string($conn, $_POST["staffID"]);
        $sql = "DELETE FROM staff WHERE ID = $deleted";

        if (mysqli_query($conn, $sql)) {
            echo "<strong>Record deleted successfully.</strong><br>";
        } else {
            echo "<strong>Error deleting record: " . mysqli_error($conn)."</strong><br>";
        }
    }

    ?>


    <?php
    echo 'The following table shows the researcher results.';
    ?>
    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">Staff ID</th>
            <th scope="col">Supervisor</th>
        </tr>
        </thead>
        <tbody id="staff">
        <?php
        // FILL TABLE WITH DATA ON CLICK
        if(isset($_POST["submittal"])) {
            // get staff with five times higher salary than others
            $query100 = "SELECT * FROM researcher";
            $result100 = mysqli_query($conn, $query100);
            // put all our results into a html table
            while ($rows = mysqli_fetch_array($result100)) {
                echo "<tr>";
                echo "<td>".$rows["ID"]."</td>";
                echo "<td>".$rows["supervisor"]."</td>";


                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <form action="" method="post">
        <input type="submit" name="submittal" class="btn btn-primary btn-lg" value="Get Data" style="text-align:right;margin:10px" />
    </form>


    <?php
    echo 'The following table shows the names and salaries of staff who have an income five times higher than at least one other staff.';
    ?>

    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Salary</th>
        </tr>
        </thead>
        <tbody id="staff">
        <?php
        // FILL TABLE WITH DATA ON CLICK
        if(isset($_POST["submit1"])) {
            // get staff with five times higher salary than others
            $query1 = "SELECT DISTINCT S1.sname,
 S1.salary 
FROM staff S1, staff S2
 WHERE S1.salary> 5*S2.salary"	;
            $result1 = mysqli_query($conn, $query1);
            // put all our results into a html table
            while ($rows = mysqli_fetch_array($result1)) {
                echo "<tr>";
                echo "<td>".$rows["sname"]."</td>";
                echo "<td>".$rows["salary"]."</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <form action="" method="post">
        <input type="submit" name="submit1" class="btn btn-primary btn-lg" value="Get Data" style="text-align:right;margin:10px" />
    </form>

    <?php
    echo 'The following table shows an aggregate value of power for each day as well as the count of measurements taken that day';
    ?>

    <form action = '', method = 'post'>

        <strong>Select an aggregate function:</strong> <br>
    <select name='aggregator'>
    <option value= 'MAX'> Maximum</option>
     <option value= 'MIN'> Minimum</option>
     <option value= 'AVG'> Average</option>

        <input type="submit" name="aggregationsubmit" class="btn btn-primary btn-lg" value="Select Aggregator" style="text-align:right;margin:10px" />
    </form>

    <?php
    $colname = 'Aggregated Variable';
    if(isset($_POST["aggregationsubmit"])and$_POST["aggregator"]=='MAX') {
        $colname = 'Maximum Power (kw)';
    }else if (isset($_POST["aggregationsubmit"])and$_POST["aggregator"]=='MIN') {
        $colname = 'Minimum Power (kw)';
    }else if (isset($_POST["aggregationsubmit"])and$_POST["aggregator"]=='AVG') {
        $colname = 'Average Power (kw)';
    }

    ?>


    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col"><?php echo $colname; ?></th>
            <th scope="col">Measurements per day</th>
        </tr>
        </thead>
        <tbody id="solarreading">
        <?php
        // FILL TABLE WITH DATA ON CLICK
        if(isset($_POST["aggregationsubmit"])) {
            // get staff with five times higher salary than others
            $aggregatedquery = "SELECT sdate, ". $_POST['aggregator']."(powerw) as power, count(*)
FROM solarreading
GROUP BY sdate";
            $aggregatedresult = mysqli_query($conn, $aggregatedquery);
            // put all our results into a html table
            while ($rows = mysqli_fetch_array($aggregatedresult)) {
                echo "<tr>";
                echo "<td>".$rows["sdate"]."</td>";
                echo "<td>".$rows["power"]."</td>";
                echo "<td>".$rows["count(*)"]."</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>





    <?php
    echo 'The following table presents an aggregated value of power for a day in which the average power for that day was greater than the maximum power output recorded on any other day';

    ?>

    <form action = '', method = 'post'>

        <strong>Select an aggregate function:</strong> <br>
        <select name='aggregator2'>
            <option value= 'MAX'> Maximum</option>
            <option value= 'MIN'> Minimum</option>
            <option value= 'AVG'> Average</option>

            <input type="submit" name="aggregationsubmit2" class="btn btn-primary btn-lg" value="Select Aggregator" style="text-align:right;margin:10px" />
    </form>




    <?php
    $colname2 = 'Aggregated Variable';
    if(isset($_POST["aggregationsubmit2"])and$_POST["aggregator2"]=='MAX') {
        $colname2 = 'Maximum Power (kw)';
    }else if (isset($_POST["aggregationsubmit2"])and$_POST["aggregator2"]=='MIN') {
        $colname2 = 'Minimum Power (kw)';
    }else if (isset($_POST["aggregationsubmit2"])and$_POST["aggregator2"]=='AVG') {
        $colname2 = 'Average Power (kw)';
    }

    ?>
    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col"><?php echo $colname2; ?></th>
        </tr>
        </thead>
        <tbody id="solarreading">
        <?php
        // FILL TABLE WITH DATA ON CLICK
        if(isset($_POST["aggregationsubmit2"])) {
        // get staff with five times higher salary than others
        $aggregatedquery = "SELECT sdate, ". $_POST['aggregator2']."(powerw) as power
FROM solarreading
GROUP BY sdate 
HAVING AVG(powerw)> ANY (SELECT MAX(powerw) FROM solarreading GROUP BY sdate)";
        $aggregatedresult = mysqli_query($conn, $aggregatedquery);
        // put all our results into a html table
        while ($rows = mysqli_fetch_array($aggregatedresult)) {
        echo "<tr>";
        echo "<td>".$rows["sdate"]."</td>";
        echo "<td>".$rows["power"]."</td>";
        echo "</tr>";
        }
        }
        ?>
        </tbody>
    </table>


    <?php
    echo 'The following table shows  only those staff members who supervise all of maintenance.';
    ?>

    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">ID</th>
        </tr>
        </thead>
        <tbody id="staff">
        <?php
        // FILL TABLE WITH DATA ON CLICK
        if(isset($_POST["submit4"])) {
            // get staff with five times higher salary than others
            $divisionquery = "SELECT S1.sname, S1.ID
FROM staff S1
WHERE NOT EXISTS (SELECT M1.supervisor FROM maintenance M1 WHERE NOT EXISTS (SELECT M2.supervisor FROM maintenance M2 WHERE M2.supervisor = S1.ID))
"	;
            $divisionresult = mysqli_query($conn, $divisionquery);
            // put all our results into a html table
            while ($rows = mysqli_fetch_array($divisionresult)) {
                echo "<tr>";
                echo "<td>".$rows["sname"]."</td>";
                echo "<td>".$rows["ID"]."</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <form action="" method="post">
        <input type="submit" name="submit4" class="btn btn-primary btn-lg" value="Get Data" style="text-align:right;margin:10px" />
    </form>

    <?php
    echo 'The following table shows the joint of all solar panels and their readings.';
    ?>

    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">Panel Id</th>
            <th scope="col">Maximum Rated Output (kw)</th>
            <th scope="col">Observed Output (kw)</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
        </tr>
        </thead>
        <tbody id="staff">
        <?php
        // FILL TABLE WITH DATA ON CLICK
        if(isset($_POST["submit5"])) {
            // get staff with five times higher salary than others
            $joinquery = "SELECT P.pid, P.maxoutputw, R.powerw, R.sdate, R.stime
FROM panel P, solarreading R
WHERE P.pid = R.pid";
            $joinresult = mysqli_query($conn, $joinquery);
            // put all our results into a html table
            while ($rows = mysqli_fetch_array($joinresult)) {
                echo "<tr>";
                echo "<td>".$rows["pid"]."</td>";
                echo "<td>".$rows["maxoutputw"]."</td>";
                echo "<td>".$rows["powerw"]."</td>";
                echo "<td>".$rows["sdate"]."</td>";
                echo "<td>".$rows["stime"]."</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <form action="" method="post">
        <input type="submit" name="submit5" class="btn btn-primary btn-lg" value="Get Data" style="text-align:right;margin:10px" />
    </form>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>