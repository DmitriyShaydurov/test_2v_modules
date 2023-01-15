<?php

namespace test\CacheKeyGenerator;

interface CacheKeyGeneratorInterface
{
    /**
     * @param array $input
     * @return string
     */
    public function getKey(array $input): string;
}
