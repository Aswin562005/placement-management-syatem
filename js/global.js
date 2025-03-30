document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const body = document.body;
    const sidebar = document.getElementById("sidebar");

    // themeToggle.addEventListener("click", function () {
    //     body.classList.toggle("dark-mode");
    //     localStorage.setItem()
    // });
    
    const cards = document.querySelectorAll('.announcement-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('show');
        }, index * 200);
    });
});

function handleFormSubmit(formId, url, modalId) {
    $(formId).submit(function (e) {
        e.preventDefault();
        let formData = new FormData(document.querySelector(formId));
        startLoader();
        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            stopLoader();
            $(modalId).modal("hide");
            alert(data.message);
            location.reload();
        })
        .catch(error => {
            stopLoader();
            console.error("Error:", error);
        });
    });
}

function handleButtonClick(url, tableID, buttonClass, action, callback) {
    $(tableID).on('click', buttonClass, function () {
        let Id = $(this).data("id");
        console.log(Id);
        
        startLoader();
        if (action == "delete") {
            if (!confirm('Are you  want to delete this student record ?')) {
                stopLoader();
                return;
            }
        }
        $.post(url, { action: action, id: Id }, callback);
    });
}