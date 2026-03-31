<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/databaseConfig.php";

echo "Seeding started\n";

$checkAdmin = Model::factory("Models\User")
    ->where("username", "helmi")
    ->find_one();

if (!$checkAdmin) {
    $admin = Model::factory("Models\User")->create();
    $admin->username = "helmi";

    $admin->password = password_hash("kar", PASSWORD_BCRYPT);
    $admin->role = "Admin";
    $admin->save();

    echo "Success seeding User Admin!\n";
} else {
    echo "Failed seeding User Admin.\n";
}

$checkPelanggan = Model::factory("Models\User")
    ->where("username", "hudaganteing")
    ->find_one();

if (!$checkPelanggan) {
    $pelanggan = Model::factory("Models\User")->create();
    $pelanggan->username = "huda";
    $pelanggan->password = password_hash("hudaganteing", PASSWORD_BCRYPT);
    $pelanggan->role = "Pelanggan";
    $pelanggan->save();

    echo "Success seeding User Pelanggan!\n";
} else {
    echo "Failed seeding User Pelanggan.\n";
}

echo "Seeding completed!\n";
