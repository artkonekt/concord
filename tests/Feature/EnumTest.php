<?php
/**
 * Contains the EnumTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-09-18
 *
 */


namespace Konekt\Concord\Tests\Feature;


use Konekt\Concord\Tests\Modules\ModuleWithEnum\Contracts\WeatherStatus as WeatherStatusContract;
use Konekt\Concord\Tests\Modules\ModuleWithEnum\Models\WeatherStatus;
use Konekt\Concord\Tests\Modules\ModuleWithEnum\Models\WeatherStatusProxy;
use Konekt\Concord\Tests\Modules\ModuleWithEnum\Providers\ModuleServiceProvider as ModuleWithEnum;
use Konekt\Concord\Tests\TestCase;
use Konekt\Concord\Tests\Feature\Enums\ExtWeatherStatus;
use Konekt\Enum\Enum;

class EnumTest extends TestCase
{
    /**
     * @test
     */
    public function module_with_enums_properly_loaded()
    {
        $this->assertArrayHasKey(
            'module_with_enum',
            $this->concord->getModules()->toArray()
        );
    }

    /**
     * @test
     */
    public function module_has_the_enum_registered()
    {
        $this->assertEquals(
            WeatherStatus::class,
            $this->concord->enum(WeatherStatusContract::class)
        );
    }

    /**
     * @test
     */
    public function enum_helper_works_for_module_registered_enums()
    {
        $goodWeather = enum('weather_status', 'good');
        $this->assertInstanceOf(WeatherStatus::class, $goodWeather);
        $this->assertTrue($goodWeather->equals(WeatherStatus::GOOD()));
        $this->assertEquals(WeatherStatus::GOOD, $goodWeather->value());
    }

    /**
     * @test
     */
    public function enum_proxy_returns_proper_instance()
    {
        $this->assertEquals(WeatherStatus::class, WeatherStatusProxy::enumClass());

        $this->assertInstanceOf(Enum::class, WeatherStatusProxy::create('bad'));
    }

    /**
     * @test
     */
    public function enums_can_be_replaced_on_the_fly()
    {
        $this->app->make('concord')->registerEnum(WeatherStatusContract::class, ExtWeatherStatus::class);

        $this->assertInstanceOf(ExtWeatherStatus::class, enum('weather_status', 'good'));
        $this->assertEquals(ExtWeatherStatus::MEH, enum('weather_status', 'meh'));

        $this->assertEquals(
            $this->concord->enum(WeatherStatusContract::class),
            WeatherStatusProxy::enumClass()
        );

        $this->assertInstanceOf(ExtWeatherStatus::class, WeatherStatusProxy::create('good'));
        $this->assertInstanceOf(ExtWeatherStatus::class, WeatherStatusProxy::create('meh'));
    }

    /**
     * @inheritdoc
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('concord.modules', [
            ModuleWithEnum::class
        ]);
    }

}