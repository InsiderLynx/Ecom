<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registeration Form For User</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="post" action="signupdb.php" >
        <label for="">User Name</label>r
        <input type="text" name="username" required><br><br>
        <label for="">Email</label>
        <input type="text" name="email" required><br><br>
        <label for="">Password</label>
        <input type="password" name="password" required><br><br>
        <label for="">Address</label>
        <input type="text" name="address" required><br><br>
        <input type="submit" name="submit" value="signup">
        <a href="login.php">Already have an account nigga?</a>
    </form>
</body>
</html>
<section class="py-5">
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4" id="product-container">
        <?php 
$counter = 0;
foreach($products as &$product): 
    if ($counter >= 75) break; // Show only the first 12 products initially
    
    // Convert BLOB data to base64
    if (!empty($product['Image'])) {
        // Ensure proper base64 encoding
        $product['Image'] = base64_encode($product['Image']);
    } else {
        // Use a placeholder image if no image is available
        $product['Image'] = 'default-image.jpg'; // Replace with your placeholder image path
    }
    $imageSrc = !empty($product['Image']) ? 'data:image/jpeg;base64,' . $product['Image'] : 'default-image.jpg'; // Handle default image if needed
?>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-card">
        <div class="card h-100">
            <img src="<?= $imageSrc ?>" class="card-img-top" alt="Product Image" style="width: 100%; height: 200px;">
            <div class="card-body">
                <h5 class="card-title"><?= $product['Name'] ?></h5>
                <p class="card-text">Category: <?= $product['Category'] ?></p>
                <p class="card-text">Price: $<?= $product['Price'] ?></p>
                <a href="product_detail.php?id=<?= $product['ID'] ?>" class="btn btn-primary">View Details</a>
                <!-- Add to Cart button -->
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?= $product['ID'] ?>">
                    <input type="hidden" name="product_name" value="<?= $product['Name'] ?>">
                    <input type="hidden" name="product_price" value="<?= $product['Price'] ?>">
                    <input type="hidden" name="product_image" value="<?= $imageSrc ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-success mt-2">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
<?php 
    $counter++; 
endforeach;
?>
        </section>


<script>
// JavaScript to load more products
document.addEventListener("DOMContentLoaded", function() {
    let loadMoreButton = document.getElementById('load-more');
    let productContainer = document.getElementById('product-container');
    let products = <?= json_encode($products) ?>;
    let currentProductCount = 75;

    loadMoreButton.addEventListener('click', function() {
        try {
            for (let i = currentProductCount; i < currentProductCount + 75; i++) {
                if (i >= products.length) {
                    loadMoreButton.style.display = 'none'; // Hide button if no more products
                    break;
                }
                let product = products[i];
                
                // Base64 image data already processed in PHP
                let imageSrc = product.Image ? 'data:image/jpeg;base64,' + product.Image : 'default-image.jpg';

                let cardHTML = `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-card">
                        <div class="card h-100">
                            <img src="${imageSrc}" class="card-img-top" alt="Product Image" style="width: 100%; height: 200px;">
                            <div class="card-body">
                                <h5 class="card-title">${product.Name}</h5>
                                <p class="card-text">Category: ${product.Category}</p>
                                <p class="card-text">Price: $${product.Price}</p>
                                <a href="product_detail.php?id=${product.ID}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                `;
                productContainer.insertAdjacentHTML('beforeend', cardHTML);
            }
            currentProductCount += 75;
        } catch (error) {
            console.error("Error loading more products: ", error);
        }
    });
});
</script>
</body>
