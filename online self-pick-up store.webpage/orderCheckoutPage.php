<?php
header('Content-Type: text/html; charset=UTF-8');
    include "conn.php";
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        //echo "User ID: " . $user_id;  // Display the user ID for validation
    } else {
        // echo "No user ID provided.";
        $user_id = null; // If no user_id is passed, set it to null.
    }

    // Pass the user_id to JavaScript using json_encode for safety.
    echo "<script>const userId = " . json_encode($user_id) . ";</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <h1>Order Checkout</h1>
            <ul class="nav-links">
            <li><a href="shoppingCart.php?user_id=<?php echo $user_id; ?>">Shopping Cart</a></li>
            <li><a href="C_Personal Information.php?user_id=<?php echo $user_id; ?>">Me</a></li>
            <li><a href="Homepage.php?user_id=<?php echo $user_id; ?>">Back to Select Store</a></li>
            <li><a href="customer_login.php">Log Out</a></li>

            </ul>
        </nav>
    </header>
    <main>
        <div class="checkout-container">
            <h2>Review Your Order</h2>
            <div id="order-summary">
                <!-- Cart items will be dynamically inserted here -->
            </div>
            <div id="total-price">
                <!-- Total price will be dynamically displayed here -->
            </div>
            <div id="feedback">
                <!-- Feedback messages will be shown here -->
            </div>
        </div>
        <button id="checkout-btn">Checkout</button>
    </main>

    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const orderSummary = document.getElementById('order-summary');
        const totalPriceElement = document.getElementById('total-price');
        const feedbackElement = document.getElementById('feedback');

        const cartItems = JSON.parse(localStorage.getItem('cartItems'));

        if (cartItems && Array.isArray(cartItems) && cartItems.length > 0) {
            let totalPrice = 0;

            cartItems.forEach(item => {
                const itemElement = createCartItemElement(item);
                orderSummary.appendChild(itemElement);
                totalPrice += item.price * item.quantity;
            });

            totalPriceElement.innerHTML = `<h3>Total Price: $${totalPrice.toFixed(2)}</h3>`;
        } else {
            orderSummary.innerHTML = "<p>No items in the cart.</p>";
        }

        document.getElementById('checkout-btn').addEventListener('click', function () {
            feedbackElement.innerHTML = ""; 

            if (!cartItems || cartItems.length === 0) {
                alert("Your cart is empty.");
                return;
            }

            if (!userId) {
                alert("User ID is missing.");
                return;
            }

            fetch('check_inventory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    cartItems: cartItems
                })
            })
            .then(response => response.json()) 
            .then(data => {
                console.log("Checkout response:", data);
                if (data.success) {
                    feedbackElement.innerHTML = `<p style="color: green;">Checkout successful!</p>`;

                    window.location.href = data.redirect_url; 
                } else if (data.errors) {
                    data.errors.forEach(error => {
                        const errorMessage = document.createElement('p');
                        errorMessage.style.color = "red";
                        errorMessage.textContent = error.message;
                        feedbackElement.appendChild(errorMessage);
                    });
                } else {
                    feedbackElement.innerHTML = `<p style="color: red;">An unknown error occurred during checkout.</p>`;
                }
            })
            .catch(error => {
                console.error("Error:", error);
                feedbackElement.innerHTML = `<p style="color: red;">Failed to connect to the server. Please try again later.</p>`;
            });
        });
    });

    function createCartItemElement(item) {
        const itemElement = document.createElement('div');
        itemElement.classList.add('cart-item');
        itemElement.innerHTML = `
            <p>Pick Up Store: ${item.s_name}</p>
            <p>Product: ${item.p_name}</p>
            <p>Quantity: ${item.quantity}</p>
            <p>Price: $${item.price.toFixed(2)}</p>
            <p>Total: $${(item.price * item.quantity).toFixed(2)}</p>
            <hr>
        `;
        return itemElement;
    }

    </script>
</body>
</html>
