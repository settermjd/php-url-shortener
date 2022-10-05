<?php

declare(strict_types=1);

namespace UrlShortener;

final class UrlShortenerService
{
    public const SHORT_URL_LENGTH = 9;
    public const RANDOM_BYTES = 32;

    private UrlShortenerPersistenceInterface $shortenerPersistence;

    public function __construct(
        UrlShortenerPersistenceInterface $urlShortenerPersistence
    ) {
        $this->shortenerPersistence = $urlShortenerPersistence;
    }

    /**
     * Gets a short URL, persists it in the underlying storage mechanism
     * and returns the shortened URL
     */
    public function getShortUrl(string $longUrl): string
    {
        $shortUrl = $this->shortenUrl($longUrl);
        $this
            ->shortenerPersistence
            ->persistUrl($longUrl, $shortUrl);

        return $shortUrl;
    }

    public function hasShortUrl(string $longUrl): bool
    {
        return $this->shortenerPersistence->hasShortUrl($longUrl);
    }

    public function getLongUrl(string $shortUrl): string
    {
        $longUrl = $this
            ->shortenerPersistence
            ->getLongUrl($shortUrl);

        return $longUrl;
    }

    /**
     * Generates a unique, short URL
     */
    protected function shortenUrl(string $longUrl): string
    {
        $shortenedUrl = substr(
            base64_encode(
                sha1(
                    uniqid(
                        random_bytes(self::RANDOM_BYTES),
                        true
                    )
                )
            ),
            0,
            self::SHORT_URL_LENGTH
        );

        return $shortenedUrl;
    }
}