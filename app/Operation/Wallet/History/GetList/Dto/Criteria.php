<?php

namespace App\Operation\Wallet\History\GetList\Dto;

class Criteria
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string|null
     */
    private $dateFrom;

    /**
     * @var string|null
     */
    private $dateTo;

    /**
     * @param string $userId
     * @param string|null $dateFrom
     * @param string|null $dateTo
     */
    public function __construct(string $userId, string $dateFrom = null, string $dateTo = null)
    {
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getDateFrom(): ?string
    {
        return $this->dateFrom;
    }

    /**
     * @return string|null
     */
    public function getDateTo(): ?string
    {
        return $this->dateTo;
    }
}
