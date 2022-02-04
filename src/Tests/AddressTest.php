<?php
declare(strict_types=1);

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Entities\Country;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use PHPUnit\Framework\TestCase;
use TypeError;

class AddressTest extends TestCase
{
    private Address $address;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->address = new Address(
            address_type: "customer",
            postal_code: "38714",
            street: "Soborna",
            city: "Poltava",
            country: new Country(
                "UA"
            )
        );
        self::assertSame((bool)$this->address, true);
        parent::__construct($name, $data, $dataName);
    }

    public function test_address_type_invalid_enumeration_exception()
    {
        self::expectException(OutOfEnumException::class);
        $this->address->getAddressType()->set('james_bond');
    }

    public function test_country_pattern_exception()
    {
        self::expectException(OutOfPatternException::class);
        $this->address->getCountry()->set(new Country('NIGERIA'));
    }

    public function test_invalid_types_constructor_exception()
    {
        self::expectException(TypeError::class);
        new Address(
            address_type: "customer", postal_code: "38714", street: "Red", city: "Amsterdam", country: 4
        );
    }


    public function test_set_housenumber()
    {
        $expected = $this->createSimpleField(
            property_name: 'housenumber',
            value: "30"
        );

        $this->address->setHousenumber("30");
        self::assertSame($this->address->getHousenumber()->get(), $expected->get());

    }

    public function test_set_housenumber_updates_address_line()
    {
        $base_housenumber = $this->address->getAddressLine();
        $this->address->setHousenumber("30");
        self::assertNotSame($base_housenumber, $this->address->getAddressLine());
    }

    use SingleFieldTrait;

    public function test_toArray()
    {
        $expected = ["address_type" => "customer",
            "postal_code" => "38714",
            "country" => "UA",
            "city" => "Poltava",
            "street" => "Soborna",
            "address" => "Soborna 30 38714 Poltava",
            "housenumber" => "30"
        ];
        $this->address->setHousenumber("30");
        $real = $this->address->toArray();
        self::assertSame($expected, $real);
    }
}