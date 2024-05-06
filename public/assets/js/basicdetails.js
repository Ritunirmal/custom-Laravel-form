//PINCODE API

function fetchData(pincode) {
    fetch(`https://api.postalpincode.in/pincode/${pincode}`)
    .then(response => response.json())
    .then(data => {
        // Check if the API returned valid data
        if (data && data.length > 0 && data[0].Status === "Success") {
            // Extract state, city, and other relevant information
            const state = data[0].PostOffice[0].State;
            const city = data[0].PostOffice[0].District;
            const pincodeValue = data[0].PostOffice[0].Pincode;

            // Update the UI with the extracted data
            document.getElementsByName('state').forEach(element => element.value = state);
            document.getElementsByName('city').forEach(element => element.value = city);
            document.getElementsByName('pincode').forEach(element => element.value = pincodeValue);
        } else {
            console.error("Invalid pincode or data not found");
        }
    })
    .catch(error => {
        console.error("Error fetching data:", error);
    });
}
document.getElementsByName('pincode').forEach(element => {
    element.addEventListener('blur', function() {
        const pincode = this.value.trim(); // Get the pincode entered by the user
        if (pincode) {
            // If pincode is not empty, fetch data
            fetchData(pincode);
        }
    });
});
function fetchDatatwo(pincode) {
    fetch(`https://api.postalpincode.in/pincode/${pincode}`)
    .then(response => response.json())
    .then(data => {
        // Check if the API returned valid data
        if (data && data.length > 0 && data[0].Status === "Success") {
            // Extract state, city, and other relevant information
            const state = data[0].PostOffice[0].State;
            const city = data[0].PostOffice[0].District;
            const pincodeValue = data[0].PostOffice[0].Pincode;

            // Update the UI with the extracted data
            document.getElementsByName('correspondence_state').forEach(element => element.value = state);
            document.getElementsByName('correspondence_city').forEach(element => element.value = city);
            document.getElementsByName('correspondence_pincode').forEach(element => element.value = pincodeValue);
        } else {
            console.error("Invalid pincode or data not found");
        }
    })
    .catch(error => {
        console.error("Error fetching data:", error);
    });
}
// Add event listener to all elements with name 'pin_code'
document.getElementsByName('correspondence_pincode').forEach(element => {
    element.addEventListener('blur', function() {
        const pincode = this.value.trim(); // Get the pincode entered by the user
        if (pincode) {
            // If pincode is not empty, fetch data
            fetchDatatwo(pincode);
        }
    });
});

//NAME VALIDATE IN CAPITALIZATION
const father_name = document.getElementById('father_name');

father_name.addEventListener('input', () => {
    let inputValue = father_name.value;
    // Apply your pattern here, for example, converting to uppercase
    inputValue = inputValue.toUpperCase();
    // Update the input field with the modified value
    father_name.value = inputValue;
});
const mother_name = document.getElementById('mother_name');

mother_name.addEventListener('input', () => {
    let inputValue = mother_name.value;
    // Apply your pattern here, for example, converting to uppercase
    inputValue = inputValue.toUpperCase();
    // Update the input field with the modified value
    mother_name.value = inputValue;
});

const spouse_name = document.getElementById('spouse_name');

spouse_name.addEventListener('input', () => {
    let inputValue = spouse_name.value;
    // Apply your pattern here, for example, converting to uppercase
    inputValue = inputValue.toUpperCase();
    // Update the input field with the modified value
    spouse_name.value = inputValue;
})