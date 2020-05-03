<?php

namespace OhSeeSoftware\LaravelAssertEncrypted\Traits;

use OhSeeSoftware\LaravelAssertEncrypted\Constraints\HasEncryptedValues;

trait AssertEncrypted
{
    /**
     * Assert that a given where condition exists in the database.
     *
     * @param  string  $table
     * @param  array  $whereData
     * @param  array  $encryptedData
     * @param  string|null  $connection
     * @return $this
     */
    protected function assertEncrypted(string $table, array $whereData, array $encryptedData, $connection = null)
    {
        $this->assertThat(
            $table,
            new HasEncryptedValues($this->getConnection($connection), $whereData, $encryptedData)
        );

        return $this;
    }
}
