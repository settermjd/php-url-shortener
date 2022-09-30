<?php

namespace UrlShortenerTest;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use PHPUnit\Framework\TestCase;
use UrlShortener\UrlShortenerDatabaseService;

class UrlShortenerTableGatewayTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy|Adapter $adapter;

    public function testCanRetrieveLongUrlIfItExists()
    {
        $longUrl = "https://www.twilio.com";
        $shortUrl = "https://MDllNTU3O";

        /** @var ObjectProphecy|ResultSetInterface $rowSet */
        $rowSet = $this->prophesize(ResultSetInterface::class);
        $rowSet
            ->current()
            ->willReturn([
                'long' => $longUrl,
            ]);

        $this->tableGateway = $this->prophesize(AbstractTableGateway::class);
        $this->tableGateway
            ->select(Argument::any())
            ->willReturn($rowSet->reveal());

        $shortener = new UrlShortenerDatabaseService(
            $this->tableGateway->reveal()
        );

        $this->assertSame($longUrl, $shortener->getLongUrl($shortUrl));
    }

    /**
     * @dataProvider hasShortUrlProvider
     */
    public function testCanCheckIfShortUrlExists(int $count, bool $hasShortUrl)
    {
        $shortUrl = "https://MDllNTU3O";

        /** @var ObjectProphecy|ResultSetInterface $rowSet */
        $rowSet = $this->prophesize(ResultSetInterface::class);
        $rowSet
            ->current()
            ->willReturn([
                'count' => $count,
            ]);

        $this->tableGateway = $this->prophesize(AbstractTableGateway::class);
        $this->tableGateway
            ->select(Argument::any())
            ->willReturn($rowSet->reveal());

        $shortener = new UrlShortenerDatabaseService(
            $this->tableGateway->reveal()
        );

        $this->assertSame($hasShortUrl, $shortener->hasShortUrl($shortUrl));
    }

    public function hasShortUrlProvider(): array
    {
        return [
            [0, false],
            [1, true],
            [2, true],
        ];
    }

    /**
     * @dataProvider persistUrlProvider
     */
    public function testCanPersistUrl(int $affectedRows, bool $canPersistUrl)
    {
        $longUrl = "https://www.twilio.com";
        $shortUrl = "https://MDllNTU3O";

        $this->tableGateway = $this->prophesize(AbstractTableGateway::class);
        $this->tableGateway
            ->insertWith(Argument::any())
            ->willReturn($affectedRows);

        $shortener = new UrlShortenerDatabaseService(
            $this->tableGateway->reveal()
        );

        $this->assertSame(
            $canPersistUrl,
            $shortener->persistUrl($longUrl, $shortUrl)
        );
    }

    public function persistUrlProvider(): array
    {
        return [
            [1, true],
            [0, false]
        ];
    }
}
