<?php

declare(strict_types=1);

namespace UrlShortenerTest;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use UrlShortener\UrlShortenerPersistenceInterface;
use UrlShortener\UrlShortenerService;
use PHPUnit\Framework\TestCase;

class UrlShortenerServiceTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy|UrlShortenerPersistenceInterface $persistence;

    public function setUp(): void
    {
        $this->persistence = $this->prophesize(UrlShortenerPersistenceInterface::class);
    }

    public function testCanGetLongUrlFromShortUrlWhenShortUrlDoesExist()
    {
        $longUrl = "https://www.twilio.com";
        $shortUrl = "MDllNTU3O";

        $this->persistence
            ->getLongUrl($shortUrl)
            ->willReturn($longUrl);

        $shortener = new UrlShortenerService($this->persistence->reveal());
        $this->assertSame(
            $longUrl,
            $shortener->getLongUrl($shortUrl)
        );
    }

    public function testGetLongUrlReturnsEmptyStringWhenShortUrlDoesNotExist()
    {
        $longUrl = "https://www.twilio.com";
        $shortUrl = "MDllNTU3O";

        $this->persistence
            ->getLongUrl($shortUrl)
            ->willReturn('');

        $shortener = new UrlShortenerService($this->persistence->reveal());
        $this->assertSame(
            '',
            $shortener->getLongUrl($shortUrl)
        );
    }

    /**
     * @dataProvider hasShortUrlProvider
     */
    public function testCanTestIfShortUrlExists(
        string $shortUrl,
        bool $shortUrlExists
    ) {
        $this->persistence
            ->hasShortUrl($shortUrl)
            ->willReturn($shortUrlExists);

        $shortener = new UrlShortenerService($this->persistence->reveal());
        $this->assertSame(
            $shortUrlExists,
            $shortener->hasShortUrl($shortUrl)
        );
    }

    public function hasShortUrlProvider(): array
    {
        return [
            ["MDllNTU3O", false],
            ["ZmE0YmE0N", true],
            ["OWY4ZTE5N", false],
            ["MWJlNmUzZ", true],
        ];
    }

    public function testCanCreateShortUrlFromLongUrl()
    {
        $longUrl = "https://www.twilio.com";

        $this->persistence
            ->persistUrl($longUrl, Argument::type('string'))
            ->shouldBeCalled();

        $shortener = new UrlShortenerService($this->persistence->reveal());
        $this->assertMatchesRegularExpression(
            "/(http|https):\/\/([a-zA-Z0-9]{9})/",
            $shortener->getShortUrl($longUrl)
        );
    }
}
