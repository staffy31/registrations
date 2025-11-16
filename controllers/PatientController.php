<?php
namespace App\Controllers;

use App\Models\PatientModel;
use App\Lib\CSRF;

class PatientController {
    private $model;
    public function __construct(PatientModel $m) { $this->model = $m; }

    // API register (expects JSON)
    public function apiRegister() {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $csrf = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($input['csrf_token'] ?? '');
        if (!CSRF::check($csrf)) {
            http_response_code(403);
            echo json_encode(['status'=>'error','message'=>'Invalid CSRF token']);
            return;
        }

        $errors = [];
        if (empty($input['id'])) $errors[] = 'Patient ID is required';
        if (empty($input['given_name']) || empty($input['family_name'])) $errors[] = 'Full name is required';
        if (empty($input['gender'])) $errors[] = 'Gender is required';
        if (!empty($input['phone']) && !preg_match('/^[0-9+()\-\\s]{7,20}$/', $input['phone'])) $errors[] = 'Phone format invalid';
        if (!empty($input['birth_date']) && !preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', $input['birth_date'])) $errors[] = 'Birth date must be YYYY-MM-DD';

        if ($this->model->exists($input['id'] ?? '')) $errors[] = 'Patient with this ID already exists';

        if (!empty($errors)) {
            http_response_code(422);
            echo json_encode(['status'=>'error','message'=>$errors]);
            return;
        }

        $saved = $this->model->create($input);
        if ($saved) {
            echo json_encode(['status'=>'success','message'=>'Patient registered']);
        } else {
            http_response_code(500);
            echo json_encode(['status'=>'error','message'=>'Database error']);
        }
    }
}
