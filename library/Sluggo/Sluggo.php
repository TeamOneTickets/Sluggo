<?php

/**
 * Sluggo
 *
 * Makes URL slugs from text strings.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/TeamOneTickets/Sluggo/blob/master/LICENSE.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@teamonetickets.com so we can send you a copy immediately.
 *
 * @category    Sluggo
 * @author      J Cobb <j@teamonetickets.com>
 * @copyright   Copyright (c) 2013 Team One Tickets & Sports Tours, Inc. (http://www.teamonetickets.com)
 * @license     https://github.com/TeamOneTickets/Sluggo/blob/master/LICENSE.txt     MIT License
 */


namespace Sluggo;


/**
 * @category    Sluggo
 * @author      J Cobb <j@teamonetickets.com>
 * @copyright   Copyright (c) 2013 Team One Tickets & Sports Tours, Inc. (http://www.teamonetickets.com)
 * @license     https://github.com/TeamOneTickets/Sluggo/blob/master/LICENSE.txt     MIT License
 */
class Sluggo implements \ArrayAccess
{
    protected $original = null;

    protected $slug = null;

    protected $options = array(
        'toLower'           => true,
        'replaceSymbols'    => true,
        'maxLength'         => null,
        'prefix'            => null,
        'suffix'            => null,
        'separator'         => '-'
    );

    protected $symbolReplacements = array(
        '/&+/'              => ' and ',
        '/%+/'              => ' percent ',
        '/@+/'              => ' at ',
        '/\#+/'             => ' number ',

        // Replace ellipses (…) with a space in case someone forgets to follow with a space
        '/…/i'              => ' ',

        // Convert underscores to hyphens
        '/_/'               => ' - ',
    );

    protected $replacements = array(
        '/À/u'	=> 'A',
        '/Á/u'	=> 'A',
        '/Â/u'	=> 'A',
        '/Ã/u'	=> 'A',
        '/Ä/u'	=> 'A',
        '/Å/u'	=> 'A',
        '/Ā/u'	=> 'A',
        '/Ą/u'	=> 'A',
        '/Ă/u'	=> 'A',
        '/Æ/u'	=> 'Ae',
        '/Ç/u'	=> 'C',
        '/Ć/u'	=> 'C',
        '/Č/u'	=> 'C',
        '/Ĉ/u'	=> 'C',
        '/Ċ/u'	=> 'C',
        '/Ď/u'	=> 'D',
        '/Đ/u'	=> 'D',
        '/È/u'	=> 'E',
        '/É/u'	=> 'E',
        '/Ê/u'	=> 'E',
        '/Ë/u'	=> 'E',
        '/Ē/u'	=> 'E',
        '/Ę/u'	=> 'E',
        '/Ě/u'	=> 'E',
        '/Ĕ/u'	=> 'E',
        '/Ė/u'	=> 'E',
        '/Ĝ/u'	=> 'G',
        '/Ğ/u'	=> 'G',
        '/Ġ/u'	=> 'G',
        '/Ģ/u'	=> 'G',
        '/Ĥ/u'	=> 'H',
        '/Ħ/u'	=> 'H',
        '/Ì/u'	=> 'I',
        '/Í/u'	=> 'I',
        '/Î/u'	=> 'I',
        '/Ï/u'	=> 'I',
        '/Ī/u'	=> 'I',
        '/Ĩ/u'	=> 'I',
        '/Ĭ/u'	=> 'I',
        '/Į/u'	=> 'I',
        '/İ/u'	=> 'I',
        '/Ĳ/u'	=> 'Ij',
        '/Ĵ/u'	=> 'J',
        '/Ķ/u'	=> 'K',
        '/Ł/u'	=> 'L',
        '/Ľ/u'	=> 'L',
        '/Ĺ/u'	=> 'L',
        '/Ļ/u'	=> 'L',
        '/Ŀ/u'	=> 'L',
        '/Ñ/u'	=> 'N',
        '/Ń/u'	=> 'N',
        '/Ň/u'	=> 'N',
        '/Ņ/u'	=> 'N',
        '/Ŋ/u'	=> 'N',
        '/Ò/u'	=> 'O',
        '/Ó/u'	=> 'O',
        '/Ô/u'	=> 'O',
        '/Õ/u'	=> 'O',
        '/Ö/u'	=> 'O',
        '/Ø/u'	=> 'O',
        '/Ō/u'	=> 'O',
        '/Ő/u'	=> 'O',
        '/Ŏ/u'	=> 'O',
        '/Œ/u'	=> 'Oe',
        '/Ŕ/u'	=> 'R',
        '/Ř/u'	=> 'R',
        '/Ŗ/u'	=> 'R',
        '/Ś/u'	=> 'S',
        '/Š/u'	=> 'S',
        '/Ş/u'	=> 'S',
        '/Ŝ/u'	=> 'S',
        '/Ș/u'	=> 'S',
        '/Ť/u'	=> 'T',
        '/Ţ/u'	=> 'T',
        '/Ŧ/u'	=> 'T',
        '/Ț/u'	=> 'T',
        '/Ù/u'	=> 'U',
        '/Ú/u'	=> 'U',
        '/Û/u'	=> 'U',
        '/Ü/u'	=> 'U',
        '/Ū/u'	=> 'U',
        '/Ů/u'	=> 'U',
        '/Ű/u'	=> 'U',
        '/Ŭ/u'	=> 'U',
        '/Ũ/u'	=> 'U',
        '/Ų/u'	=> 'U',
        '/Ŵ/u'	=> 'W',
        '/Ý/u'	=> 'Y',
        '/Ŷ/u'	=> 'Y',
        '/Ÿ/u'	=> 'Y',
        '/Ź/u'	=> 'Z',
        '/Ž/u'	=> 'Z',
        '/Ż/u'	=> 'Z',
        '/à/u'	=> 'a',
        '/á/u'	=> 'a',
        '/â/u'	=> 'a',
        '/ã/u'	=> 'a',
        '/ä/u'	=> 'a',
        '/å/u'	=> 'a',
        '/ā/u'	=> 'a',
        '/ą/u'	=> 'a',
        '/ă/u'	=> 'a',
        '/æ/u'	=> 'ae',
        '/ç/u'	=> 'c',
        '/ć/u'	=> 'c',
        '/č/u'	=> 'c',
        '/ĉ/u'	=> 'c',
        '/ċ/u'	=> 'c',
        '/ď/u'	=> 'd',
        '/đ/u'	=> 'd',
        '/è/u'	=> 'e',
        '/é/u'	=> 'e',
        '/ê/u'	=> 'e',
        '/ë/u'	=> 'e',
        '/ē/u'	=> 'e',
        '/ę/u'	=> 'e',
        '/ě/u'	=> 'e',
        '/ĕ/u'	=> 'e',
        '/ė/u'	=> 'e',
        '/ƒ/u'	=> 'f',
        '/ĝ/u'	=> 'g',
        '/ğ/u'	=> 'g',
        '/ġ/u'	=> 'g',
        '/ģ/u'	=> 'g',
        '/ĥ/u'	=> 'h',
        '/ħ/u'	=> 'h',
        '/ì/u'	=> 'i',
        '/í/u'	=> 'i',
        '/î/u'	=> 'i',
        '/ï/u'	=> 'i',
        '/ī/u'	=> 'i',
        '/ĩ/u'	=> 'i',
        '/ĭ/u'	=> 'i',
        '/į/u'	=> 'i',
        '/ı/u'	=> 'i',
        '/ĳ/u'	=> 'ij',
        '/ĵ/u'	=> 'j',
        '/ķ/u'	=> 'k',
        '/ĸ/u'	=> 'k',
        '/ł/u'	=> 'l',
        '/ľ/u'	=> 'l',
        '/ĺ/u'	=> 'l',
        '/ļ/u'	=> 'l',
        '/ŀ/u'	=> 'l',
        '/ñ/u'	=> 'n',
        '/ń/u'	=> 'n',
        '/ň/u'	=> 'n',
        '/ņ/u'	=> 'n',
        '/ŉ/u'	=> 'n',
        '/ŋ/u'	=> 'n',
        '/ò/u'	=> 'o',
        '/ó/u'	=> 'o',
        '/ô/u'	=> 'o',
        '/õ/u'	=> 'o',
        '/ö/u'	=> 'o',
        '/ø/u'	=> 'o',
        '/ō/u'	=> 'o',
        '/ő/u'	=> 'o',
        '/ŏ/u'	=> 'o',
        '/œ/u'	=> 'oe',
        '/ŕ/u'	=> 'r',
        '/ř/u'	=> 'r',
        '/ŗ/u'	=> 'r',
        '/ś/u'	=> 's',
        '/š/u'	=> 's',
        '/ş/u'	=> 's',
        '/ŝ/u'	=> 's',
        '/ș/u'	=> 's',
        '/ť/u'	=> 't',
        '/ţ/u'	=> 't',
        '/ŧ/u'	=> 't',
        '/ț/u'	=> 't',
        '/ù/u'	=> 'u',
        '/ú/u'	=> 'u',
        '/û/u'	=> 'u',
        '/ü/u'	=> 'u',
        '/ū/u'	=> 'u',
        '/ů/u'	=> 'u',
        '/ű/u'	=> 'u',
        '/ŭ/u'	=> 'u',
        '/ũ/u'	=> 'u',
        '/ų/u'	=> 'u',
        '/ŵ/u'	=> 'w',
        '/ý/u'	=> 'y',
        '/ÿ/u'	=> 'y',
        '/ŷ/u'	=> 'y',
        '/ž/u'	=> 'z',
        '/ż/u'	=> 'z',
        '/ź/u'	=> 'z',
        '/Þ/u'	=> 'p',
        '/þ/u'	=> 'p',
        '/ß/u'	=> 'sz',
        '/ſ/u'	=> 's',
        '/Ð/u'	=> 'Eth',
        '/ð/u'	=> 'eth'
    );


    /**
     * Constructor
     *
     * Available options:
     *
     *  * toLower:          Whether the slug should be lowercase (true by default)
     *  * replaceSymbols:   Replace common symbols with their english word equivalent (true by default)
     *  * maxLength:        NULL for no maximum lenght or maximum length of the returned slug (NULL by default)
     *  * prefix:           prefix for the slug
     *  * suffix:           suffix for the slug
     *  * separator:        word separator char for the slug (default -)
     *
     * @param string $original    An array of field default values
     * @param array  $options     An array of options
     * @param array  $replacements    a char-map-array that is used for the strtr() PHP-function in the slug generation process
     */
    public function __construct($original, $options = array(), $replacements = null)
    {
        $this->original = $original;
        $this->options = array_merge($this->options, $options);
        if (!is_null($replacements)) {
            $this->replacements = $replacements;
        }
    }


    /**
     * Generate the slug.
     */
    public function generateSlug()
    {
        $string = $this->original;

        if ($this->options['toLower']) {
            $string = mb_strtolower($string, 'UTF-8');
        }

        if ($this['replaceSymbols']) {
            // Replace some symbols with their matching string for readability
            $this->replacements = array_merge($this->replacements, $this->symbolReplacements);
        }

        // Replace periods with $separator
        $this->replacements['/\./'] = $this['separator'];

        // Remove anything not a number, letter, space, slash (/), hyphen or $separator
        $this->replacements['/[^A-Za-z0-9-\/ ' . $this['separator'] . ']/i'] = '';

        // replace spaces and slashes with $separator
        $this->replacements['/ /'] = $this['separator'];
        $this->replacements['/\//'] = $this['separator'];

        // replace multiple $separators with a single $separator
        $this->replacements['/[' . preg_quote($this['separator']) . ']+/'] = $this['separator'];


        // Apply all the replacements
        $string = preg_replace(array_keys($this->replacements), $this->replacements, $string);

        // Trim any leading or trailing $separators
        $string = trim($string, $this['separator']);


        if ($this->options['maxLength']) {
            $string = $this->shortenSlug(
                $string,
                $this['maxLength'] - mb_strlen($this['prefix'], 'UTF-8') - mb_strlen($this['suffix'], 'UTF-8')
            );
        }

        // Add prefix & suffix
        $this->slug = $this['prefix'] . $string . $this['suffix'];
    }


    /**
     * Shorten the slug.
     * This shortens to the last full "word" in the slug so that the final result
     * does not include partial words.
     */
    protected function shortenSlug($slug, $maxLength)
    {
        // $maxLength must be greater than 1
        if ($maxLength < 1) {
            return $slug;
        }

        // Check whether we need to shorten
        if (mb_strlen($slug, 'UTF-8') < $maxLength) {
            return $slug;
        }

        // Shorten to $maxLength
        $shortened = trim(substr($slug, 0, $maxLength), $this['separator']);

        // Shorten again to the last position of $separator in shortened string
        $prettySlug = trim(preg_replace('/[^' . preg_quote($this['separator']) . ']*$/', '', $shortened), $this['separator']);

        // only return the pretty string when it is long enough
        if (mb_strlen($prettySlug, 'UTF-8') < ($maxLength/2)) {
            return $shortened;
        } else {
            return $prettySlug;
        }
    }


    /**
     * Returns the slug
     *
     * @return string the slug
     * @see generateSlug()
     */
    public function getSlug()
    {
        if (is_null($this->slug)) {
            $this->generateSlug();
        }
        return $this->slug;
    }


    /**
     * Returns the slug
     *
     * @return string the slug
     * @see getSlug()
     */
    public function __toString()
    {
        return $this->getSlug();
    }


    /**
     * Sets the replacements array that is used for the preg_replace() in the slug generation
     *
     * @param string $replacements
     */
    public function setReplacements($replacements)
    {
        $this->replacements = $replacements;
    }


    /**
     * Sets the option associated with the offset (implements the ArrayAccess interface).
     *
     * @param string $offset The option name
     * @param string $value The option value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->options[] = $value;
        } else {
            $this->options[$offset] = $value;
        }
    }


    /**
     * Returns true if the option exists (implements the ArrayAccess interface).
     *
     * @param  string $name The name of option
     * @return Boolean true if the option exists, false otherwise
     */
    public function offsetExists($offset)
    {
        return isset($this->options[$offset]);
    }


    /**
     * Unsets the option associated with the offset (implements the ArrayAccess interface).
     *
     * @param string $offset The option name
     */
    public function offsetUnset($offset)
    {
        $this->options[$offset] = null;
    }


    /**
     * Returns an option (implements the ArrayAccess interface).
     *
     * @param  string $name The offset of the option to get
     * @return mixed The option if exists, null otherwise
     */
    public function offsetGet($offset)
    {
        return isset($this->options[$offset]) ? $this->options[$offset] : null;
    }


}
