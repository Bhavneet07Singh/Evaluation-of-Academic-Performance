<!---------------- Session starts form here ----------------------->
<?php  
	session_start();
	if (!$_SESSION["LoginStudent"])
	{
		header('location:../login/login.php');
	}
		require_once "../connection/connection.php";
?>
<!---------------- Session Ends form here ------------------------>
<?php
    function grade($obtain_marks) {

        
            if ($obtain_marks>=85) {
                $grade = "A+";
            }
            else if ($obtain_marks>=80) {
                $grade = "A";
            }
            else if ($obtain_marks>=75) {
                $grade = "B+";
            }
            else if ($obtain_marks>=70) {
                $grade = "B";
            }
            else if ($obtain_marks>=65) {
                $grade = "C+";
            }
            else if ($obtain_marks>=60) {
                $grade = "C";
            }
            else if ($obtain_marks>=55) {
                $grade = "D+";
            }
            else if ($obtain_marks>=50) {
                $grade = "D";
            }
            else {
                $grade = "F";
            }
        
        

        return $grade;
    }
?>

<?php
    function gpa($obtain_marks) {

        
            if ($obtain_marks>=80) {
                $gpa = "9.00";
            }
            else if ($obtain_marks>=75) {
                $gpa = "8.00";
            }
            else if ($obtain_marks>=70) {
                $gpa = "8.00";
            }
            else if ($obtain_marks>=65) {
                $gpa = "7.00";
            }
            else if ($obtain_marks>=60) {
                $gpa = "7.00";
            }
            else if ($obtain_marks>=55) {
                $gpa = "6.00";
            }
            else if ($obtain_marks>=50) {
                $gpa = "6.00";
            }
            else {
                $gpa = "0.00";
            }
        
        

        return $gpa;
    }
?>

    <title>Student - Transcript</title>

<?php include "../common/common-header.php"?>
    <div class="container mt-4">
        <div class="text-danger text-center m-auto">
            <img src="../Images/icbs_logo.png" alt="" width="100" height="100">
            <h4 class="text-dark mt-3">GRAPHIC ERA UNIVERSITY-GEU</h4>
            <h4 class="text-dark">DEEMED TO BE UNIVERSITY</h4>
        </div>
    </div>
    <div class="container-fluid mb-4 text-dark">
        <div class="program-info">
            <?php  
                $roll_no = $_SESSION['LoginStudent'];
                $query = "select * from student_info inner join sessions on sessions.session=student_info.session where roll_no = '$roll_no'";
                $run = mysqli_query($con, $query);
                while($row = mysqli_fetch_array($run)){ ?>
                    <h5>Student Transcript - <?php echo $row['course_code']; ?> Program</h5>
        </div>
        <div class="d-flex mt-3">
            <div>
                <h5>Student Name : <?php echo $row['first_name']. " ". $row['middle_name']. " ". $row['last_name']; ?></h5>
                <br>
                <h5>S/O : <?php echo $row['father_name']; ?></h5>
            
            
                <br>
                <h5>Student I.D # : <?php echo $row['roll_no']; ?></h5>
                <br>
                <h5>Year of Addmission : <?php echo intval($row['admission_date']) . " "; ?></h5>
            </div>
        </div>
        <?php }
        ?>
    </div>
    <div class="container-fluid table-font-for-transcript">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="SELECT * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='1' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                    
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 1</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $completed_ch = 0;
                                    $total_semester_ch = 0;
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $all_semester_quality_points = 0;
                                    $que="SELECT * FROM course_subjects WHERE  semester=1 ORDER BY semester ASC";
                                    
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                   
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "SELECT * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td colspan="4">.</td>
                                    <td colspan="2">.</td>
                                </tr>
                                <tr>
                                    <td colspan="4">.</td>
                                    <td colspan="2">.</td>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th></tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='2' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 2</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=2 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th></tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='3' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 3</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=3 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php 
                                    if($total_ch)
                                   { echo  round($total_quality_points/$total_ch, 2);}
                                   else{echo"error ch canot be zero -0";} ?></th>
                                </tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='4' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 4</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=4 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td colspan="4">.</td>
                                    <td colspan="2">.</td>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th>
                                </tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='5' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 5</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=5 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th> </tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='6' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 6</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=6 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th></tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='7' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 7</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=7 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th></tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='8' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 8</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=8 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th></tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='9' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 9</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=9 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th></tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div>
                    <section class="mt-3">
                        <div class="mt-2">
                            <table class="w-100 table-elements table-six-tr"cellpadding="2">
                                <tr class="pt-5 table-six text-white" style="height: 32px;">
                                <?php
                                    $que="select * from student_courses sc inner join sessions s on sc.session = s.session_id where sc.semester='10' and sc.roll_no='$roll_no'";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $session = $row['session_name'];
                                        
                                    }
                                ?>
                                    <th colspan="2"><div class="d-flex"><span class="mr-5">Semester - 10</span><span class="ml-5"> </span></div></th>
                                    <th>CH</th>
                                    <th>%</th>
                                    <th>G.P</th>
                                    <th>Letter</th>
                                </tr>
                                <?php
                                    $obtain_marks = "";
                                    $total_ch = 0;
                                    $quality_points = 0;
                                    $total_quality_points = 0;
                                    $que="select * from course_subjects where  semester=10 order By semester asc";
                                    $run=mysqli_query($con,$que);
                                    while ($row=mysqli_fetch_array($run)) {
                                        $gpa = "";
                                        $grade = "";
                                ?>
                                <tr>
                                    <td><?php echo $row['subject_code'] ?></td>
                                    <td><?php echo $row['subject_name'] ?></td>
                                    <td><?php echo $row['credit_hours'] ?></td>
                                    <?php
                                        $subject = $row['subject_code'];
                                        $result_query = "select * from class_result cr inner join student_courses cs on cr.subject_code = cs.subject_code and cr.roll_no=cs.roll_no where cr.subject_code='$subject' and cr.roll_no='$roll_no'";
                                        $run_result = mysqli_query($con, $result_query);
                                        while($result_row = mysqli_fetch_array($run_result)){
                                            $obtain_marks = $result_row['obtain_marks'];
                                            
                                        }
                                    ?>
                                    <td><?php echo $obtain_marks ?></td>
                                    <?php
                                        $gpa = gpa($obtain_marks); 
                                        $grade = grade($obtain_marks);
                                    ?>
                                    <td><?php echo $gpa; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <?php
                                        $total_ch = $total_ch + $row['credit_hours'];
                                        if($obtain_marks>=50){
                                            $quality_points = $gpa * $row['credit_hours'];
                                            $total_quality_points = $total_quality_points + $quality_points;
                                            $completed_ch = $completed_ch + $row['credit_hours'];
                                        }
                                    ?>
                                </tr>
                                <?php
                                $obtain_marks = "";
                                    } 
                                ?>
                                <tr>
                                    <th colspan="2">Total Semester CH</th>
                                    <?php $total_semester_ch = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="2">Total C.H for Graduation</th>
                                    <th><?php echo $total_semester_ch; ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </tr>
                                    <th colspan="2">C.H Completed</th>
                                    <th><?php echo $completed_ch ?></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4">Total CH</th>
                                    <?php $total_ch_end = $total_semester_ch + $total_ch; ?>
                                    <th><?php echo $total_ch_end; ?></th>
                                    
                                    
                                    
                                    <th colspan="2">.</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Semester GPA</th>
                                    <?php $all_semester_quality_points = $all_semester_quality_points + $total_quality_points; ?>
                                    <th colspan="2"><?php
                                    if($total_ch)
                                    { echo  round($total_quality_points/$total_ch, 2);} 
                                    else{echo" error ch cannot be zero-0";}?></th></tr>
                                </tr>
                                    <th colspan="4">CGPA</th>
                                    <th colspan="2"><?php echo round(($all_semester_quality_points/$total_semester_ch), 2) ?></th>
                                </tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row text-center font-weight-bold mb-5">
            <div class="col-xl-4">PREPARED BY</div>
            <div class="col-xl-4">DEAN</div>
            <div class="col-xl-4">CONTROLLER EXAMINATIONS</div>
        </div>
    </div>

</body>
</html>