// Function to generate random product data
function generateRandomProduct() {
    const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    let randomProdID = '';
    let randomName = '';
    let randomDescription = '';
    let randomPrice = (Math.random() * 100).toFixed(2);
    let randomQuantity = Math.floor(Math.random() * 100);
    let randomImageURL = 'https://via.placeholder.com/150'; // Placeholder image URL

    // Generate random ProdID (6 characters)
    for (let i = 0; i < 6; i++) {
        randomProdID += letters.charAt(Math.floor(Math.random() * letters.length));
    }

    // Generate random Name (10 characters)
    for (let i = 0; i < 10; i++) {
        randomName += letters.charAt(Math.floor(Math.random() * letters.length));
    }

    // Generate random Description (20 characters)
    for (let i = 0; i < 20; i++) {
        randomDescription += letters.charAt(Math.floor(Math.random() * letters.length));
    }

    return { randomProdID, randomName, randomDescription, randomPrice, randomQuantity, randomImageURL };
}

// Function to generate and insert random rows into the table
function insertRandomRows() {
    const tableBody = document.querySelector('.product-table tbody');

    // Generate and insert three random rows
    for (let i = 0; i < 3; i++) {
        const product = generateRandomProduct();
        const row = `
            <tr>
                <td>${product.randomProdID}</td>
                <td>${product.randomName}</td>
                <td>${product.randomDescription}</td>
                <td>$${product.randomPrice}</td>
                <td>${product.randomQuantity}</td>
                <td><a href="${product.randomImageURL}" target="_blank">View Image</a></td>
                <td class="actions">
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', row);
    }
}

// Call the function to insert random rows when the page loads
window.onload = insertRandomRows;
