<?php

namespace App\Tests\Services;

use App\Services\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{

    public function testSlugify()
    {
        $slugger=new Slugger();

        $slug=$slugger->slugify('The King of Staten Island');

        $this->assertIsString($slug);
        $this->assertEquals('The-King-of-Staten-Island',$slug);
    }
}
