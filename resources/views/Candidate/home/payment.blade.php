@extends('Candidate.Layout.header')

@section('title', 'Home')

@section('content')
<style>
body {
    background-color: #f8f9fa;
    font-family: 'Roboto', sans-serif;
}

.containerpay {
    max-width: 400px;
    margin: 100px auto;
}

.payment-container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

.payment-title {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.payment-form .form-group {
    margin-bottom: 20px;
}

.form-label {
    color: #555;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-size: 16px;
    color: #495057;
    background-color: #fff;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-primary {
    display: block;
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<div class="container containerpay">
    <div class="payment-container">
        <h2 class="payment-title">Make a Payment</h2>
        <form id="paymentForm" class="payment-form">
            <div class="form-group">
                <label for="amount" class="form-label">Amount (INR):</label>
                <input type="number" id="amount" name="amount" class="form-control" value="{{$User->fee}}" required readonly>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-credit-card mr-2"></i>Pay Now</button>
        </form>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        function handlePaymentCallback(response) {
            let amountPay = document.getElementById('amount').value;
            console.log(response);
        if (response.razorpay_payment_id) {
            // Payment successful
            console.log('Payment successful! Payment ID:', response.razorpay_payment_id);
            
             const paymentData = {
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature,
            amount: amountPay,
            // Add other payment data as needed
        };

            fetch('/payment-done', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(paymentData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Payment data stored in the database:', data);
                window.location.replace('/successfully-registered');
                // You can perform additional actions after storing data, such as redirecting to a thank you page
            })
            .catch(error => {
                console.error('Error storing payment data:', error);
                // Handle error if data storage fails
            });
        } else {
            // Payment failed
            console.log('Payment failed!');
            // You can call another function or display an error message
        }
    }
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const amount = document.getElementById('amount').value;
            
            fetch('/create-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ amount: amount }),
            })
            .then(response => response.json())
            .then(data => {
                const options = {
                    key: 'rzp_test_TG5m4hoN590zNR',
                    amount: data.amount,
                    currency: 'INR',
                    order_id: data.order_id,
                    name: 'Your Company Name',
                    description: 'Purchase Description',
                    handler: handlePaymentCallback,
                    prefill: {
                        name: 'Customer Name',
                        email: 'customer@example.com',
                        contact: '9999999999',
                    },
                    notes: {
                        address: 'Customer Address',
                    },
                    theme: {
                        color: '#F37254',
                    },
                };
            
                const rzp = new Razorpay(options);
                rzp.open();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>



@endsection