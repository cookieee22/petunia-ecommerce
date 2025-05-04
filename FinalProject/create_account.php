<?php
// create_account.php
session_start();
require 'config.php';

$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $password   = $_POST['password']; // Do not trim passwords!
    $address    = trim($_POST['address']);
    $phone_num  = $_POST['phone_num'];

    // Check if the email already exists
    $stmt = $db->prepare("SELECT USER_ID FROM USER WHERE EMAIL = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "This account has already been made.";
        }
        $stmt->close();
    } else {
        $error = "Server error. Please try again.";
    }

    if ($error === '') {
        // Sanitize phone number (digits only) and format
        $phone_num_clean = preg_replace('/\D/', '', $phone_num);
        $phone_num_clean = substr($phone_num_clean, 0, 9); // Limit to 9 digits

        if (strlen($phone_num_clean) === 9) {
            $formatted_phone = substr($phone_num_clean, 0, 3) . '-' .
                               substr($phone_num_clean, 3, 3) . '-' .
                               substr($phone_num_clean, 6);
        } else {
            $formatted_phone = $phone_num_clean;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $db->prepare("INSERT INTO USER (FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, ADDRESS, PHONE_NUM, ROLE_TYPE, ACCOUNT_CREATION) VALUES (?, ?, ?, ?, ?, ?, 'Customer', NOW())");
        if ($stmt) {
            $stmt->bind_param("ssssss", $first_name, $last_name, $email, $hashedPassword, $address, $formatted_phone);

            if ($stmt->execute()) {
                $new_user_id = $db->insert_id;

                // Assign employee
                $emp_query = "SELECT EMPLOYEE_ID FROM EMPLOYEE WHERE EMPLOYEE_ID NOT IN (1,2,3) ORDER BY RAND() LIMIT 1";
                $result_emp = $db->query($emp_query);
                $employee_id = ($result_emp && $row_emp = $result_emp->fetch_assoc()) ? $row_emp['EMPLOYEE_ID'] : NULL;

                // Create session
                $stmt2 = $db->prepare("INSERT INTO SESSION (USER_ID, EMPLOYEE_ID, ORDERED_AT, TOTAL_AMOUNT, ORDER_STATUS, CREATED_AT) VALUES (?, ?, NULL, 0, 'active', NOW())");
                if ($stmt2) {
                    $stmt2->bind_param("ii", $new_user_id, $employee_id);
                    $stmt2->execute();
                    $new_session_id = $db->insert_id;
                    $stmt2->close();

                    // Update user with session ID
                    $stmt3 = $db->prepare("UPDATE USER SET SESSION_ID = ? WHERE USER_ID = ?");
                    if ($stmt3) {
                        $stmt3->bind_param("ii", $new_session_id, $new_user_id);
                        $stmt3->execute();
                        $stmt3->close();
                    }
                }

                $message = "Account created successfully. You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "Error creating account. Please try again.";
            }
            $stmt->close();
        } else {
            $error = "Server error. Please try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Create Account - Petunia</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form {
            max-width: 300px;
            margin: auto;
            padding-top: 30px;
        }
        label {
            display: block;
            margin-bottom: 6px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
        }
        input[type="submit"] {
            padding: 8px 16px;
        }
        .error {
            color: red;
            text-align: center;
        }
        .message {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Create Account</h2>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="create_account.php">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required>
        
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required>
        
        <label for="phone_num">Phone Number:</label>
        <!-- Using input type= number to accept only digits, also limited input to exactly 9 digits -->
        <input type="number" name="phone_num" id="phone_num" required 
               maxlength="9" 
               oninput="if(this.value.length > 9) this.value = this.value.slice(0,9)"
               title="Please enter exactly 9 digits">
        
        <input type="submit" value="Create Account">
    </form>
</body>
</html>