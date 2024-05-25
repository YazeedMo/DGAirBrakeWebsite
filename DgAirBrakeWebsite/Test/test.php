<?php

    require_once __DIR__ . '/../Model/Address.php';
    require_once __DIR__ . '/../Model/Card.php';
    require_once __DIR__ . '/../Model/Product.php';
    require_once __DIR__ . '/../Model/Category.php';
    require_once __DIR__ . '/../Repository/DAO/CardRepository.php';
    require_once __DIR__ . '/../Repository/DAO/AddressRepository.php';
    require_once __DIR__ . '/../Repository/DAO/ProductRepository.php';
    require_once __DIR__ . '/../Repository/DAO/CategoryRepository.php';

    $categoryRepo = new CategoryRepository;

    $newCategory = new Category(2, 'number 2');
    $categoryRepo->deleteCategory($newCategory);

    $allCategories = $categoryRepo->getAllCategories();

    foreach ($allCategories as $category) {

        echo $category->__toString() . "<br>";

    }



    
?>