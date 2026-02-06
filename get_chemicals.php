<?php
// get_chemicals.php - Final Version (Support 118 Elements, No Formula)
header('Content-Type: application/json');
ini_set('display_errors', 0); // ปิด Error หน้าเว็บ (ส่งเป็น JSON แทน)
error_reporting(E_ALL);

require_once 'db.php'; 

$response = [];

try {
    // ดึง id, name และ type เพื่อมาจัดกลุ่มแสดงผลสวยๆ
    $sql = "SELECT id, name, type FROM chemicals ORDER BY id ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            // ตกแต่งชื่อให้ดูง่ายขึ้น
            $display_text = $row['name'];
            
            // ถ้าเป็นธาตุ ให้วงเล็บประเภทไว้หน่อย (เช่น Metal, Gas)
            if (!empty($row['type'])) {
                $display_text .= " (" . ucfirst($row['type']) . ")";
            }

            $response[] = [
                'value' => (string)$row['id'],
                'text' => $display_text
            ];
        }
    } else {
        // กรณีไม่มีข้อมูล (ไม่ควรเกิดขึ้นถ้าลง SQL แล้ว)
        $response[] = ['value' => '', 'text' => 'ไม่พบข้อมูลสารเคมี'];
    }
    
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database Error: " . $e->getMessage()]);
}

if (isset($conn)) $conn->close();
?>