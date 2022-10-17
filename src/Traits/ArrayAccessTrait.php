<?php
declare(strict_types=1);

/**
 * ASCII Table
 *
 * @package   MarcinOrlowski\AsciiTable
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2022 Marcin Orlowski
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/MarcinOrlowski/php-ascii-table
 */

namespace MarcinOrlowski\AsciiTable\Traits;

use MarcinOrlowski\AsciiTable\ArrayableContract;
use Traversable;

/**
 * implements ContainerContract;
 */
trait ArrayAccessTrait
{
    /** @inheritDoc */
    public function count(): int
    {
        return \count($this->container);
    }

    /* ****************************************************************************************** */

    /** @inheritDoc */
    public function getIterator(): Traversable
    {
        return $this->container instanceof Traversable
            ? $this->container->getIterator()
            : new \ArrayIterator($this->container);
    }

    /* ****************************************************************************************** */

    /** @inheritDoc */
    public function offsetExists(mixed $offset): bool
    {
        /** @var string|int $offset */
        return $this->container instanceof \ArrayAccess
            ? $this->container->offsetExists($offset)
            : \array_key_exists($offset, $this->container);
    }

    /** @inheritDoc */
    public function offsetGet(mixed $offset): mixed
    {
        /** @var string|int $offset */
        return $this->container instanceof \ArrayAccess
            ? $this->container->offsetGet($offset)
            : $this->container[ $offset ];
    }

    /**
     * @inheritDoc
     *
     * @throws \InvalidArgumentException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
//        if (!($value instanceof Row)) {
//            throw new \InvalidArgumentException(
//                \sprintf('Expected instance of %s, got %s', Row::class, \get_debug_type($value)));
//        }

        if ($this->container instanceof \ArrayAccess) {
            $this->container->offsetSet($offset, $value);
        } else {
            if ($offset === null) {
                $this->container[] = $value;
            } else {
                /** @var string|int $offset */
                $this->container[ $offset ] = $value;
            }
        }
    }

    /** @inheritDoc */
    public function offsetUnset(mixed $offset): void
    {
        /** @var string|int $offset */
        if ($this->container instanceof \ArrayAccess) {
            $this->container->offsetUnset($offset);
        } else {
            unset($this->container[ $offset ]);
        }
    }

    /* ****************************************************************************************** */

    /** @inheritDoc */
    public function toArray(): array
    {
        return $this->container instanceof ArrayableContract
            ? $this->container->toArray()
            : $this->container;
    }

    /* ****************************************************************************************** */

}
