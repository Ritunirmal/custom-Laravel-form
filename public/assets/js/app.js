// import './bootstrap';

const flatpickr = require('flatpickr');
require('flatpickr/dist/flatpickr.min.css');

flatpickr("#dob", {
    dateFormat: "Y-m-d",
    minDate: "1900-01-01",
    maxDate: "2004-12-31"
});
