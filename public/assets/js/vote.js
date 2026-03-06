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

            // Prevent double-tap / multiple requests (fixes visual bug)
            if (btn.disabled) return;
            btn.disabled = true;

            // Send a secret "Fetch" request to our PHP Controller
            // Note: We use the BASE_URL logic via a relative path
            // TEAM - Sarra : J'ai mis à jour le chemin fetch pour que ça marche sur WAMP Localhost !
            // On doit passer par index.php obligatoirement.
            fetch("index.php?url=vote/cast", {
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
                    
                    // Make the score look cool (Green text)
                    scoreSpan.classList.remove("text-muted");
                    scoreSpan.classList.add("text-success", "fw-bold");
                    
                    // ARCHITECT UPDATE: Toggle Logic (Vote vs Unvote)
                    if (data.action === 'voted') {
                        // Turn Green if we just voted
                        btn.classList.remove("btn-warning", "btn-outline-warning");
                        btn.classList.add("btn-success");
                        btn.innerText = "✅ VOTED";
                    } else {
                        // Turn back to Orange if we unvoted (Regret)
                        btn.classList.remove("btn-success");
                        btn.classList.add("btn-warning");
                        btn.innerText = "🔥 ATTACK";
                    }
                    
                } else {
                    alert(data.message); // Tell them if they aren't logged in
                }
            })
            .catch(error => console.error("System Error:", error))
            .finally(() => { btn.disabled = false; });
        });
    });
});