<?php
class Transaction
{
    public $transaction_aid;
    public $transaction_product_id;
    public $transaction_individual_id;
    public $transaction_quantity;
    public $transaction_is_active;
    public $transaction_created_at;
    public $transaction_updated_at;

    public $employee_aid;

    public $transaction_start;
    public $transaction_total;
    public $transaction_search;

    public $connection;
    public $lastInsertedId;
    public $tblTransaction;
    public $tblProduct;
    public $tblIndividual;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblTransaction = "sccv1_transaction";
        $this->tblProduct = "sccv1_product";
        $this->tblIndividual = "sccv1_individual";
    }

    // create
    public function create()
    {
        try {
            $sql = "insert into {$this->tblTransaction} ";
            $sql .= "( transaction_product_id, ";
            $sql .= "transaction_individual_id, ";
            $sql .= "transaction_quantity, ";
            $sql .= "transaction_is_active, ";
            $sql .= "transaction_created_at, ";
            $sql .= "transaction_updated_at ) values ( ";
            $sql .= ":transaction_product_id, ";
            $sql .= ":transaction_individual_id, ";
            $sql .= ":transaction_quantity, ";
            $sql .= ":transaction_is_active, ";
            $sql .= ":transaction_created_at, ";
            $sql .= ":transaction_updated_at ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "transaction_product_id" => $this->transaction_product_id,
                "transaction_individual_id" => $this->transaction_individual_id,
                "transaction_quantity" => $this->transaction_quantity,
                "transaction_is_active" => $this->transaction_is_active,
                "transaction_created_at" => $this->transaction_created_at,
                "transaction_updated_at" => $this->transaction_updated_at,
            ]);
            $this->lastInsertedId = $this->connection->lastInsertId();
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // read all
    public function readAll()
    {
        try {
            $sql = "select ";
            $sql .= "* ";
            $sql .= "from {$this->tblTransaction} ";
            $sql .= "order by transaction_is_active desc, ";
            $sql .= "transaction_product_id asc ";
            $query = $this->connection->query($sql);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // read all limit
    public function readLimit()
    {
        try {
            $sql = "select ";
            $sql .= "* ";
            $sql .= "from {$this->tblTransaction} as transaction, ";
            $sql .= " {$this->tblProduct} as product, ";
            $sql .= " {$this->tblIndividual} as individual ";
            $sql .= "order by transaction_is_active desc, ";
            $sql .= "transaction_product_id asc ";
            $sql .= "limit :start, ";
            $sql .= ":total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->transaction_start - 1,
                "total" => $this->transaction_total,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // search
    public function search()
    {
        try {
            $sql = "select ";
            $sql .= "* ";
            $sql .= "from {$this->tblTransaction} ";
            $sql .= "where transaction_product_id like :search ";
            $sql .= "order by transaction_is_active desc, ";
            $sql .= "transaction_product_id asc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "search" => "%{$this->transaction_search}%",
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // read by id
    public function readById()
    {
        try {
            $sql = "select * from {$this->tblTransaction} ";
            $sql .= "where transaction_aid = :transaction_aid ";
            $sql .= "order by transaction_product_id asc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "transaction_aid" => $this->transaction_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // update
    public function update()
    {
        try {
            $sql = "update {$this->tblTransaction} set ";
            $sql .= "transaction_product_id = :transaction_product_id, ";
            $sql .= "transaction_individual_id = :transaction_individual_id, ";
            $sql .= "transaction_quantity = :transaction_quantity, ";
            $sql .= "transaction_updated_at = :transaction_updated_at ";
            $sql .= "where transaction_aid = :transaction_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "transaction_product_id" => $this->transaction_product_id,
                "transaction_individual_id" => $this->transaction_individual_id,
                "transaction_quantity" => $this->transaction_quantity,
                "transaction_updated_at" => $this->transaction_updated_at,
                "transaction_aid" => $this->transaction_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }


    // active
    public function active()
    {
        try {
            $sql = "update {$this->tblTransaction} set ";
            $sql .= "transaction_is_active = :transaction_is_active, ";
            $sql .= "transaction_updated_at = :transaction_updated_at ";
            $sql .= "where transaction_aid = :transaction_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "transaction_is_active" => $this->transaction_is_active,
                "transaction_updated_at" => $this->transaction_updated_at,
                "transaction_aid" => $this->transaction_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // delete
    public function delete()
    {
        try {
            $sql = "delete from {$this->tblTransaction} ";
            $sql .= "where transaction_aid = :transaction_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "transaction_aid" => $this->transaction_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // name
    public function checkName()
    {
        try {
            $sql = "select transaction_product_id from {$this->tblTransaction} ";
            $sql .= "where transaction_product_id = :transaction_product_id ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "transaction_product_id" => "{$this->transaction_product_id}",
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }
}