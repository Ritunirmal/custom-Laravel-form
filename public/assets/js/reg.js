//CALENDER DOB MANIPULATION
document.addEventListener('DOMContentLoaded', function() {
    const disabilitiesRadioGroup = document.getElementsByName('are_you_a_person_with_benchmark_disabilities');
    const exservieRadioGroup = document.getElementsByName('are_you_an_exservicemen');
    const domicileRadioGroup = document.getElementsByName('are_you_domicile_of_uttar_pradesh');

    let minBirthYear = parseInt(document.getElementById('min-birth-year').value);
    const defaultMinBirthYear = minBirthYear; // Store the default minimum birth year
    const maxBirthYear = parseInt(document.getElementById('max-birth-year').value);
    const categorySelect = document.getElementById('category');
  
    
    const exservice = document.getElementById('period_of_service_in_defence');
    const exserviceRadioYes = document.getElementById('are_you_an_exservicemen_Yes');
    const dobInput = document.getElementById('dob');
    const Year = document.getElementById('year');
    const Month = document.getElementById('month');
    const Day = document.getElementById('day');
    // Set initial minimum and maximum dates
    flatpickr("#dob", {
        dateFormat: "d-m-Y",
        minDate: `15-04-${minBirthYear}`,
        maxDate: `15-04-${maxBirthYear}`
    });

    categorySelect.addEventListener('change', updateMinDate);
    disabilitiesRadioGroup.forEach(radio => radio.addEventListener('change', updateMinDate));
    exservieRadioGroup.forEach(radio => radio.addEventListener('change', updateMinDate));
    domicileRadioGroup.forEach(radio => radio.addEventListener('change', updateMinDate));
    exservice.addEventListener('change', updateMinDate);
    function updateMinDate() {
        let yearsToSubtract = defaultMinBirthYear;
        if (exservice.value !== '' && exserviceRadioYes.checked) {
            const extraYearsexservice = parseInt(exservice.options[exservice.selectedIndex].getAttribute(
                'data-extra-years'));
            yearsToSubtract -= extraYearsexservice;
          
        }
        if (categorySelect.value !== '') {
            const extraYearsCategory = parseInt(categorySelect.options[categorySelect.selectedIndex].getAttribute(
                'data-extra-years'));
            yearsToSubtract -= extraYearsCategory;
          
        }

        disabilitiesRadioGroup.forEach(radio => {
            if (radio.checked && radio.getAttribute('data-extra-years')) {
                const extraYearsRadio = parseInt(radio.getAttribute('data-extra-years'));
               
              console.log(extraYearsRadio);
                if (categorySelect.value === 'Unreserved (UR)' && extraYearsRadio !== 0){

                    yearsToSubtract -= 5;
                }
                else if (categorySelect.value === 'Economically Weaker Sections (EWS)'){
                    yearsToSubtract -= 0;
                }
                else{
                    yearsToSubtract -= extraYearsRadio;
                }
               
            }
        });
        console.log(yearsToSubtract);
        if (yearsToSubtract < 1969) {
           
             yearsToSubtract = 1969;
            }
            
        minBirthYear = yearsToSubtract;
        // Clear dobInput value if conditions are met
        if (dobInput.value !== '' && (categorySelect.value !== '' || isAnyRadioChecked(disabilitiesRadioGroup))) {
            dobInput.value = '';
            Year.value = '';
            Month.value = '';
            Day.value = '';
        }

        flatpickr("#dob", {
            dateFormat: "d-m-Y",
            minDate: `15-04-${minBirthYear}`,
            maxDate: `15-04-${maxBirthYear}`
            // You can add more options here
        });
        console.log(minBirthYear);
        console.log(maxBirthYear);
    }

    // Helper function to check if any radio button is checked
    function isAnyRadioChecked(radioGroup) {
        return Array.from(radioGroup).some(radio => radio.checked);
    }
});

const dobInput = document.getElementById('dob');
const ageYearsInput = document.getElementById('year');
const ageMonthsInput = document.getElementById('month');
const ageDaysInput = document.getElementById('day');

dobInput.addEventListener('change', calculateAge);

function calculateAge() {
    const dobParts = dobInput.value.split('-'); // Split the input date string into parts
    const dob = new Date(`${dobParts[2]}-${dobParts[1]}-${dobParts[0]}`); // Parse the date in "yyyy-mm-dd" format
    const today = new Date('2024-04-15'); // Reference date - April 15, 2024

    if (isNaN(dob.getTime()) || dob > today) {
        clearAgeFields();
        return;
    }

    let ageYears = today.getFullYear() - dob.getFullYear();
    let ageMonths = today.getMonth() - dob.getMonth();
    let ageDays = today.getDate() - dob.getDate();

    if (ageDays < 0) {
        ageMonths--;
        ageDays += 30; // Assuming each month has 30 days for simplicity
    }

    if (ageMonths < 0) {
        ageYears--;
        ageMonths += 12;
    }

    ageYearsInput.value = ageYears;
    ageMonthsInput.value = ageMonths;
    ageDaysInput.value = ageDays;
}

function clearAgeFields() {
    ageYearsInput.value = '';
    ageMonthsInput.value = '';
    ageDaysInput.value = '';
}
//NAME VALIDATE IN CAPITALIZATION
const inputField = document.getElementById('name');

inputField.addEventListener('input', () => {
    let inputValue = inputField.value;
    // Apply your pattern here, for example, converting to uppercase
    inputValue = inputValue.toUpperCase();
    // Update the input field with the modified value
    inputField.value = inputValue;
});


