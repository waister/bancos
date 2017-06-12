<?php

require_once APP_PATH . "Model/Bank.php";

require_once APP_PATH . "Manager/BanksManager.php";

$priority = Util::getArray("priority");
$only = Util::getArray("only");
$except = Util::getArray("except");

$manager = BanksManager::getInstance();

$banks = $manager->findAll(1000);
$lastUpdated = $manager->last();

$data = [
    "author" => "Waister Nunes <waisters@gmail.com>",
    "last_update" => date("Y-m-d H:i:s"),
    "banks" => [],
];

if ($lastUpdated) {
    $data["last_update"] = $lastUpdated->getUpdatedAt();
}

foreach ($banks as $key => $bank) {
    $data["banks"][] = [
        "code" => $bank->getId(),
        "name" => $bank->getName(),
        "code_name" => $bank->getId() . ' - ' . $bank->getName(),
        "name_code" => $bank->getName() . ' (' . $bank->getId() . ')',
    ];
}


if ($priority) {
    $dataPriority = [];

    foreach ($priority as $id) {
        foreach ($data["banks"] as $key => $item) {
            if ($id == $item['code']) {
                $dataPriority[] = $item;
                unset($data["banks"][$key]);
            }
        }
    }

    $data["banks"] = $dataPriority + $data["banks"];
}


if ($except) {
    foreach ($except as $id) {
        foreach ($data["banks"] as $key => $item) {
            if ($id == $item['code']) {
                unset($data["banks"][$key]);
            }
        }
    }
}


if ($only) {
    $dataOnly = [];

    foreach ($only as $id) {
        foreach ($data["banks"] as $key => $item) {
            if ($id == $item['code']) {
                $dataOnly[] = $item;
            }
        }
    }

    $data["banks"] = $dataOnly;
}


header('Content-Type: application/json');

echo json_encode($data);
