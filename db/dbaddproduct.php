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

    public function addProduct($productName, $price, $description, $image, $condition = 'new', $itemPath = null, $variations = [])
    {
        $uploadDir = 'uploads/';
        $imagePath = $uploadDir . basename($image['name']);

        // Ensure the uploads directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Insert into products table
            $query = "INSERT INTO products (product_name, price, description, image_path, `condition`, item_path) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("sdssss", $productName, $price, $description, $imagePath, $condition, $itemPath);
                if ($stmt->execute()) {
                    // Get the last inserted product_id
                    $productId = $stmt->insert_id;

                    // Insert variations if any
                    if (!empty($variations)) {
                        foreach ($variations as $variation) {
                            $variationType = $variation['type'];
                            $variationValue = $variation['value'];
                            $variationPrice = $variation['price'];
                            $variationStock = $variation['stock'];

                            $variationQuery = "INSERT INTO product_variations (product_id, variation_type, variation_value, price, stock) VALUES (?, ?, ?, ?, ?)";
                            $variationStmt = $this->conn->prepare($variationQuery);
                            if ($variationStmt) {
                                $variationStmt->bind_param("issdi", $productId, $variationType, $variationValue, $variationPrice, $variationStock);
                                $variationStmt->execute();
                                $variationStmt->close();
                            } else {
                                return "Error preparing variation query: " . $this->conn->error;
                            }
                        }
                    }

                    $stmt->close();
                    return "Product added successfully.";
                } else {
                    return "Database error: " . $stmt->error;
                }
            } else {
                return "Error preparing query: " . $this->conn->error;
            }
        } else {
            return "Failed to upload the image.";
        }
    }
}
?>