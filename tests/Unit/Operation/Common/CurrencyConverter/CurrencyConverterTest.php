<?php

namespace App\Operation\Common\CurrencyConverter;

use App\Models\Rate;
use App\Repositories\RateRepositoryInterface;
use Tests\TestCase;

final class CurrencyConverterTest extends TestCase
{
    /**
     * @test
     */
    public function convert()
    {
        $converter = $this->createConverter();

        $actualAmount = $converter->convert(100, 'eur', 'usd');

        self::assertEquals(150, $actualAmount);
    }

    /**
     * @return CurrencyConverter
     */
    private function createConverter(): CurrencyConverter
    {
        return new CurrencyConverter($this->createRateRepository());
    }

    /**
     * @return RateRepositoryInterface
     */
    private function createRateRepository(): RateRepositoryInterface
    {
        $mock = $this->createMock(RateRepositoryInterface::class);

        $mock
            ->expects(self::at(0))
            ->method('findByCurrency')
            ->with('eur')
            ->willReturn($this->createRate())
        ;

        return $mock;
    }

    /**
     * @return Rate
     */
    private function createRate(): Rate
    {
        $rate = new Rate();

        $rate->rate = 1.5;

        return $rate;
    }
}
