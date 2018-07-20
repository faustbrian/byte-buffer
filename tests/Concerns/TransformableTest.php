<?php

declare(strict_types=1);

/*
 * This file is part of ByteBuffer.
 *
 * (c) Brian Faust <envoyer@pm.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Tests\ByteBuffer\Concerns\Reads;

use BrianFaust\ByteBuffer\ByteBuffer;
use PHPUnit\Framework\TestCase;

/**
 * This is the transformable test class.
 *
 * @author Brian Faust <envoyer@pm.me>
 * @covers \BrianFaust\ByteBuffer\Concerns\Transformable
 */
class TransformableTest extends TestCase
{
    /** @test */
    public function it_should_transform_to_binary()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame('Hello World 😄', $buffer->toBinary());
    }

    /** @test */
    public function it_should_transform_to_hex()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame('48656c6c6f20576f726c6420f09f9884', $buffer->toHex());
    }

    /** @test */
    public function it_should_transform_to_utf8()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame('Hello World 😄', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_transform_to_base64()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame('SGVsbG8gV29ybGQg8J+YhA==', $buffer->toBase64());
    }

    /** @test */
    public function it_should_transform_to_array()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame(str_split('Hello World 😄'), $buffer->toArray());
    }

    /** @test */
    public function it_should_transform_to_string_as_binary()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame('Hello World 😄', $buffer->toString('binary'));
    }

    /** @test */
    public function it_should_transform_to_string_as_hex()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame('48656c6c6f20576f726c6420f09f9884', $buffer->toString('hex'));
    }

    /** @test */
    public function it_should_transform_to_string_as_utf8()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame('Hello World 😄', $buffer->toString('utf8'));
    }

    /** @test */
    public function it_should_transform_to_string_as_base64()
    {
        $buffer = ByteBuffer::new('Hello World 😄');

        $this->assertSame('SGVsbG8gV29ybGQg8J+YhA==', $buffer->toString('base64'));
    }

    /** @test */
    public function it_should_throw_for_invalid_type()
    {
        $this->expectException(\InvalidArgumentException::class);

        ByteBuffer::new('Hello World 😄')->toString('_INVALID_');
    }
}
