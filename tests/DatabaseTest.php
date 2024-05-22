<?php declare(strict_types=1);
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\TestCase;

#[RequiresPhpExtension('pgsql')]
final class DatabaseTest extends TestCase
{
    public function testConnection(): void
    {
        // ...
    }
}