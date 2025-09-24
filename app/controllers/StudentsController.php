<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: StudentsController
 * 
 * Automatically generated via CLI.
 */
class StudentsController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('StudentsModel');
        $this->call->library('pagination');

        $this->pagination->set_theme('custom');
        $this->pagination->set_custom_classes([
            'nav'    => 'flex justify-center mt-6',
            'ul'     => 'inline-flex space-x-2',
            'li'     => '',
            'a'      => 'px-3 py-1 rounded-lg border text-gray-300 hover:bg-gray-700 transition',
            'active' => 'bg-blue-600 text-white border-blue-600'
        ]);
    }

    public function index($page = 1)
    {
        $page = max(1, (int)$page);
        
        $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $allowed = [10, 25, 50, 100];
        if (!in_array($per_page, $allowed)) $per_page = 10;

        $search = $_GET['search'] ?? '';

        $total_rows = $this->StudentsModel->count_all_records($search);

        $query_params = [];
        if (!empty($search)) $query_params['search'] = $search;
        if ($per_page !== 10) $query_params['per_page'] = $per_page;

        $base_url = 'students/index';
        if (!empty($query_params)) {
            $base_url .= '?' . http_build_query($query_params);
        }

        $pagination_data = $this->pagination->initialize(
            $total_rows,
            $per_page,
            $page,
            $base_url,
            5
        );

        $data['students'] = $this->StudentsModel->get_records_with_pagination(
            $pagination_data['limit'],
            $search
        );

        $data['pagination_info'] = $pagination_data['info'];
        $data['pagination_html'] = $this->pagination->paginate();

        $data['search'] = $search;
        $data['per_page'] = $per_page;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($total_rows / $per_page);

        $this->call->view('all', $data);
    }

    public function create()
    {
        $this->call->view('create');
    }

public function store()
{
    $postData = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'email'      => trim($_POST['email'] ?? '')
    ];

    // Basic validation
    if (empty($postData['first_name']) || empty($postData['last_name']) || empty($postData['email'])) {
        $_SESSION['error'] = "All fields are required.";
        return redirect('/students/create');
    }

    // Email validation
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        return redirect('/students/create');
    }

    // Insert record
    $inserted = $this->StudentsModel->insert($postData);
if ($inserted) {
    $_SESSION['success'] = "Student added successfully.";
    header("Location: /");
    exit;  // 👈 this is critical
}
 else {
        $_SESSION['error'] = "Failed to add student.";
        return redirect('/students/create');
    }
}


public function edit($id)
{
    $student = $this->StudentsModel->find($id);
    if (!$student) {
        $_SESSION['error'] = "Student not found.";
        header('Location: /students'); // Changed from '/' to '/students'
        exit;
    }
    $data['student'] = $student;
    $this->call->view('edit', $data);
}

public function update($id)
{
    $student = $this->StudentsModel->find($id);
    if (!$student) {
        $_SESSION['error'] = "Student not found.";
        header('Location: /students'); // Changed from '/' to '/students'
        exit;
    }

    $postData = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'email'      => trim($_POST['email'] ?? '')
    ];

    // Basic validation
    if (empty($postData['first_name']) || empty($postData['last_name']) || empty($postData['email'])) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: /students/edit/{$id}");
        exit;
    }

    // Email validation
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        header("Location: /students/edit/{$id}");
        exit;
    }

    // Update record
    $updated = $this->StudentsModel->update($id, $postData);
    if ($updated) {
        $_SESSION['success'] = "Student updated successfully.";
        header('Location: /students'); // Changed from '/' to '/students'
        exit;
    } else {
        $_SESSION['error'] = "Failed to update student.";
        header("Location: /students/edit/{$id}");
        exit;
    }
}

public function delete($id)
{
    $student = $this->StudentsModel->find($id);
    if (!$student) {
        $_SESSION['error'] = "Student not found.";
        header('Location: /students'); // Changed from '/' to '/students'
        exit;
    }

    $deleted = $this->StudentsModel->delete($id);
    if ($deleted) {
        $_SESSION['success'] = "Student deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete student.";
    }
    header('Location: /students'); // Changed from '/' to '/students'
    exit;
}

function login()
{
    $this->call->view('login');
}
}