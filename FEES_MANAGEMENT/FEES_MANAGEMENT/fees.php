<?php
// ===== SESSION CHECK =====
session_start();

// ===== LOGOUT / EXIT HANDLER =====
if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ===== INCLUDE DATABASE =====
require 'db2.php';

$message  = "";
$msg_type = "";
$records  = [];

// ===================================================
// SAVE DATA
// ===================================================
if (isset($_POST['save'])) {
    $sname   = mysqli_real_escape_string($conn2, trim($_POST['student_name']));
    $sid     = mysqli_real_escape_string($conn2, trim($_POST['student_id']));
    $ayear   = mysqli_real_escape_string($conn2, trim($_POST['academic_year']));
    $ncours  = intval($_POST['no_of_courses']);
    $tcred   = intval($_POST['total_credits']);
    $apcred  = floatval($_POST['amount_per_credit']);
    $regfees = floatval($_POST['registration_fees']);
    $finproj = floatval($_POST['final_project']);
    $gradfee = floatval($_POST['graduation_fees']);
    $totfees = floatval($_POST['total_fees']);

    // Basic validation
    if (empty($sname) || empty($sid)) {
        $message  = "Student Name and Student ID are required!";
        $msg_type = "error";
    } else {
        $sql = "INSERT INTO Fees2026
                (student_name, student_id, academic_year, no_of_courses,
                 total_credits, amount_per_credit, registration_fees,
                 final_project, graduation_fees, total_fees)
                VALUES
                ('$sname','$sid','$ayear',$ncours,$tcred,$apcred,$regfees,$finproj,$gradfee,$totfees)";

        if (mysqli_query($conn2, $sql)) {
            $message  = "✅ Data saved successfully!";
            $msg_type = "success";
        } else {
            $message  = "❌ Error saving: " . mysqli_error($conn2);
            $msg_type = "error";
        }
    }
}

// ===================================================
// RETRIEVE DATA (all records)
// ===================================================
if (isset($_POST['retrieve'])) {
    $result = mysqli_query($conn2, "SELECT * FROM Fees2026 ORDER BY id DESC");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
        }
        if (count($records) == 0) {
            $message  = "⚠️ No records found in the database.";
            $msg_type = "error";
        } else {
            $message  = "✅ " . count($records) . " record(s) retrieved.";
            $msg_type = "success";
        }
    }
}

// ===================================================
// DISPLAY (only first 4 records)
// ===================================================
if (isset($_POST['display'])) {
    $result = mysqli_query($conn2, "SELECT * FROM Fees2026 ORDER BY id DESC LIMIT 4");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
        }
        if (count($records) == 0) {
            $message  = "⚠️ No records found.";
            $msg_type = "error";
        } else {
            $message  = "✅ Showing latest " . count($records) . " record(s).";
            $msg_type = "success";
        }
    }
}

// ===================================================
// UPDATE FEES (by student_id)
// ===================================================
if (isset($_POST['update'])) {
    $sid     = mysqli_real_escape_string($conn2, trim($_POST['student_id']));
    $totfees = floatval($_POST['total_fees']);

    if (empty($sid)) {
        $message  = "❌ Enter a Student ID to update!";
        $msg_type = "error";
    } else {
        $sql = "UPDATE Fees2026 SET total_fees='$totfees' WHERE student_id='$sid'";
        if (mysqli_query($conn2, $sql)) {
            if (mysqli_affected_rows($conn2) > 0) {
                $message  = "✅ Fees updated successfully for Student ID: $sid";
                $msg_type = "success";
            } else {
                $message  = "⚠️ No record found with Student ID: $sid";
                $msg_type = "error";
            }
        } else {
            $message  = "❌ Error updating: " . mysqli_error($conn2);
            $msg_type = "error";
        }
    }
}

// ===================================================
// DELETE (by student_id — safer than deleting ALL)
// ===================================================
if (isset($_POST['delete'])) {
    $sid = mysqli_real_escape_string($conn2, trim($_POST['student_id']));

    if (empty($sid)) {
        // Delete ALL records
        if (mysqli_query($conn2, "DELETE FROM Fees2026")) {
            $message  = "✅ All records deleted!";
            $msg_type = "success";
        } else {
            $message  = "❌ Error deleting: " . mysqli_error($conn2);
            $msg_type = "error";
        }
    } else {
        // Delete specific student
        $sql = "DELETE FROM Fees2026 WHERE student_id='$sid'";
        if (mysqli_query($conn2, $sql)) {
            if (mysqli_affected_rows($conn2) > 0) {
                $message  = "✅ Record deleted for Student ID: $sid";
                $msg_type = "success";
            } else {
                $message  = "⚠️ No record found with Student ID: $sid";
                $msg_type = "error";
            }
        } else {
            $message  = "❌ Error deleting: " . mysqli_error($conn2);
            $msg_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AUCA Fees Management System</title>
    <link rel="stylesheet" href="fees.css">
</head>
<body>

<!-- NAVIGATION BAR -->
<div class="navbar">
    <a href="#">Home</a>
    <a href="#">About</a>
    <a href="#">Admissions</a>
    <a href="#">Academics</a>
    <a href="#">Media Center</a>
    <a href="#">Research</a>
    <a href="#">AUCA Alumni</a>
    <a href="fees.php?logout=1" style="float:right; background:#c0392b;">
        Logout (<?php echo $_SESSION['username']; ?>)
    </a>
</div>

<!-- FORM wraps everything so all buttons submit correctly -->
<form method="POST" action="fees.php" id="feesForm">

<div class="main-wrapper">

    <!-- System Title -->
    <div class="system-title">
        ADVENTIST UNIVERSITY OF CENTRAL AFRICA STUDENTS FEES MANAGEMENT SYSTEM
    </div>

    <!-- Message Display -->
    <?php if ($message): ?>
        <div class="<?php echo $msg_type == 'success' ? 'msg-success' : 'msg-error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- CONTENT AREA -->
    <div class="content-area">

        <!-- LEFT: Input Fields -->
        <div class="left-col">

            <div class="form-row">
                <label>STUDENT NAMES:</label>
                <input type="text" name="student_name" id="student_name">
            </div>

            <div class="form-row">
                <label>STUDENT-ID:</label>
                <input type="text" name="student_id" id="student_id">
            </div>

            <div class="form-row">
                <label>ACADEMIC YEAR:</label>
                <input type="text" name="academic_year" id="academic_year">
            </div>

            <div class="form-row">
                <label>NO OF COURSES:</label>
                <input type="number" name="no_of_courses" id="no_of_courses" value="0" min="0">
            </div>

            <div class="form-row">
                <label>TOTAL CREDITS:</label>
                <input type="number" name="total_credits" id="total_credits" value="0" min="0">
            </div>

            <div class="form-row">
                <label>AMOUNT PER CREDIT:</label>
                <input type="number" name="amount_per_credit" id="amount_per_credit" value="0" min="0">
            </div>

            <div class="form-row">
                <label>REGISTRATION FEES:</label>
                <input type="number" name="registration_fees" id="registration_fees" value="0" min="0">
            </div>

            <div class="form-row">
                <label>FINAL PROJECT:</label>
                <input type="number" name="final_project" id="final_project" value="0" min="0">
            </div>

            <div class="form-row">
                <label>GRADUATION FEES:</label>
                <input type="number" name="graduation_fees" id="graduation_fees" value="0" min="0">
            </div>

            <!-- Calculate Total Fees -->
            <div class="calc-row">
                <input type="button" value="CALCULATE TOTAL FEES" onclick="calculateFees()">
                <input type="text" name="total_fees" id="total_fees" readonly style="width:90px;">
            </div>

        </div>

        <!-- RIGHT: Records Display Area -->
        <div class="right-col">
            <?php if (count($records) > 0): ?>
                <table class="results-table">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Std-ID</th>
                        <th>Year</th>
                        <th>Courses</th>
                        <th>Credits</th>
                        <th>Amt/Cr</th>
                        <th>Reg Fee</th>
                        <th>Final Proj</th>
                        <th>Grad Fee</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($records as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['academic_year']); ?></td>
                        <td><?php echo $row['no_of_courses']; ?></td>
                        <td><?php echo $row['total_credits']; ?></td>
                        <td><?php echo $row['amount_per_credit']; ?></td>
                        <td><?php echo $row['registration_fees']; ?></td>
                        <td><?php echo $row['final_project']; ?></td>
                        <td><?php echo $row['graduation_fees']; ?></td>
                        <td><strong><?php echo $row['total_fees']; ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p style="padding:10px; color:#555; font-size:11px;">
                    Records will appear here after clicking RETRIEVE DATA or DISPLAY.
                </p>
            <?php endif; ?>
        </div>

    </div>

    <!-- TOP ACTION BUTTONS -->
    <div style="padding:0 10px 5px; display:flex; justify-content:flex-end; gap:5px;">
        <input type="submit" name="update"  value="UPDATE FEES">
        <input type="submit" name="delete"  value="DELETE">
        <input type="submit" name="display" value="DISPLAY">
    </div>

    <!-- BOTTOM BUTTONS -->
    <div class="btn-section">
        <input type="submit" name="save"     value="SAVE DATA">
        <input type="submit" name="retrieve" value="RETRIEVE DATA">
        <input type="button" value="CANCEL"  onclick="cancelForm()">
        <input type="button" value="PRINT"   onclick="window.print()">
        <input type="button" value="EXIT"    onclick="exitSystem()">
    </div>

    <!-- Footer -->
    <div class="footer">
        Copyright &copy; 2024 Adventist University of Central Africa. All Rights Reserved.
    </div>

</div>
</form>

<!-- JAVASCRIPT -->
<script>
    // CALCULATE TOTAL FEES
    function calculateFees() {
        var credits   = parseFloat(document.getElementById('total_credits').value)      || 0;
        var amtPerCr  = parseFloat(document.getElementById('amount_per_credit').value)  || 0;
        var regFees   = parseFloat(document.getElementById('registration_fees').value)   || 0;
        var finalProj = parseFloat(document.getElementById('final_project').value)       || 0;
        var gradFees  = parseFloat(document.getElementById('graduation_fees').value)     || 0;

        // Formula: (Total Credits x Amount per Credit) + Registration + Final Project + Graduation
        var total = (credits * amtPerCr) + regFees + finalProj + gradFees;
        document.getElementById('total_fees').value = total.toFixed(2);
    }

    // EXIT - logout and redirect to login
    function exitSystem() {
        if (confirm("Are you sure you want to exit the system?")) {
            window.location.href = "fees.php?logout=1";
        }
    }

    // CANCEL - clear all input fields
    function cancelForm() {
        document.getElementById('student_name').value      = '';
        document.getElementById('student_id').value        = '';
        document.getElementById('academic_year').value     = '';
        document.getElementById('no_of_courses').value     = '0';
        document.getElementById('total_credits').value     = '0';
        document.getElementById('amount_per_credit').value = '0';
        document.getElementById('registration_fees').value = '0';
        document.getElementById('final_project').value     = '0';
        document.getElementById('graduation_fees').value   = '0';
        document.getElementById('total_fees').value        = '';
    }
</script>

</body>
</html>
