<?php namespace iWedmak\StreamSearch;

interface StreamSearchInterface
{
    public static function page($url, $cache, $client);
    public static function search($url, $cache, $client);
}