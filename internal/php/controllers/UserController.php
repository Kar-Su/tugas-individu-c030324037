<?php
namespace Controllers;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../configs/databaseConfig.php";

use Models\User;

class UserController
{
    public function getUsers()
    {
        header("Content-Type: application/json");

        $users = User::order_by_desc("id")->find_array();

        foreach ($users as &$user) {
            unset($user["password"]);
        }

        echo json_encode([
            "status" => "success",
            "data" => $users,
        ]);
    }

    public function getUserById($id)
    {
        header("Content-Type: application/json");

        $user = User::find_one($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "User not found.",
            ]);
            return;
        }

        $responseData = $user->as_array();
        unset($responseData["password"]);

        echo json_encode([
            "status" => "success",
            "data" => $responseData,
        ]);
    }

    public function createUser()
    {
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input["username"]) || !isset($input["password"])) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "Invalid data format",
            ]);
            return;
        }

        $existingUser = User::where("username", $input["username"])->find_one();
        if ($existingUser) {
            http_response_code(409);
            echo json_encode([
                "status" => "error",
                "message" => "Username already exists.",
            ]);
            return;
        }

        $newUser = User::create();
        $newUser->username = $input["username"];
        $newUser->password = password_hash($input["password"], PASSWORD_BCRYPT);
        $newUser->role = $input["role"] ?? "Pelanggan";
        $newUser->save();

        $responseData = $newUser->as_array();
        unset($responseData["password"]);

        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "Successfully created user.",
            "data" => $responseData,
        ]);
    }

    public function updateUser($id)
    {
        header("Content-Type: application/json");
        $input = json_decode(file_get_contents("php://input"), true);

        $user = User::find_one($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "User not found.",
            ]);
            return;
        }

        if (isset($input["username"])) {
            $user->username = $input["username"];
        }
        if (isset($input["role"])) {
            $user->role = $input["role"];
        }
        if (isset($input["password"])) {
            $user->password = password_hash(
                $input["password"],
                PASSWORD_BCRYPT,
            );
        }

        $user->save();

        $responseData = $user->as_array();
        unset($responseData["password"]);

        echo json_encode([
            "status" => "success",
            "message" => "Successfully updated user.",
            "data" => $responseData,
        ]);
    }

    public function deleteUser($id)
    {
        header("Content-Type: application/json");
        $user = User::find_one($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "User not found.",
            ]);
            return;
        }

        $user->delete();

        echo json_encode([
            "status" => "success",
            "message" => "Successfully deleted user.",
        ]);
    }
}
