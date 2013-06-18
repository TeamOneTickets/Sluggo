<?php

namespace Sluggo\Test;

use Sluggo\Sluggo;

class SluggoTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSlugStrings()
    {
        $sluggo = new Sluggo('Céline Dion tickets');
        $slug = $sluggo->getSlug();
        assertEquals('celine-dion-tickets', $slug);


        $sluggo = new Sluggo('AC/DC Tickets');
        $slug = $sluggo->getSlug();
        assertEquals('ac-dc-tickets', $slug);


        $sluggo = new Sluggo('#1 hits of the 60’s');
        $slug = $sluggo->getSlug();
        assertEquals('number-1-hits-of-the-60s', $slug);


        $sluggo = new Sluggo('Brooks & Dunn tickets');
        $slug = $sluggo->getSlug();
        assertEquals('brooks-and-dunn-tickets', $slug);

    }


    public function testCanConfigureSlugResult()
    {
        $sluggo = new Sluggo(
            'Brooks & Dunn at Comerica Theatre',
            array(
                'prefix'            => 'order_',
                'suffix'            => '_tickets',
                'maxLength'         => 45,
                'separator'         => '_',
            )
        );

        $slug = $sluggo->getSlug();
        assertequals('order_brooks_and_dunn_at_comerica_tickets', $slug);
    }
}
