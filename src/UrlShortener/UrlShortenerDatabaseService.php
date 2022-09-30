<?php

declare(strict_types=1);

namespace UrlShortener;

use Laminas\Db\Sql\Expression;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\AbstractTableGateway;

/**
 * This class provides a set of methods for implementing a small URL shortener
 * service based on the TableGateway pattern.
 */
final class UrlShortenerDatabaseService implements UrlShortenerPersistenceInterface
{
    private AbstractTableGateway $tableGateway;

    public function __construct(AbstractTableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Retrieves the un-shortened URL, based on the shortened URL provided.
     */
    public function getLongUrl(string $shortUrl): string
    {
        $rowSet = $this
            ->tableGateway
            ->select(
                function (Select $select) use ($shortUrl) {
                    $select
                        ->columns(['long'])
                        ->where(['short' => $shortUrl]);
                }
            );

        $record = $rowSet->current();

        return $record['long'];
    }

    /**
     * Checks if a shortened URL in the database matches the one provided
     */
    public function hasShortUrl(string $shortUrl): bool
    {
        $rowSet = $this
            ->tableGateway
            ->select(
                function (Select $select) use ($shortUrl) {
                    $select
                        ->columns(['count' => new Expression("COUNT(*)")])
                        ->where(['short' => $shortUrl]);
                }
            );

        $record = $rowSet->current();

        return (bool)$record['count'];
    }

    /**
     * Stores the short and long URL combination in the database
     */
    public function persistUrl(string $longUrl, string $shortenedUrl): bool
    {
        $insert = new Insert('urls');
        $insert
            ->columns(['long', 'short'])
            ->values([$longUrl, $shortenedUrl]);

        return (bool)$this->tableGateway->insertWith($insert);
    }
}