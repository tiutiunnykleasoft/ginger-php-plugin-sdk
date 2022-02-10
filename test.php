<?php

declare(strict_types=1);

use GingerPluginSdk\Client;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\Country;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Entities\Customer;
use GingerPluginSdk\Properties\Email;
use GingerPluginSdk\Entities\Line;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Entities\OrderLines;
use GingerPluginSdk\Entities\PaymentMethodDetails;
use GingerPluginSdk\Properties\PhoneNumbers;
use GingerPluginSdk\Entities\Transaction;
use GingerPluginSdk\Entities\Transactions;

require_once "src/Client.php";

$client = new Client(
    new ClientOptions(
        endpoint: 'https://api.online.emspay.eu',
        useBundle: false,
        apiKey: ""
    ));

$order = new Order(
    currency: new Currency('UA'),
    amount: 500,
    transactions: new Transactions(
        new Transaction(
            payment_method: 'ideal',
            payment_method_details: new PaymentMethodDetails(
                issuer_id: "15"
            )
        )
    ),
    customer: new Customer(
        address_object: new Address(
            address_type: 'customer',
            postal_code: '12345',
            street: 'Soborna',
            city: 'Poltava',
            country: new Country(
                'UA'
            ),
            property_name: 'additional_address'
        ),
        first_name: 'Alexander',
        last_name: 'Tiutiunnyk',
        email_address: new Email(
            'tutunikssa@gmail.com'
        ),
        gender: 'male',
        phone_numbers: new PhoneNumbers(
            '0951018201'
        ),
        merchant_customer_id: '15',
        birthdate: '1999-09-01',
        locale: 'NL_nl'
    ),
    order_lines: new OrderLines(
        new Line(
            type: 'physical',
            merchant_order_line_id: "5",
            name: 'Milk',
            quantity: 1,
            amount: 1.00,
            vat_percentage: 50,
            currency: new Currency(
                'EUR'
            )
        )
    ),
    description: 'Test Product'
);

try {
    $response = $client->getApiClient()->createOrder($order->toArray());
} catch (Exception $exception) {
    $response = $exception;
}
print_r($response);
