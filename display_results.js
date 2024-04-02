// Function to display matching landowners
function displayLandowners(landowners) {
    // Get the element where you want to display landowners
    var landownersContainer = document.getElementById("landowners-container");

    // Clear previous content
    landownersContainer.innerHTML = "";

    // Loop through the list of landowners
    landowners.forEach(function(landowner) {
        // Create a div element to display landowner information
        var landownerDiv = document.createElement("div");
        landownerDiv.classList.add("landowner");

        // Construct HTML content for landowner
        var htmlContent = "<h3>" + landowner.name + "</h3>";
        htmlContent += "<p>Contact: " + landowner.contact + "</p>";
        htmlContent += "<p>Land Details: " + landowner.land_details + "</p>";

        // Set the HTML content for the div
        landownerDiv.innerHTML = htmlContent;

        // Append the div to the container
        landownersContainer.appendChild(landownerDiv);
    });
}

// Function to display nearby cities
function displayNearbyCities(cities) {
    // Get the element where you want to display nearby cities
    var citiesContainer = document.getElementById("cities-container");

    // Clear previous content
    citiesContainer.innerHTML = "";

    // Loop through the list of cities
    cities.forEach(function(city) {
        // Create a div element to display city information
        var cityDiv = document.createElement("div");
        cityDiv.classList.add("city");

        // Construct HTML content for city
        var htmlContent = "<h3>" + city.name + "</h3>";
        htmlContent += "<p>Weather: " + city.weather + "</p>";
        htmlContent += "<p>Land Details: " + city.land_details + "</p>";

        // Set the HTML content for the div
        cityDiv.innerHTML = htmlContent;

        // Append the div to the container
        citiesContainer.appendChild(cityDiv);
    });
}
