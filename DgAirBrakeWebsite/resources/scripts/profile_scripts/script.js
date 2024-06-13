initialize();

function initialize() {

    const profileTabLink = document.getElementById("profile-tab-link");
    const profileTabContent = document.getElementById("Profile");

    profileTabLink.classList.add("active");
    profileTabContent.style.display = 'block';

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