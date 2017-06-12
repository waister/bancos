<?php

require_once APP_PATH . "/Connection.php";
require_once APP_PATH . "/Log.php";
require_once APP_PATH . "/Model/Bank.php";

class BanksManager {

    public static $instance;
    public $timestamp;

    private function __construct()
    {
        $this->timestamp = date("Y-m-d H:i:s");
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new BanksManager();
        }

        return self::$instance;
    }

    public function insert(Bank $bank)
    {
        try {
            $sql = "INSERT INTO
                banks (
                    `id`,
                    `name`,
                    `updated_at`,
                    `created_at`
                ) VALUES (
                    :id,
                    :name,
                    :updated_at,
                    :created_at
                )";

            $query = Connection::getInstance()->prepare($sql);

            $query->bindValue(":id", $bank->getId());
            $query->bindValue(":name", $bank->getName());
            $query->bindValue(":updated_at", $this->timestamp);
            $query->bindValue(":created_at", $this->timestamp);

            if ($query->execute()) {
                return "success";
            }
        } catch (Exception $e) {
            Log::insert("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }

        return "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
    }

    public function update(Bank $bank)
    {
        try {
            $sql = "UPDATE banks SET 
                `name` = :name,
                `updated_at` = :updated_at
                WHERE id = :id";

            $query = Connection::getInstance()->prepare($sql);

            $query->bindValue(":id", $bank->getId());
            $query->bindValue(":name", $bank->getName());
            $query->bindValue(":updated_at", $this->timestamp);

            if ($query->execute()) {
                return "success";
            }
        } catch (Exception $e) {
            Log::insert("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }

        return "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM banks WHERE id = :id";

            $query = Connection::getInstance()->prepare($sql);

            $query->bindValue(":id", $id);

            if ($query->execute()) {
                return "success";
            }
        } catch (Exception $e) {
            Log::insert("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }

            return "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
    }

    public function find($id)
    {
        try {
            $sql = "SELECT * FROM banks WHERE id = :id";

            $query = Connection::getInstance()->prepare($sql);

            $query->bindValue(":id", $id);

            $query->execute();

            if ($query->rowCount()) {
                return $this->add($query->fetch(PDO::FETCH_ASSOC));
            }
        } catch (Exception $e) {
            Log::insert("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }

        return "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
    }

    public function last()
    {
        try {
            $sql = "SELECT * FROM banks ORDER BY updated_at DESC LIMIT 1";

            $query = Connection::getInstance()->prepare($sql);

            $query->execute();

            if ($query->rowCount()) {
                return $this->add($query->fetch(PDO::FETCH_ASSOC));
            }
        } catch (Exception $e) {
            Log::insert("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }

        return "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
    }

    public function conditions()
    {
        $sql = "";

        // $s = @$_GET["s"];
        // $filterState = @$_GET["state"];

        // if ($s || $filterState) {
        //     $conditions = "";

        //     if ($s) {
        //         $conditions .= "(email LIKE '%" . $s . "%' OR city LIKE '%" . $s . "%' OR state LIKE '%" . $s . "%')";
        //     }

        //     if ($filterState) {
        //         if (!empty($conditions)) {
        //             $conditions .= " AND ";
        //         }

        //         $conditions .= "state = '" . $filterState . "'";
        //     }

        //     $sql .= " WHERE " . $conditions;
        // }

        return $sql;
    }

    public function findAll($limit = 25)
    {
        $sort = empty($_GET["sort"]) ? 1 : $_GET["sort"];
        $page = empty($_GET["page"]) ? 1 : $_GET["page"];
        $page = $page - 1;

        try {
            $limitStart = ($page * $limit);

            if ($limit == 100000) {
                $limitStart = 0;
            }

            $orderBy = "id ASC";

            if ($sort) {
                if (strstr($sort, ':')) {
                    $sep = explode(':', $sort);
                    if ($sep[0] == 'code') $sep[0] = 'id';

                    $orderBy = $sep[0] . " " . $sep[1];
                } else {
                    $orderBy = $sort . " ASC";
                }
            }

            $sql = "SELECT * FROM banks";
            $sql .= $this->conditions();
            $sql .= " ORDER BY " . $orderBy . " LIMIT " . $limitStart . ", " . $limit;
            Log::insert($sql);

            $query = Connection::getInstance()->prepare($sql);

            $query->execute();

            $items = [];

            if ($query->rowCount()) {
                foreach ($query as $key => $item) {
                    $bank = $this->add($item);

                    $items[$key] = $bank;
                }
            }

            return $items;
        } catch (Exception $e) {
            Log::insert("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }

        return "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
    }

    public function countAll($onlySelected = false)
    {
        try {
            $conditions = $this->conditions();

            $sql = "SELECT COUNT(id) FROM banks";
            $sql .= $conditions;

            if ($onlySelected) {
                $sql .= $conditions ? " AND" : " WHERE";
                $sql .= " selection = 'true'";
            }

            Log::insert($sql);

            $query = Connection::getInstance()->prepare($sql);
            $query->execute();

            if ($query->rowCount()) {
                foreach ($query as $item) {
                    if (isset($item[0])) {
                        return $item[0];
                    }
                }
            }
        } catch (Exception $e) {
            Log::insert("Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }

        return 0;
    }

    private function add($row)
    {
        $bank = new Bank;

        $bank->setId($row["id"]);
        $bank->setName($row["name"]);
        $bank->setUpdatedAt($row["updated_at"]);
        $bank->setCreatedAt($row["created_at"]);
        // $bank->setUpdatedAt(Util::date($row["updated_at"]));
        // $bank->setCreatedAt(Util::date($row["created_at"]));

        return $bank;
    }

    private function format($val)
    {
        return substr($val, 6, 4) . '-' . substr($val, 3, 2) . '-' . substr($val, 0, 2) . ' 00:00:00';
    }

    private function formatEnd($val)
    {
        $date = $this->format($val);

        if (strstr($date, "00:00:00")) {
            return str_replace("00:00:00", "23:59:59", $date);
        }

        return $date;
    }

}
