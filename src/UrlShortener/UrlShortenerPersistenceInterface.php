<?php

namespace UrlShortener;

interface UrlShortenerPersistenceInterface
{
    public function getLongUrl(string $shortUrl): string;
    public function hasShortUrl(string $shortUrl): bool;
    public function persistUrl(string $longUrl, string $shortenedUrl): bool;
}