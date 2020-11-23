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
        return $this->assertEncryptedSerialized($table, $whereData, $encryptedData, $connection);
    }

    /**
     * Assert that a given where condition exists in the database.
     *
     * @param string $table
     * @param array $whereData
     * @param array $encryptedData
     * @param null $connection
     * @return $this
     */
    protected function assertEncryptedSerialized(
        string $table,
        array $whereData,
        array $encryptedData,
        $connection = null
    ) {
        $this->assertThat(
            $table,
            new HasEncryptedValues($this->getConnection($connection), $whereData, $encryptedData, true)
        );

        return $this;
    }

    /**
     * Assert that a given where condition exists in the database.
     *
     * @param string $table
     * @param array $whereData
     * @param array $encryptedData
     * @param null $connection
     * @return $this
     */
    protected function assertEncryptedUnserialized(
        string $table,
        array $whereData,
        array $encryptedData,
        $connection = null
    ) {
        $this->assertThat(
            $table,
            new HasEncryptedValues($this->getConnection($connection), $whereData, $encryptedData, false)
        );

        return $this;
    }
}
