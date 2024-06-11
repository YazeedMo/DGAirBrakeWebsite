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