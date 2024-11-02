<?php

include __DIR__ . '/model/model_patients.php';
include __DIR__ . '/function.php';

$error = "";
$firstName = "";
$lastName = "";
$married = "";
$birthDate = "";

if (isPostRequest()) {
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $married = filter_input(INPUT_POST, 'married'); 
    $birthDate = filter_input(INPUT_POST, 'birthDate');

    if ($firstName == "") $error .= "<li>Please provide patient's first name</li>";
    if ($lastName == "") $error .= "<li>Please provide patient's last name</li>";
    if ($married == "") $error .= "<li>Please select marital status</li>"; 
    if ($birthDate == "") $error .= "<li>Please provide a valid birth date</li>";

    if ($error == "") {
        // Convert married value to integer (1 or 0) before adding to database
        $marriedValue = ($married === 'Yes') ? 1 : 0;
        addPatient($firstName, $lastName, $marriedValue, $birthDate);
        header('Location: view_patients.php');
        exit();
    }
}
?>

<div class="container">
    <div class="col-sm-12">
        <a class='mar12' href="view_patients.php">Back to View All Patients</a>
        <h2 class='mar12'>Add Patient</h2>
        <form name="patients" method="post">
            <?php if ($error != ""): ?>
            <div class="error">
                <p>Please fix the following and resubmit:</p>
                <ul style="color: red;">
                    <?php echo $error; ?>
                </ul>
            </div>
            <?php endif; ?>
            <div class="wrapper">
                <div class="form-group">
                    <div class="label">
                        <label for="firstName" style="color: black;">First Name:</label>
                    </div>
                    <div>
                        <input type="text" id="firstName" name="firstName" class="form-control" value="<?= $firstName; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="lastName" style="color: black;">Last Name:</label>
                    </div>
                    <div>
                        <input type="text" id="lastName" name="lastName" class="form-control" value="<?= $lastName; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="married" style="color: black;">Is the patient married?</label>
                    </div>
                    <div>
                        <select id="married" name="married" class="form-control">
                            <option value="">Select...</option>
                            <option value="Yes" <?= ($married === 'Yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="No" <?= ($married === 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="birthDate" style="color: black;">Birth Date:</label>
                    </div>
                    <div>
                        <input type="date" id="birthDate" name="birthDate" class="form-control" value="<?= $birthDate; ?>" />
                    </div>
                </div>
                <div>&nbsp;</div>
                <div>
                    <input class="btn btn-success" type="submit" name="storePatient" value="Add Patient Information" />
                </div>
            </div>
        </form>
        <div>
            <a class="btn btn-warning" href="view_patients.php">Cancel</a> 
        </div>
    </div>
</div>

