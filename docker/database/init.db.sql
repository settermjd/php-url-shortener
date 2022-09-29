CREATE TABLE IF NOT EXISTS urls (
    long   TEXT NOT NULL UNIQUE,
    short  CHARACTER(9) NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    PRIMARY KEY (long, short),
    UNIQUE(short, long)
);
