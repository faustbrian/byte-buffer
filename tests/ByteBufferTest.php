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

namespace BrianFaust\Tests\ByteBuffer;

use BrianFaust\ByteBuffer\ByteBuffer;
use PHPUnit\Framework\TestCase;

/**
 * This is the length map test class.
 *
 * @author Brian Faust <envoyer@pm.me>
 * @covers \BrianFaust\ByteBuffer\ByteBuffer
 */
class ByteBufferTest extends TestCase
{
    /** @test */
    public function it_should_get_the_value_at_the_given_offset()
    {
        $buffer = ByteBuffer::new('Hello World');

        $this->assertSame('e', $buffer->__get(1));
    }

    /** @test */
    public function it_should_set_the_value_at_the_given_offset()
    {
        $buffer = ByteBuffer::new('Hello World');
        $buffer->__set(1, 'X');

        $this->assertSame('X', $buffer->__get(1));
    }

    /** @test */
    public function it_should_check_if_the_offset_exists()
    {
        $buffer = ByteBuffer::new('Hello World');

        $this->assertTrue($buffer->__isset(1));
    }

    /** @test */
    public function it_should_unset_the_value_at_the_given_offset()
    {
        $buffer = ByteBuffer::new('Hello World');
        $buffer->__unset(1);

        $this->assertFalse($buffer->__isset(1));
    }

    /** @test */
    public function it_should_initialise_from_array()
    {
        $buffer = ByteBuffer::new(str_split('Hello World'));

        $this->assertInstanceOf(ByteBuffer::class, $buffer);
        $this->assertSame(11, $buffer->capacity());
    }

    /** @test */
    public function it_should_initialise_from_integer()
    {
        $buffer = ByteBuffer::new(11);

        $this->assertInstanceOf(ByteBuffer::class, $buffer);
        $this->assertSame(11, $buffer->capacity());
    }

    /** @test */
    public function it_should_initialise_from_string()
    {
        $buffer = ByteBuffer::new('Hello World');

        $this->assertInstanceOf(ByteBuffer::class, $buffer);
        $this->assertSame(11, $buffer->capacity());
    }

    /** @test */
    public function it_should_allocate_the_given_number_of_bytes()
    {
        $buffer = ByteBuffer::allocate(11);

        $this->assertInstanceOf(ByteBuffer::class, $buffer);
        $this->assertSame(11, $buffer->capacity());
    }

    /** @test */
    public function it_should_initialise_the_buffer()
    {
        $buffer = ByteBuffer::allocate(11);
        $buffer->initializeBuffer(11, 'Hello World');

        $this->assertSame('Hello World', $buffer->toUTF8());
        $this->assertSame(11, $buffer->capacity());
    }

    /** @test */
    public function it_should_pack_the_given_value()
    {
        $buffer = ByteBuffer::allocate(11);
        $buffer->pack('C', 255, 0);

        $this->assertSame(255, unpack('C', $buffer->offsetGet(0))[1]);
    }

    /** @test */
    public function it_should_unpack_the_given_value()
    {
        $buffer = ByteBuffer::allocate(11);
        $buffer->pack('C', 255, 0);
        $buffer->position(0);

        $this->assertSame(255, $buffer->unpack('C'));
    }

    /** @test */
    public function it_should_get_the_value()
    {
        $buffer = ByteBuffer::allocate(11);
        $buffer->pack('C', 255, 0);

        $this->assertSame(255, unpack('C', $buffer->get(0))[1]);
    }

    /** @test */
    public function it_should_concat_the_given_buffers()
    {
        $hello = ByteBuffer::new('Hello');
        $world = ByteBuffer::new('World');

        $buffer = ByteBuffer::concat($hello, $world);

        $this->assertSame('HelloWorld', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_append_the_given_buffer()
    {
        $buffer = ByteBuffer::new('Hello');
        $buffer->append(ByteBuffer::new('World'));

        $this->assertSame('HelloWorld', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_append_the_given_string()
    {
        $buffer = ByteBuffer::new('Hello');
        $buffer->append('World');

        $this->assertSame('HelloWorld', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_append_the_given_buffer_to_another()
    {
        $buffer = ByteBuffer::new('Hello');

        ByteBuffer::new('World')->appendTo($buffer);

        $this->assertSame('HelloWorld', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_prepend_the_given_buffer()
    {
        $buffer = ByteBuffer::new('World');
        $buffer->prepend(ByteBuffer::new('Hello'));

        $this->assertSame('HelloWorld', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_prepend_the_given_string()
    {
        $buffer = ByteBuffer::new('World');
        $buffer->prepend('Hello');

        $this->assertSame('HelloWorld', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_prepend_the_given_buffer_to_another()
    {
        $buffer = ByteBuffer::new('World');

        ByteBuffer::new('Hello')->prependTo($buffer);

        $this->assertSame('HelloWorld', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_fill_the_buffer_with_the_given_number_of_bytes()
    {
        $buffer = ByteBuffer::new(1);
        $buffer->fill(11);

        $this->assertSame(11, $buffer->capacity());
    }

    /** @test */
    public function it_should_flip_the_limit_and_offset()
    {
        $buffer = ByteBuffer::new(10);
        $buffer->flip();

        $this->assertSame(10, $buffer->capacity());
        $this->assertSame(0, $buffer->current());
    }

    /** @test */
    public function it_should_set_the_byte_order()
    {
        $buffer = ByteBuffer::new(1);
        $buffer->order(0);

        $this->assertTrue($buffer->isBigEndian());
    }

    /** @test */
    public function it_should_reverse_the_buffer_contents()
    {
        $buffer = ByteBuffer::new('Hello World');
        $buffer->reverse();

        $this->assertSame('dlroW olleH', $buffer->toUTF8());
    }

    /** @test */
    public function it_should_slice_the_buffer_contents()
    {
        $buffer = ByteBuffer::new('Hello World');

        $this->assertSame(str_split('Hello'), $buffer->slice(0, 5));
    }

    /** @test */
    public function it_should_test_if_the_given_value_is_a_byte_buffer()
    {
        $buffer = ByteBuffer::allocate(11);

        $this->assertTrue($buffer->isByteBuffer($buffer));
    }

    /** @test */
    public function it_should_test_if_the_buffer_is_big_endian()
    {
        $buffer = ByteBuffer::allocate(11);
        $buffer->order(0);

        $this->assertTrue($buffer->isBigEndian());
    }

    /** @test */
    public function it_should_test_if_the_buffer_is_little_endian()
    {
        $buffer = ByteBuffer::allocate(11);
        $buffer->order(1);

        $this->assertTrue($buffer->isLittleEndian());
    }

    /** @test */
    public function it_should_test_if_the_buffer_is_machine_byte()
    {
        $buffer = ByteBuffer::allocate(11);
        $buffer->order(2);

        $this->assertTrue($buffer->isMachineByte());
    }

    /** @test */
    public function it_should_test_if_the_given_value_exceeds_the_maximum()
    {
        $buffer = ByteBuffer::allocate(11);

        $this->expectException(\InvalidArgumentException::class);

        $buffer->checkForExcess(0xff, 0xffff);
    }
}