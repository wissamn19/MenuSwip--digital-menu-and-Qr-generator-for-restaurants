document.addEventListener("DOMContentLoaded", () => {
    const restaurantName = document.getElementById("restaurantName");
    const restaurantLocation = document.getElementById("location");
    const restaurantState = document.getElementById("State");
    const restaurantTypeTags = document.getElementById("type");
    const workingHoursDisplay = document.getElementById("working-hours");
    const mapContainer = document.getElementById("restaurant-map");
    const phonen = document.getElementById("phonen");

    console.log("Fetching restaurant data...");

    fetch("get_restaurant.php", {
        method: 'GET',
        credentials: 'include',  // Ensures session cookies are sent
        headers: {
            'Accept': 'application/json'
          
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Data received:", data);

        if (!data.success) {
            console.error("Error:", data.message);
            return;
        }

        const restaurant = data.data;

        // Ensure elements exist before updating
        if (restaurantName) restaurantName.textContent = restaurant.resturantName || "Unnamed Restaurant";
        if (restaurantLocation) restaurantLocation.textContent = restaurant.location || "Not specified";
        if (restaurantState) restaurantState.textContent = restaurant.State || "Not specified";

        // Update phone number
        if (phonen) {
            if (restaurant.phonen) {
                phonen.href = `tel:${restaurant.phonen}`;
                phonen.style.display = "block"; 
            } else {
                phonen.style.display = "none";
            }
        }

        // Update restaurant type tags
        if (restaurantTypeTags) {
            restaurantTypeTags.innerHTML = restaurant.type
                ? `<span class="tag">${restaurant.type}</span>`
                : `<span class="tag">Casual dining</span><span class="tag">Fast food</span>`;
        }

        // Update working hours
        if (restaurant.starttime && restaurant.endtime) {
            const startTimeInput = document.getElementById("starttime");
            const endTimeInput = document.getElementById("endtime");

            if (startTimeInput) startTimeInput.value = restaurant.starttime;
            if (endTimeInput) endTimeInput.value = restaurant.endtime;
        }

        // Update profile image
        if (restaurant.urlimage) {
            const profileImagePreview = document.getElementById("profile-image-preview");
            if (profileImagePreview) {
                profileImagePreview.innerHTML = "";
                const img = document.createElement("img");
                img.src = restaurant.urlimage;
                img.alt = restaurant.resturantName;
                profileImagePreview.appendChild(img);
            }
        }

        // Load map if location is available
        if (restaurant.location && restaurant.State) {
            fetchGeocodedLocation(restaurant.id, restaurant.location, restaurant.State);
        } else if (mapContainer) {
            mapContainer.innerHTML = `<p>No location information available</p>`;
        }
    })
    .catch(error => console.error("Error fetching restaurant data:", error));
});
