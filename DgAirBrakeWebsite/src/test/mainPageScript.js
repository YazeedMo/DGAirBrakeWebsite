async function getAllProducts() {
    try {
        const response = await fetch('Service.php?action=getAllProducts');
        if (!response.ok) {
            throw new Error("Error fetching data");
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('There was a problem with the fetch operation: ', error);
    }
}

async function setup() {

    const testerDiv = document.getElementById('testerDiv');

    const allProducts = await getAllProducts();

    console.log(allProducts);

}

setup();