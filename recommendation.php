<?php

// Function to get recommended products for a user based on their order history
function getRecommendedProducts($username, $conn) {
    // Query to fetch user ID based on the username
    $user_query = "SELECT user_id FROM customer WHERE username = '$username'";
    $user_result = $conn->query($user_query);
    
    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row['user_id'];
        
        // Query to fetch order history of the user
        $order_query = "SELECT F_ID FROM orders WHERE username = '$username'";
        $order_result = $conn->query($order_query);
        
        if ($order_result->num_rows > 0) {
            // Array to store food IDs from order history
            $food_ids = array();
            
            // Extract food IDs from the order history
            while ($row = $order_result->fetch_assoc()) {
                $food_ids[] = $row['F_ID'];
            }
            
            // Convert food IDs array to a comma-separated string
            $food_ids_str = implode(",", $food_ids);
            
            // Query to fetch recommended products based on order history
            $recommendation_query = "SELECT * FROM food WHERE F_ID NOT IN ($food_ids_str) LIMIT 5";
            $recommendation_result = $conn->query($recommendation_query);
            
            if ($recommendation_result->num_rows > 0) {
                // Array to store recommended products
                $recommended_products = array();
                
                // Fetch recommended products and store them in the array
                while ($row = $recommendation_result->fetch_assoc()) {
                    $recommended_products[] = $row;
                }
                
                return $recommended_products;
            } else {
                return array(); // No recommendations available
            }
        } else {
            return array(); // No order history available
        }
    } else {
        return array(); // User not found
    }
}

?>
