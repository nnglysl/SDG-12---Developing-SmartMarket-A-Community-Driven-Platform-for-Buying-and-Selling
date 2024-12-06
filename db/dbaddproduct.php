<?php
require_once __DIR__ . '/../db/dbcon.php';

class ProductManager
{
    private $conn;

    public function __construct()
    {
        $connection = new Database();
        $this->conn = $connection->getConnection();
    }

    public function addProduct($productName, $price, $description, $image, $condition, $itemPath = null, $sellerId, $variations = [])
{
    $uploadDir = '../uploads/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // image types
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    if (is_array($image) && isset($image['name']) && isset($image['tmp_name'])) {
        // Validate image type and size
        if (!in_array($image['type'], $allowedTypes)) {
            return "Invalid image type. Only JPG, PNG, and GIF are allowed.";
        }

        if ($image['size'] > $maxFileSize) {
            return "Image size exceeds the maximum limit of 2MB.";
        }

        $imagePath = $uploadDir . basename($image['name']);

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Insert into products table
            $query = "INSERT INTO products (product_name, price, description, image_path, `condition`, item_path, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("sdssssi", $productName, $price, $description, $imagePath, $condition, $itemPath, $sellerId);
                if ($stmt->execute()) {
                    $productId = $stmt->insert_id;

                    if (!empty($variations)) {
                        foreach ($variations as $variation) {
                            $variationQuery = "INSERT INTO product_variations (product_id, variation_type, variation_value, price, stock) VALUES (?, ?, ?, ?, ?)";
                            $variationStmt = $this->conn->prepare($variationQuery);
                            if ($variationStmt) {
                                $variationStmt->bind_param("issdi", $productId, $variation['type'], $variation['value'], $variation['price'], $variation['stock']);
                                if (!$variationStmt->execute()) {
                                    return "Error inserting variation: " . $variationStmt->error;
                                }
                                $variationStmt->close();
                            } else {
                                return "Error preparing variation query: " . $this->conn->error;
                            }
                        }
                    }

                    $stmt->close();
                    return "Product added successfully.";
                } else {
                    return "Database error while adding product: " . $stmt->error;
                }
            } else {
                return "Error preparing product query: " . $this->conn->error;
            }
        } else {
            return "Error uploading image.";
        }
    } else {
        return "Invalid image data.";
    }
}   
}
?>