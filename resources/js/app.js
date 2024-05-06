import './bootstrap';

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
// Example using Flatpickr
flatpickr("#dob", {
    dateFormat: "Y-m-d",
    minDate: "1900-01-01",
    maxDate: "2004-12-31" // Assuming a maximum age of 120 years
});
