<?php

namespace OhSeeSoftware\LaravelAssertEncrypted\Tests;

use Illuminate\Support\Facades\DB;
use OhSeeSoftware\LaravelAssertEncrypted\Traits\AssertEncrypted;
use PHPUnit\Framework\ExpectationFailedException;

class AssertEncryptedTest extends TestCase
{
    use AssertEncrypted;

    /** @test */
    public function assertEncrypted_is_an_alias_for_assertEncryptedSerialized()
    {
        // Given
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'secret' => encrypt('testing')],
        ]);

        // Then
        $this->assertEncrypted('users', ['id' => 1], [
            'secret' => 'testing'
        ]);
    }

    /** @test */
    public function it_asserts_encrypted_serialized_values_exist_in_the_database()
    {
        // Given
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'secret' => encrypt('testing')],
        ]);

        // Then
        $this->assertEncryptedSerialized('users', ['id' => 1], [
            'secret' => 'testing'
        ]);
    }

    /** @test */
    public function it_asserts_encrypted_serialized_values_among_other_data_in_the_database()
    {
        // Given
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'secret' => encrypt('testing')],
            ['id' => 2, 'name' => 'Jane Doe', 'secret' => encrypt('testing')],
        ]);

        // Then
        $this->assertEncryptedSerialized('users', ['id' => 1], [
            'secret' => 'testing'
        ]);
    }

    /** @test */
    public function it_fails_assertion_when_missing_encrypted_serialized_values()
    {
        // Given
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'secret' => encrypt('testing')],
        ]);

        $this->expectException(ExpectationFailedException::class);

        // Then
        $this->assertEncrypted('users', ['id' => 1], [
            'secret' => 'invalid value'
        ]);
    }

    /** @test */
    public function it_asserts_encrypted_unserialized_values_exist_in_the_database()
    {
        // Given
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'secret' => encrypt('testing', false)],
        ]);

        // Then
        $this->assertEncryptedUnserialized('users', ['id' => 1], [
            'secret' => 'testing'
        ]);
    }

    /** @test */
    public function it_asserts_encrypted_unserialized_values_among_other_data_in_the_database()
    {
        // Given
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'secret' => encrypt('testing', false)],
            ['id' => 2, 'name' => 'Jane Doe', 'secret' => encrypt('testing', false)],
        ]);

        // Then
        $this->assertEncryptedUnserialized('users', ['id' => 1], [
            'secret' => 'testing'
        ]);
    }

    /** @test */
    public function it_fails_assertion_when_missing_encrypted_unserialized_values()
    {
        // Given
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'secret' => encrypt('testing', false)],
        ]);

        $this->expectException(ExpectationFailedException::class);

        // Then
        $this->assertEncryptedUnserialized('users', ['id' => 1], [
            'secret' => 'invalid value'
        ]);
    }
}
