<?php

declare(strict_types=1);

use GingerPluginSdk\Client;
use GingerPluginSdk\ClientOptions;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Entities\Country;
use GingerPluginSdk\Entities\Customer;
use GingerPluginSdk\Entities\Extra;
use GingerPluginSdk\Entities\Line;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Entities\PaymentMethodDetails;
use GingerPluginSdk\Entities\Transaction;
use GingerPluginSdk\Entities\Transactions;

require_once "ClientOptions.php";
require_once "Client.php";

$options = (new ClientOptions())->setEndpoint('api.online.emspay.eu')->setUseBundle(false)->setApiKey("164694cda13340e4b4f61a56ad9f0613");
$client = new Client($options);
$order_builder = $client->getOrderBuilder();


$transactions = new Transactions(
    new Transaction(
        payment_method: 'ideal',
        payment_method_details: new PaymentMethodDetails(
            issuer_id: "15"
        )
    )
);
print_r($transactions->toArray());
exit;
$order = new Order(
    transactions: new Transactions(
        item: new Transaction(
            payment_method: 'ideal'
        )
    )
);
print_r($order->toArray());
exit;

$transaction = new Transaction(
    payment_method: 'ideal'
);
print_r($transaction->toArray());
exit;

$address = new Address(
    address_type: 'customer',
    postal_code: "38714",
    street: "Soborna",
    city: "Poltava",
    country: new Country(
        value: 'UA'
    )
);
$address->setHousenumber("30");


$extra = new Extra(
    platform_name: 'shopware',
    platform_version: '6',
    plugin_name: 'ems-shopware-6',
    plugin_version: '1.1',
    additional_fields: ['sw_order_id' => '5001']
);

$product_line = new Line();
$product_line->setAmount(50.12)
    ->setName('Tea cup')
    ->setCurrency('EUR')
    ->setMerchantOrderLineId('51')
    ->setQuantity(5)
    ->setVatPercentage(21)
    ->setType('physical');
$order_lines = new AbstractCollection(new Line());
$order_lines->add($product_line);

$address->setCountry('UA');
$address->setAddressType('customer');
$address->setHousenumber(10);
$address->setPostalCode('NL 1234');
$address->setAddress();

$customer = new Customer();
$order = $order_builder->createEmptyOrder()
    ->setAmount(15)
    ->setDescription('test')
    ->setExtra($extra)
    ->setOrderLines($order_lines)
    ->setMerchantOrderId('515')
    ->setCustomer($customer);

$result = $order->toArray();

print_r($result);

