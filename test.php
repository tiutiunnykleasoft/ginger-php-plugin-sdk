<?php

declare(strict_types=1);

use GingerPluginSdk\Client;
use GingerPluginSdk\Collections\AdditionalAddresses;
use GingerPluginSdk\Collections\OrderLines;
use GingerPluginSdk\Collections\PhoneNumbers;
use GingerPluginSdk\Collections\Transactions;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Entities\Extra;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\Country;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Entities\Customer;
use GingerPluginSdk\Properties\Email;
use GingerPluginSdk\Entities\Line;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Entities\PaymentMethodDetails;
use GingerPluginSdk\Entities\Transaction;

require_once "vendor/autoload.php";

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
            paymentMethod: 'ideal',
            paymentMethodDetails: new PaymentMethodDetails(
                issuer_id: "15"
            )
        )
    ),
    customer: new Customer(
        additional_addresses: new AdditionalAddresses(
            new Address(
                addressType: 'customer',
                postalCode: '12345',
                street: 'Soborna',
                city: 'Poltava',
                country: new Country(
                    'UA'
                )
            ),
            new Address(
                addressType: 'billing',
                postalCode: '1234567',
                street: 'Donauweg',
                city: 'Amsterdam',
                country: new Country(
                    'NL'
                ),
                housenumber: "10"
            )
        ),
        firstName: 'Alexander',
        lastName: 'Tiutiunnyk',
        email_address: new Email(
            'tutunikssa@gmail.com'
        ),
        gender: 'male',
        phoneNumbers: new PhoneNumbers(
            '0951018201'
        ),
        merchantCustomerId: '15',
        birthdate: '1999-09-01',
        locale: new \GingerPluginSdk\Properties\Locale(
            'Ua_ua'

        )
    ),
    orderLines: new OrderLines(
        new Line(
            type: 'physical',
            merchantOrderLineId: "5",
            name: 'Milk',
            quantity: 1,
            amount: 1.00,
            vatPercentage: 50,
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
        platformName: 'docker',
        platformVersion: '1',
        pluginName: 'ginger-plugin-sdk',
        pluginVersion: '1.0.0'
    )
);

try {
    $client->setOrder($order);
    $response = $client->sendOrder();
} catch (Exception $e) {
    print_r($e);
}

print_r($response);