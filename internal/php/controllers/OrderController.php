<?php
namespace Controllers;
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../models/order.php";
require_once __DIR__ . "/../configs/databaseConfig.php";

use Models\Order;

class OrderController
{
    public function getOrders()
    {
        header("Content-Type: application/json");

        $orders = Order::order_by_desc("id")->find_array();

        echo json_encode([
            "status" => "success",
            "data" => $orders,
        ]);
    }

    public function getOrdersById($id)
    {
        header("Content-Type: application/json");

        $order = Order::find_one($id);

        echo json_encode([
            "status" => "success",
            "data" => $order->as_array(),
        ]);
    }

    public function createOrder()
    {
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input["user_id"]) || !isset($input["total_price"])) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "Invalid",
            ]);
            return;
        }

        $newOrder = Order::create();
        $newOrder->user_id = $input["user_id"];
        $newOrder->total_price = $input["total_price"];
        $newOrder->save();

        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "Successfully created order",
            "data" => $newOrder->as_array(),
        ]);
    }

    public function updateOrderStatus($id)
    {
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents("php://input"), true);

        $order = Order::find_one($id);

        if (!$order) {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "Order not found",
            ]);
            return;
        }

        if (!isset($input["status"])) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "status_pesanan is required",
            ]);
            return;
        }

        $order->status = $input["status"];
        $order->save();

        echo json_encode([
            "status" => "success",
            "message" => "Successfully updated order status",
            "data" => $order->as_array(),
        ]);
    }

    public function deleteOrder($id)
    {
        header("Content-Type: application/json");
        $order = Order::find_one($id);

        if (!$order) {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "Order not found",
            ]);
            return;
        }

        $order->delete();

        echo json_encode([
            "status" => "success",
            "message" => "Successfully deleted order",
        ]);
    }
}
