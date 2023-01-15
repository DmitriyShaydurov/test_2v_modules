<?php

namespace test\Manger;

use DateTime;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Cache\CacheItemPoolInterface;
use test\DataProvider\DataProviderInterface;
use test\CacheKeyGenerator\CacheKeyGeneratorInterface;

class Manager
{
    protected $cache;
    protected $logger;
    protected $dataProvider;
    protected $cacheKeyGenerator;

    protected const EXPIRE = '+1 day';

    /**
     * @param LoggerInterface $logger
     * @param CacheItemPoolInterface $cache
     * @param DataProviderInterface $dataProvider
     * @param CacheKeyGeneratorInterface $cacheKeyGenerator
     */
    public function __construct(
        LoggerInterface $logger,
        CacheItemPoolInterface $cache,
        DataProviderInterface $dataProvider,
        CacheKeyGeneratorInterface $cacheKeyGenerator
    ) {
        $this->logger = $logger;
        $this->cache = $cache;
        $this->dataProvider = $dataProvider;
        $this->cacheKeyGenerator = $cacheKeyGenerator;
    }

    /**
     * @param array $input
     * @return array
     */
    public function getResponse(array $input): array
    {
        try {
            $cacheKey = $this->cacheKeyGenerator->getKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = $this->dataProvider->get($input);

            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify(self::EXPIRE)
                );

            return $result;
        } catch (Exception $e) {
            $this->logger->critical('Error');
        }

        return ['error'=> 'API error'];
    }
}
