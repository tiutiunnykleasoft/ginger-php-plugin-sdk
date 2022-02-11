<?php

declare(strict_types=1);

use GingerPluginSdk\Client;
use GingerPluginSdk\Entities\AdditionalAddresses;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Entities\Extra;
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
    currency: new Currency('EUR'),
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
        additional_addresses: new AdditionalAddresses(
            new Address(
                address_type: 'customer',
                postal_code: '12345',
                street: 'Soborna',
                city: 'Poltava',
                country: new Country(
                    'UA'
                )
            )
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
        locale: new \GingerPluginSdk\Properties\Locale(
            'Ua-Ua'
        )
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
    description: 'Test Product',
    extra: new Extra(
        ['sw_order_id' => 501]
    ),
    client: new \GingerPluginSdk\Entities\Client(
        user_agent: $_SERVER['HTTP_USER_AGENT'],
        platform_name: 'docker',
        platform_version: '1',
        plugin_name: 'ginger-plugin-sdk',
        plugin_version: '1.0.0'
    )
);

try {
    $client->setOrder($order);
    $response = $client->sendOrder();
} catch (Exception $e) {
    print_r($e);
}

print_r($response);
