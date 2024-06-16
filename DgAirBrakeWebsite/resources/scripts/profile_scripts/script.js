const usernameLabel = document.getElementById('username');
const emailLabel = document.getElementById('email');
const addressLabel = document.getElementById('address');
const areaCodeLabel = document.getElementById('area-code');
const cardNumberLabel = document.getElementById('card-number');
const cardExpirationDateLabel = document.getElementById('expiration-date');
const cardTypeLabel = document.getElementById('card-type');

const ordersContainer = document.getElementById('Shopping');

initialize();
setProfileData();
displayOrders();

function initialize() {

    const activeTabLink = document.getElementById("shopping-tab-link");
    const activeTabContent = document.getElementById("Shopping");

    activeTabLink.classList.add("active");
    activeTabContent.style.display = 'block';

}

function openTab(event, tabName) {

    var i, tabContent, tabLinks;

    // Get all tab-content elements and hide them
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    // Get all tab-link elements and remove the 'active' class
    tabLinks = document.getElementsByClassName("tab-link");
    for (i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
    }

    // Show the current tab, and add the 'active' class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    event.currentTarget.classList.add("active");

}

function toggleAccordion(event) {
    var panel = event.target.nextElementSibling;
    var accordionBtn = event.target;

    // Toggle the panel visibility
    panel.classList.toggle("show");

    // Change accordion button text based on panel visibility
    if (panel.classList.contains("show")) {
        accordionBtn.textContent = "Close";
    } else {
        accordionBtn.textContent = "Expand";
    }
}

async function logout() {

    try {

        const response = await fetch('src/main/controllers/ProfileController.php?action=logout');
        if (!response.ok) {
            throw new Error('Empty response');
        }
        location.reload();

    }
    catch (error) {
        console.log(error);
    }

}

async function setProfileData() {

    try {
        const response = await fetch('src/main/controllers/ProfileController.php?action=getCustomerDetails');
        if (!response.ok) {
            throw new Error('Error fetching data');
        }
        const data = await response.json();

        usernameLabel.textContent = data.customerUsername;
        emailLabel.textContent = data.customerEmail;
        addressLabel.textContent = data.addressString;
        areaCodeLabel.textContent = data.areaCode;
        cardNumberLabel.textContent = maskCardNumber(data.cardNumber);
        cardExpirationDateLabel.textContent = data.cardExpirationDate;
        cardTypeLabel.textContent = data.cardType;


    }
    catch (error) {
        console.error('There was a problem with fetch operation: ', error);
    }

}

function maskCardNumber(cardNumber) {
    // Ensure cardNumber is a string
    const cardNumberStr = cardNumber.toString();
    
    // Get the last 4 digits
    const last4Digits = cardNumberStr.slice(-4);
    
    // Calculate the number of asterisks needed
    const asterisks = '*'.repeat(cardNumberStr.length - 4);
    
    // Concatenate the asterisks with the last 4 digits
    return asterisks + last4Digits;
}

async function getShoppingInformation() {

    try {
        const response = await fetch('src/main/controllers/ProfileController.php?action=getOrders');
        if (!response.ok) {
            throw new Error('Error fetching data');
        }
        const data = await response.json();
        return data;

    }
    catch (error) {
        console.error('There was a problem with the fetch operation: ', error);
    }

}


async function displayOrders() {

    const allOrders = await getShoppingInformation();

    allOrders.forEach(order => {

        console.log(order);

        const orderObject = document.createElement('div');
        orderObject.classList.add('order');

        // Create the order header div
        const orderHeader = document.createElement('div');
        orderHeader.classList.add('order-header');

        // Create the individual elements
        const orderIdP = document.createElement('p');
        orderIdP.innerHTML = `<strong>Order ID:</strong> <span>${order.orderID}</span>`;

        const orderDateP = document.createElement('p');
        orderDateP.innerHTML = `<strong>Order Date:</strong> <span>${order.orderDate}</span>`;

        const totalAmountP = document.createElement('p');
        totalAmountP.innerHTML = `<strong>Total Amount:</strong> <span>${order.totalAmount}</span>`;

        const orderStatusP = document.createElement('p');
        orderStatusP.innerHTML = `<strong>Order Status:</strong> <span>${order.orderStatus}</span>`;

        // Append the elements to the order header
        orderHeader.appendChild(orderIdP);
        orderHeader.appendChild(orderDateP);
        orderHeader.appendChild(totalAmountP);
        orderHeader.appendChild(orderStatusP);
        orderObject.appendChild(orderHeader);

        // Append the order header to the orders container
        ordersContainer.appendChild(orderObject);

    });
    
}