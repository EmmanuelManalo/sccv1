<?php

// Read search individual
function checkSearchIndividual($object)
{
    $query = $object->searchIndividual();
    checkQuery($query, "Empty records. (search individual)");
    return $query;
}

// Read search product
function checkSearchProduct($object)
{
    $query = $object->searchProduct();
    checkQuery($query, "Empty records. (search product)");
    return $query;
}
