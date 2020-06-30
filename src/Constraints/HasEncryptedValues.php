<?php

namespace OhSeeSoftware\LaravelAssertEncrypted\Constraints;

use Illuminate\Database\Connection;
use PHPUnit\Framework\Constraint\Constraint;

class HasEncryptedValues extends Constraint
{
    /**
     * The database connection.
     *
     * @var \Illuminate\Database\Connection
     */
    protected $database;

    /**
     * The data that will be used to narrow the search in the database table.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new constraint instance.
     *
     * @param  \Illuminate\Database\Connection  $database
     * @param  array  $whereData
     * @param  array  $encryptedData
     * @return void
     */
    public function __construct(Connection $database, array $whereData, array $encryptedData)
    {
        $this->whereData = $whereData;
        $this->encryptedData = $encryptedData;
        $this->database = $database;
    }

    /**
     * Check if the data is found in the given table.
     *
     * @param  string  $table
     * @return bool
     */
    public function matches($table): bool
    {
        $columns = array_keys($this->encryptedData);

        return $this->database
            ->table($table)
            ->where($this->whereData)
            ->get($columns)
            ->contains(function ($result) use ($columns) {
                return collect($columns)
                    ->every(function ($column) use ($result) {
                        $expected = $this->encryptedData[$column] ?? null;
                        $actual = decrypt($result->$column);
                        return $expected == $actual;
                    });
            });
    }

    /**
     * Get the description of the failure.
     *
     * @param  string  $table
     * @return string
     */
    public function failureDescription($table): string
    {
        return sprintf(
            "a row in the table [%s] matches the encrypted attributes %s",
            $table,
            json_encode($this->encryptedData),
            $this->toString(JSON_PRETTY_PRINT)
        );
    }

    /**
     * Get a string representation of the object.
     *
     * @param  int  $options
     * @return string
     */
    public function toString($options = 0): string
    {
        return json_encode($this->data, $options);
    }
}
