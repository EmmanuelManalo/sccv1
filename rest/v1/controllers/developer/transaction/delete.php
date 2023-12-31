<?php
// check database connection
$conn = null;
$conn = checkDbConnection();
// make instance of classes
$transaction = new Transaction($conn);
// get $_GET data
$error = [];
$returnData = [];
if (array_key_exists("transactionId", $_GET)) {
    // get data
    $transaction->transaction_aid = $_GET['transactionId'];
    checkId($transaction->transaction_aid);

    $item = $data["data"];

    $transaction->transaction_product_id = checkIndex($item, "transaction_product_id");
    $productQty = checkIndex($item, "product_quantity");
    $transactionQty = checkIndex($item, "transaction_quantity");
    $transaction->transaction_updated_at = date("Y-m-d H:i:s");

    $transaction->product_quantity = floatval($productQty) + floatval($transactionQty);

    checkUpdateProduct($transaction);
    $query = checkDelete($transaction);
    returnSuccess($transaction, "Transaction", $query);
}

// return 404 error if endpoint not available
checkEndpoint();
