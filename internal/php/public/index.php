<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../configs/databaseConfig.php";

header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$uriSegments = explode("/", trim($uri, "/"));
if ($uriSegments[0] !== "api") {
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "Not Found. Please use the /api prefix.",
    ]);
    exit();
<<<<<<< HEAD
=======
} elseif ($uriSegments[0] === "dashboard") {
    require_once __DIR__ . "/../dashboard/index.php";
    exit();
>>>>>>> 86532a0 (feat(frontend): make crud frontend)
}
$resource = $uriSegments[1] ?? null;
$id = $uriSegments[2] ?? null;

if ($resource === "order") {
    $orderController = new \Controllers\OrderController();

    switch ($method) {
        case "GET":
            if ($id) {
                $orderController->getOrdersById($id);
            } else {
                $orderController->getOrders();
            }
            break;

        case "POST":
            if (!$id) {
                $orderController->createOrder();
            }
            break;

        case "PUT":
            if ($id) {
                $orderController->updateOrderStatus($id);
            } else {
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "Order ID is required for update.",
                ]);
            }
            break;

        case "DELETE":
            if ($id) {
                $orderController->deleteOrder($id);
            } else {
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "Order ID is required for deletion.",
                ]);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode([
                "status" => "error",
                "message" => "Method Not Allowed.",
            ]);
            break;
    }
} elseif ($resource === "user") {
    $userController = new \Controllers\UserController();
    switch ($method) {
        case "GET":
            if ($id) {
                $userController->getUserById($id);
            } else {
                $userController->getUsers();
            }
            break;
        case "POST":
            if (!$id) {
                $userController->createUser();
            }
            break;
        case "PUT":
            if ($id) {
                $userController->updateUser($id);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "User ID is required",
                ]);
            }
            break;
        case "DELETE":
            if ($id) {
                $userController->deleteUser($id);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "User ID is required",
                ]);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode([
                "status" => "error",
                "message" => "Method Not Allowed",
            ]);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "Endpoint not found.",
    ]);
}
