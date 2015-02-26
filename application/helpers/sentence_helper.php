<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Return first sentence
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('first_sentence'))
{
	function first_sentence($str)
	{
        $pos = strpos($str, '.');
        return substr($str, 0, $pos+1);
	}
}

/**
 * Return first and second sentence
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('firstsecond_sentence'))
{
	function firstsecond_sentence($str)
	{
        $pos = strpos($str, '.');
         if($pos)
         { //if there's a dot in our soruce text do
           $offset = $pos + 1; //prepare offset
           $position2 = stripos ($str, '.', $offset); //find second dot using offset
           $first_two = substr($str, 0, $position2+1); //put two first sentences under $first_two
   
         }
      return $first_two;
	}
}