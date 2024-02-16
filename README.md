# NowPayments PHP API Wrapper

This PHP class provides a convenient way to interact with the [NowPayments API](https://nowpayments.io).

## Usage

1. **Installation:**
   - Clone the repository:

     ```bash
     git clone https://github.com/ayhan-dev/Paymen.git
     ```

   - Include the `Pay_API` class in your PHP project:

     ```php
     <?php
     require_once 'path/to/Pay_API.php';

     $apiKey = 'your-api-key';
     $paymentAPI = new Pay_API($apiKey);
     ?>
     ```

2. **Examples:**

   ```php
   // Check API Status
   $status = $paymentAPI->status();

   // Get List of Currencies
   $currencies = $paymentAPI->getCurrencies();

   // Create Payment
   $params = [
   ];
   $payment = $paymentAPI->createPayment($params);
