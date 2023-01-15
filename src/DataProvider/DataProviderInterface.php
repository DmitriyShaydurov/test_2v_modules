<?php

namespace test\DataProvider;

interface DataProviderInterface
{
    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request): array;
}
