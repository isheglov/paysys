<?php

namespace App\Service;

interface ServiceInterface
{
    /**
     * @param mixed $request
     * @return mixed
     */
    public function behave($request);
}
