// TEAM: This script waits for the page to load, then listens for clicks.
// It creates the "Magic" where the page doesn't reload when you vote.

document.addEventListener("DOMContentLoaded", () => {
    
    // Look for any element with the class "vote-btn"
    const voteButtons = document.querySelectorAll(".vote-btn");

    voteButtons.forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault(); // STOP the browser from reloading the page!

            // Get the Ad ID embedded in the HTML
            const adId = this.getAttribute("data-id");
            const scoreSpan = document.getElementById("score-" + adId);
            const btn = this;

            // Send a secret "Fetch" request to our PHP Controller
            // Note: We use the BASE_URL logic via a relative path
            fetch("/vote/cast", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({ ad_id: adId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    // Update the "???" to the real number instantly
                    scoreSpan.innerText = data.new_score;
                    
                    // Make it look cool (Green text)
                    scoreSpan.classList.remove("text-muted");
                    scoreSpan.classList.add("text-success", "fw-bold");
                    
                    // Disable the button so they can't click again
                    btn.classList.add("disabled", "btn-success");
                    btn.classList.remove("btn-outline-warning");
                    btn.innerText = "Voted!";
                } else {
                    alert(data.message); // Tell them if they aren't logged in
                }
            })
            .catch(error => console.error("System Error:", error));
        });
    });
});