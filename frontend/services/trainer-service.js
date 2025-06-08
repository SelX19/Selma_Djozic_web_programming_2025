document.getElementById("trainerForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const token = localStorage.getItem("token");
    if (!token) {
        alert("Admin not logged in.");
        return;
    }

    const trainer = {
        specialization: document.getElementById("specialization").value,
        experience: parseInt(document.getElementById("experience").value),
        bio: document.getElementById("bio").value,
        rating: parseFloat(document.getElementById("rating").value)
    };

    fetch("http://localhost/your-api/trainer", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + token
        },
        body: JSON.stringify(trainer)
    })
        .then(res => {
            if (!res.ok) throw new Error("Failed to add trainer.");
            return res.json();
        })
        .then(data => {
            alert("Trainer added!");
            closeModal();
            document.getElementById("trainerForm").reset();
            // optionally reload trainer list here
        })
        .catch(err => {
            console.error(err);
            alert("Error adding trainer.");
        });
});
