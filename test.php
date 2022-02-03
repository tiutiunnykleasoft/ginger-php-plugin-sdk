<?php

use GingerPluginSdk\Client;
use GingerPluginSdk\ClientOptions;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Entities\Customer;
use GingerPluginSdk\Entities\Extra;
use GingerPluginSdk\Entities\Line;

require_once "ClientOptions.php";
require_once "Client.php";

$options = (new ClientOptions())->setEndpoint('api.online.emspay.eu')->setUseBundle(false)->setApiKey("164694cda13340e4b4f61a56ad9f0613");
$client = new Client($options);
$order_builder = $client->getOrderBuilder();

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

$address = new Address();
$address->setCountry('UA');
$address->setAddressType('customer');
$address->setHousenumber(10);
$address->setPostalCode('NL 1234');
$address->setAddress();

$customer = new Customer(phone_numbers: ['0951018201'], address: $address);
$order = $order_builder->createEmptyOrder()
    ->setAmount(15)
    ->setDescription('test')
    ->setExtra($extra)
    ->setOrderLines($order_lines)
    ->setMerchantOrderId('515')
    ->setCustomer($customer);


$result = $order->toArray();
print_r($result);