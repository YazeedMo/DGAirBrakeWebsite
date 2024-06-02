<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="resources/styles/registration_styles/style.css">
</head>
<body>

    <h1>Customer Registration</h1>

    <!-- Tabs for navigation between sections -->
    <div class="tabs">
        <button class="tab-button" id="personal-details-tab" onclick="showTab('personal-details-section')">Personal Details</button>
        <button class="tab-button" id="address-info-tab" onclick="showTab('address-info-section')">Address Information</button>
        <button class="tab-button" id="card-details-tab" onclick="showTab('card-details-section')">Card Details</button>
    </div>

    <!-- Form Sections -->
    <div class="form-section" id="personal-details-section">
        <h2>Personal Details</h2>
        <p class="notification" style="display: none;">This is an notification message</p>
        <form id="user-details-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
        </form>
        
    </div>

    <div class="form-section" id="address-info-section" style="display: none;">
        <h2>Address Information</h2>
        <p class="notification" style="display: none;">This is an notification message</p>
        <form id="address-info-form">
            <div class="form-group">
                <label for="address-string">Address:</label>
                <textarea id="address-string" name="address-string" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="area-code">Area Code:</label>
                <input type="text" id="area-code" name="area-code" required>
            </div>
        </form>
    </div>

    <div class="form-section" id="card-details-section" style="display: none;">
        <h2>Card Details</h2>
        <p class="notification" style="display: none;">This is an notification message</p>
        <form id="card-details-form">
            <div class="form-group">
                <label for="card-number">Card Number:</label>
                <input type="text" id="card-number" name="card-number" required>
            </div>
            <div class="form-group">
                <label for="expiration-date">Expiration Date:</label>
                <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/YY" required>
            </div>
            <div class="form-group">
                <label for="card-type">Card Type:</label>
                <select id="card-type" name="card-type" required>
                    <option value="" disabled selected>Select Card Type</option>
                    <option value="visa">Visa</option>
                    <option value="mastercard">Mastercard</option>
                    <option value="amex">American Express</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Navigation Buttons -->
    <div class="navigation">
        <button id="prev-btn" disabled onclick="showPrev()">Previous</button>
        <button id="next-btn" onclick="showNext()">Next</button>
        <button id="submit-btn" onclick="submitForm()">Submit</button>
    </div>

    <script src="resources/scripts/registration_scripts/script.js"></script>
    
</body>
</html>