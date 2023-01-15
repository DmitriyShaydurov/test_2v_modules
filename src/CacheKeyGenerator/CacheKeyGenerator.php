<?php

namespace test\CacheKeyGenerator;

class CacheKeyGenerator implements CacheKeyGeneratorInterface
{
    /**
     * @param array $input
     * @return array
     */
    public function getKey(array $input): array
    {
        return json_encode($input);
    }
}
