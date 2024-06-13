async function logout() {

    try {

        const response = await fetch('src/main/controllers/AdminPanelController.php?action=logout');
        if (!response.ok) {
            throw new Error('Empty response');
        }

        const data = await response.json();
        console.log(data);

        window.location.href = data.redirectUrl;

    }
    catch (error) {
        console.log(error);
    }

}

async function getAllProducts() {

    try {
        const response = await fetch('src/main/controllers/AdminPanelController.php?action=getAllProducts');
        if (!response.ok) {
            throw new Error('Empty response');
        }
        const data = await response.json();
        console.log(data);

        const tableBody = document.querySelector('.product-table tbody');
        tableBody.innerHTML = '';  // Clear the table before adding new rows

        for (let i = 0; i < data.length; i++) {
            const product = data[i];
            const row = `
                <tr>
                    <td>${product.productID}</td>
                    <td>${product.productName}</td>
                    <td>${product.description}</td>
                    <td>R${product.price}</td>
                    <td>${product.quantityAvailable}</td>
                    <td><a href="${product.imageURL}" target="_blank">View Image</a></td>
                    <td class="actions">
                        <button class="edit-btn" onclick="editProduct(${product.productID})">Edit</button>
                        <button class="delete-btn" onclick="deleteProduct(${product.productID})">Delete</button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        }


    }
    catch (error) {
        console.log(error);
    }

}

function changeView(viewId) {

    const allViews = document.querySelectorAll('.menu-view');

    allViews.forEach(function(menuView) {
        menuView.style.display = 'none';
    })

    document.getElementById(viewId).style.display = "block";

}

getAllProducts();
