<!-- import header here -->
<?php 
require_once("head.php");
require_once("connect.php");
require_once("data.php");
$products = getProducts($pdo);
try {
    if (!empty($category)) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_category = ?");
        $stmt->execute([$category]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Fetch all products if no category is selected
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>

<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <!-- import spinner here -->
    
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <!-- import sidebar here -->
    <?php include("sidebar.php"); ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <!-- import navbar here -->
        <?php include("navbar.php"); ?>
        <!-- Navbar End -->

        <!-- Table Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Product Table</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <?php foreach(array_keys($products[0]) as $title): ?>
                                            <th scope="col"><?= $title ?></th>
                                        <?php endforeach ?>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php foreach($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['product_id']) ?></td>
            <td><?= htmlspecialchars($product['product_name']) ?></td>
            <td><?= htmlspecialchars($product['product_category']) ?></td>
            <td><?= htmlspecialchars($product['product_price']) ?></td>
            <td><?= htmlspecialchars($product['product_stock']) ?></td>
            <td>
                <?php if (!empty($product['product_image'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($product['product_image']) ?>" alt="Product Image" style="width: 80px; height: 100px;">
                <?php else: ?>
                    <img src="default-image.jpg" alt="Default Image" style="width: 80px; height: 100px;">
                <?php endif; ?>
            </td>
            <td>
                <a href="product_edit.php?id=<?= htmlspecialchars($product['ID']) ?>" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                <a href="product_delete.php?id=<?= htmlspecialchars($product['ID']) ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table End -->
        
        <!-- Footer Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-light rounded-top p-4">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center text-sm-start">
                        &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
    </div>
    <!-- Content End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<?php include("jslibs.php"); ?>
