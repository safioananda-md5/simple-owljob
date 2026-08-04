<?php
// index.php
require_once 'config.php';

// Tangkap action dari AJAX, default jika tidak ada action adalah 'renderView'
$action = $_GET['action'] ?? $_POST['action'] ?? 'renderView';


// Simple Router berdasarkan nama function/method
switch ($action) {
    case 'my-task':
        myTask($pdo, 7);
        break;

    case 'simpanPimpinan':
        // simpanPimpinan($pdo);
        break;

    default:
        // Jika tidak ada request AJAX, tampilkan halaman view
        require_once 'view.php';
        break;
}

// ==========================================
// METHOD / CONTROLLER FUNCTIONS
// ==========================================

function myTask($pdo, $userId)
{
    header('Content-Type: application/json');

    try {
        // 1. Query dengan Double JOIN untuk mengambil data task + nama project
        $stmt = $pdo->prepare("
            SELECT 
                tasks.project_id,
                projects.name AS project_name,
                tasks.title, 
                tasks.description,
                DATE_FORMAT(FROM_UNIXTIME(tasks.date_modification), '%d/%m/%Y') AS date_modification
            FROM tasks 
            INNER JOIN columns ON tasks.column_id = columns.id 
            INNER JOIN projects ON tasks.project_id = projects.id 
            WHERE tasks.owner_id = ? 
              AND columns.title = 'To Do'
        ");

        $stmt->execute([$userId]);
        $rawTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Logika pengelompokan task berdasarkan project_id
        $groupedTasks = [];

        foreach ($rawTasks as $task) {
            $projectId = $task['project_id'];

            // Jika project_id belum terdaftar di array, inisialisasi header project-nya
            if (!isset($groupedTasks[$projectId])) {
                $groupedTasks[$projectId] = [
                    'project_id'   => $projectId,
                    'project_name' => $task['project_name'],
                    'tasks'        => []
                ];
            }

            // Masukkan data task ke dalam list tasks milik project tersebut
            $groupedTasks[$projectId]['tasks'][] = [
                'title'             => $task['title'],
                'description'       => $task['description'],
                'date_modification' => $task['date_modification']
            ];
        }

        // Re-index array agar menjadi array numerik yang rapi saat di-encode ke JSON
        $data = array_values($groupedTasks);

        echo json_encode([
            'status' => 'success',
            'data'   => $data
        ]);
        exit;
    } catch (PDOException $e) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Database Error: ' . $e->getMessage()
        ]);
        exit;
    }
}

// function getPimpinan($pdo)
// {
//     // Set header agar output berupa JSON
//     header('Content-Type: application/json');

//     $stmt = $pdo->query("SELECT * FROM data_pimpinans ORDER BY id ASC LIMIT 2");
//     $data = $stmt->fetchAll();

//     echo json_encode([
//         'status' => 'success',
//         'data'   => $data
//     ]);
//     exit;
// }

// function simpanPimpinan($pdo)
// {
//     header('Content-Type: application/json');

//     $nama    = $_POST['nama'] ?? '';
//     $jabatan = $_POST['jabatan'] ?? '';

//     $stmt = $pdo->prepare("INSERT INTO data_pimpinans (nama, jabatan) VALUES (?, ?)");
//     $simpan = $stmt->execute([$nama, $jabatan]);

//     if ($simpan) {
//         echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
//     }
//     exit;
// }
