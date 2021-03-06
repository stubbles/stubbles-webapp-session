<?php
/**
 * This file is part of stubbles.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  stubbles\webapp\session
 */
namespace stubbles\webapp\session\storage;
/**
 * Interface for session storages.
 *
 * @since  2.0.0
 */
interface SessionStorage
{
    /**
     * removes all data from storage
     *
     * @return  SessionStorage
     */
    public function clear();

    /**
     * checks whether a value associated with key exists
     *
     * @param   string  $key  key where value is stored under
     * @return  bool
     */
    public function hasValue($key);

    /**
     * returns a value associated with the key or the default value
     *
     * @param   string  $key  key where value is stored under
     * @return  mixed
     */
    public function value($key);

    /**
     * stores a value associated with the key
     *
     * @param   string  $key    key to store value under
     * @param   mixed   $value  data to store
     * @return  SessionStorage
     */
    public function putValue($key, $value);

    /**
     * removes a value from the storage
     *
     * @param   string  $key  key where value is stored under
     * @return  SessionStorage
     */
    public function removeValue($key);

    /**
     * return an array of all keys registered in this storage
     *
     * @return  string[]
     */
    public function valueKeys();
}
