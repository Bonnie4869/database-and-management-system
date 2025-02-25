<?php
            header('Content-Type: text/html; charset=UTF-8');
            include "conn.php";
            session_start();
            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
                //echo "User ID: " . $user_id;  // Display the user ID for validation
            } else {
                // echo "No user ID provided.";
                $user_id = null; // If no user_id is passed, set it to null.
            }
            //test
            $user_id= null ?? '1';
            echo "<script>const userId = " . json_encode($user_id) . ";</script>";
            //deal with safe issues
            $user_id = $conn->real_escape_string($user_id);
            
            $start_time = microtime(true);

            $sql = "SELECT sid, s_name, pid, p_name, price
                    FROM store_cart JOIN product USING(pid) JOIN store USING(sid)
                    WHERE id=$user_id"; 
            $result = $conn->query($sql);

            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;
            echo "<p>Execution time is:  $execution_time</p>";
            //test
            // if ($result &&$result->num_rows > 0) {  
            //     echo "have result";
            // } else {
            //     echo "nothing";
            // }

            // transfer the value to array
            if ($result) {
                // transfer the value to array
                $cartItems = [];
                while ($row = $result->fetch_assoc()) {
                    $cartItems[] = $row;
                    //test
                    //echo '<br>storeid'.$row["sid"].'<br>pname'.$row["p_name"];
                }
                echo "<script>const cartItems = " . json_encode($cartItems) . ";</script>";
            } else {
                echo "Error: " . $conn->error;
            }
            $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-container {
            max-width: 800px;
            margin: auto;
            padding: 20px; 
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
        }

        .cart-item span {
            margin-right: 15px; 
        }

        .cart-item input[type="number"],
        .cart-item .item-total {
            margin-right: 20px; 
        }

        .cart-item .delete-btn {
            margin-left: 10px; 
        }

        .summary {
            display: flex;
            justify-content: space-between;
            margin-top: 30px; 
            font-size: 1.2em;
        }

        .summary span {
            margin-right: 20px; 
        }

        .total {
            font-weight: bold;
        }

        .checkout-btn {
            background-color: #28a745;
            color: white;
            padding: 12px 24px; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px; 
        }

        .checkout-btn:hover {
            background-color: #218838;
        }

        input[type="checkbox"] {
            margin-right: 10px; 
        }
    </style>
</head>
<body>
    <!-- test 
    <div id="output"></div>-->

    <header>
        <nav>
            <h1>Shopping Cart</h1>
            <ul class="nav-links">
            <li><a href="shoppingCart.php?user_id=<?php echo $user_id; ?>">Shopping Cart</a></li>
            <li><a href="C_Personal Information.php?user_id=<?php echo $user_id; ?>">Me</a></li>
            <li><a href="Homepage.php?user_id=<?php echo $user_id; ?>">Back to Select Store</a></li>
            <li><a href="customer_login.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <div class="cart-container">
        <h1>Shopping Cart</h1>
        <div id="cart-items-container"></div>
        <div>
            <input type="checkbox" id="select-all">
            <label for="select-all">Select All</label>
        </div>
        <div class="summary">
            <span>Total Items: <strong id="total-items">0</strong></span>
            <span class="total">Total: $<strong id="total-price">0</strong></span>
        </div>
        <div>
            <button class="checkout-btn">Proceed to Checkout</button>
        </div>
    </div>
    </main>
    <footer>
        <p>&copy; Group 05 DBMS Project. All rights reserved.</p>
    </footer>

    <script>
        //test
        console.log(userId);

        // Get the DOM elements for cart display
        const cartItemsContainer = document.getElementById('cart-items-container');
        const selectAllCheckbox = document.getElementById('select-all');
        const totalItemsElement = document.getElementById('total-items');
        const totalPriceElement = document.getElementById('total-price');

        // Function to generate the cart item HTML
        function generateCartItemHTML(item) {
            const price = isNaN(item.price) ? 0 : parseFloat(item.price);
            const quantity = 1; 

            return `
                <div class="cart-item" data-sid="${item.sid}" data-pid="${item.pid}">
                    <input type="checkbox" class="product-checkbox" data-sid="${item.sid}" data-pid="${item.pid}">
                    <span class="sid" >Store ID: ${item.sid}</span>
                    <span class="s_name">Store Name: ${item.s_name}</span>  
                    <span class="pid">Product: ${item.p_name}</span>  
                    <span>Price: $${price.toFixed(2)}</span>
                    <input type="number" value="${quantity}" class="quantity" min="1" data-id="${item.sid}">
                    <span class="item-total" data-item-total="${(price * quantity).toFixed(2)}">$${(price * quantity).toFixed(2)}</span>
                    <button class="delete-btn" onclick="deleteItem(${item.sid}, ${item.pid})">Delete</button>
                </div>
            `;

        }


        // Handle select-all functionality
        selectAllCheckbox.addEventListener('change', () => {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked; 
            });
            updateSummary(); // Update the total price and item count when selection changes
        });

        // Check if all checkboxes are selected, and update the 'select-all' checkbox
        function updateSelectAllCheckbox() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const allSelected = Array.from(checkboxes).every(checkbox => checkbox.checked); // Check if all products are selected

            // If all products are selected, check the 'select-all' checkbox, otherwise uncheck it
            selectAllCheckbox.checked = allSelected;
        }

        // Add event listeners for individual product checkboxes
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                updateSelectAllCheckbox(); // Update 'select-all' checkbox state
                updateSummary(); // Update total price and items count
            });
        });

        // Render all cart items
        function renderCart() {
            cartItemsContainer.innerHTML = ''; // Clear any existing cart items
            //test
            console.log(cartItems);
            cartItems.forEach(item => {
                cartItemsContainer.innerHTML += generateCartItemHTML(item);
            });

            updateSummary(); // Update totals when cart is rendered
            updateSelectAllCheckbox(); // Ensure 'select-all' checkbox is in the correct state

            // Add event listeners for checkboxes and quantity inputs
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    updateSelectAllCheckbox(); // Update 'select-all' checkbox state
                    updateSummary(); // Update total price and items count
                });
            });

            document.querySelectorAll('.quantity').forEach(input => {
                input.addEventListener('input', updateSummary); // Update total when quantity changes
            });
        }

        // Update total items and total price
        function updateSummary() {
            let totalItems = 0;
            let totalPrice = 0;

            document.querySelectorAll('.product-checkbox').forEach((checkbox, index) => {
                const item = cartItems[index];
                const quantityInput = checkbox.closest('.cart-item').querySelector('.quantity');
                const price = item.price;
                const quantity = parseInt(quantityInput.value);

                if (checkbox.checked) {
                    totalItems++;
                    totalPrice += price * quantity;
                }

                checkbox.closest('.cart-item').querySelector('.item-total').innerText = `$${(price * quantity).toFixed(2)}`;
                checkbox.closest('.cart-item').querySelector('.item-total').setAttribute('data-item-total', (price * quantity).toFixed(2)); // 更新 itemTotal
            });

            totalItemsElement.innerText = totalItems;
            totalPriceElement.innerText = totalPrice.toFixed(2);
        }

        document.querySelectorAll('.quantity').forEach(input => {
            input.addEventListener('input', updateSummary);
        });



        // Delete product from cart
        function deleteItem(sid, pid) {
            // Log the user ID, store ID, and product ID to check if the values are correct
            console.log('Deleting item with user_id:', userId, 'sid:', sid, 'pid:', pid);

            // Perform the deletion in the front-end (remove item from cartItems array)
            const index = cartItems.findIndex(item => item.sid === sid && item.pid === pid);
            if (index !== -1) {
                cartItems.splice(index, 1);  // Remove the item from the array
                renderCart();  // Re-render the cart
            }

            // Send AJAX request to delete the item from the database
            fetch('deleteCartItem.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_id: userId,
                    sid: sid,
                    pid: pid
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Item deleted successfully from the database');
                    location.reload(); 
                } else {
                    console.error('Failed to delete item from the database');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Initialize the cart on page load
        renderCart();

        function getSelectedItems() {
            let selectedItems = [];
            document.querySelectorAll('.product-checkbox:checked').forEach(checkbox => {
                const cartItem = checkbox.closest('.cart-item');
                const sid = checkbox.getAttribute('data-sid');  // Store ID
                const pid = checkbox.getAttribute('data-pid');  // Product ID
                const s_name = cartItem.querySelector('.s_name').textContent;  // Store Name
                const p_name = cartItem.querySelector('.pid').textContent.replace('Product: ', '');  // Product Name
                const price = parseFloat(cartItem.querySelector('.item-total').getAttribute('data-item-total')) / parseInt(cartItem.querySelector('.quantity').value);  // Price per unit
                const quantity = parseInt(cartItem.querySelector('.quantity').value);  // Quantity
                const itemTotal = cartItem.querySelector('.item-total').getAttribute('data-item-total');  // Item total price

                selectedItems.push({ sid, pid, s_name, p_name, price, quantity, itemTotal });
            });
            //test
            console.log(selectedItems);
            return selectedItems;
        }
        //test
        //getSelectedItems();

        document.querySelector('.checkout-btn').addEventListener('click', function () {
            const selectedItems = getSelectedItems();
            if (selectedItems.length === 0) {
                alert("Please select at least one item to proceed.");
                return;
            }

            localStorage.setItem('cartItems', JSON.stringify(selectedItems));

            window.location.href = 'orderCheckoutPage.php?user_id=' + userId;
        });
    </script>
</body>
</html>
