<?php
class StaffController {

    public function liste() {
        // Logic to fetch staff list from the database
        $staffs = []; // Replace with actual data fetching logic
        $model = new StaffModel();
        $staffs = $model->getAllStaffs();
        // Render the view
        require __DIR__ . '/../views/staff/liste.php';
    }
    public function edit() {
        $options = require __DIR__ . '/../config/options.php';
        // Logic to fetch staff details for editing
        $staff = null; // Replace with actual data fetching logic
        if (isset($_GET['id'])) {
            $model = new StaffModel();
            $staff = $model->getStaffById($_GET['id']);
        }
        // Render the view
        require __DIR__ . '/../views/staff/edit.php';
    }
    public function create() {
        $options = require __DIR__ . '/../config/options.php';
        // Render the view
        require __DIR__ . '/../views/staff/create.php';
    }
    public function disable() {
        // Logic to disable a staff member
        if (isset($_GET['id'])) {
            $model = new StaffModel();
            $model->disableStaff($_GET['id']);
        }
        // Redirect back to the staff list
        header('Location: ' . BASE_URL . '/staff/liste');
        exit;
    }
    public function store() {
        $message = '';
        // Logic to store new staff details in the database
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $data = [
            // Validate and sanitize input data
            'nom'=> $_POST['nom']??'',
            'prenom' => $_POST['prenom']??'',
            'middle_name' => $_POST['middle_name']??'', 
            'gender' => $_POST['gender']??'',
            'dob' => !empty($_POST['dob']) ? $_POST['dob'] : NULL,
            'status' => $_POST['status']??'',
            'departement' => $_POST['departement']??'',
            'service' => $_POST['service']??'',
            'poste' => $_POST['poste']??'',
            'tel1' => $_POST['tel1']??'',
            'tel2' => $_POST['tel2']??'',
            'adresse_l1' => $_POST['adresse_l1']??'',
            'adresse_l2' => $_POST['adresse_l2']??'',
            'code_postal' => $_POST['code_postal']??'',
            'ville' => $_POST['ville']??''
            ];
            // Store the new staff details in the database
            $model = new StaffModel();
            $pid = $model->createStaff($data);
            if ($pid) {
                $_SESSION['message'] = "✅ Staff created successfully.";
                header("Location: /staff/edit/?id=" . $pid);
                exit;
            } else {
                $_SESSION['message'] = "❌ Failed to create staff.";
                header("Location: /staff/create");
                exit;
            }
            header("Location: /staff/edit/?id=" . $pid);
        }    
    }
    public function update() {
        $message = '';
        // Logic to update staff details in the database
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $data = [
            // Validate and sanitize input data
            'id' => $_POST['id']?? 0,
            'nom'=> $_POST['nom']??'',
            'prenom' => $_POST['prenom']??'',
            'middle_name' => $_POST['middle_name']??'',
            'gender' => $_POST['gender']??'',
            'dob' => !empty($_POST['dob']) ? $_POST['dob'] : NULL,         
            'status' => $_POST['status']??'',
            'departement' => $_POST['departement']??'',       
            'service' => $_POST['service']??'',
            'poste' => $_POST['poste']??'',
            'tel1' => $_POST['tel1']??'',
            'tel2' => $_POST['tel2']??'', 
            'adresse_l1' => $_POST['adresse_l1']??'',
            'adresse_l2' => $_POST['adresse_l2']??'',
            'code_postal' => $_POST['code_postal']??'',
            'ville' => $_POST['ville']??''
         ];
            // Update the staff details in the database
            $model = new StaffModel();
            $success = $model->updateStaff($data);
            if ($success) {
                $_SESSION['message'] = "✅ Staff details updated successfully.";
            } else {
                $_SESSION['message'] = "❌ Failed to update staff details.";
            }
            header("Location: /staff/edit/?id=" . $data['id']);
            exit;
        }
    }
}