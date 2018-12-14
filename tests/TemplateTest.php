<?php

/*
 * Copyright (c) 2018 François Kooman <fkooman@tuxed.net>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace fkooman\Tpl\Tests;

use fkooman\Tpl\Template;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    public function testSimple()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ]
        );

        $this->assertSame(
            'value',
            \trim($template->render('tpl1', ['key' => 'value']))
        );
    }

    public function testEscaping()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ]
        );

        $this->assertSame(
            '&lt;/body&gt;',
            \trim($template->render('tpl1', ['key' => '</body>']))
        );
    }

    public function testLayout()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ]
        );

        $this->assertSame(
            '<html>Foo</html>',
            \trim($template->render('tpl2', []))
        );
    }

    public function testLayoutWithTemplateVars()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ]
        );

        $this->assertSame(
            '<html>barFoo</html>',
            \trim($template->render('tpl3', []))
        );
    }

    public function testTranslation()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ],
            __DIR__.'/locale/nl1.php'
        );

        $this->assertSame(
            'Tekst',
            \trim($template->render('tpl4', []))
        );
    }

    public function testMissingTranslation()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ],
            __DIR__.'/locale/nl1.php'
        );

        $this->assertSame(
            'Missing',
            \trim($template->render('tpl5', []))
        );
    }

    public function testTranslationVariableSubstitution()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ],
            __DIR__.'/locale/nl1.php'
        );

        $this->assertSame(
            'Hallo foo!',
            \trim($template->render('tpl6', ['userId' => 'foo']))
        );
    }

    public function testTranslationEscaping()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ],
            __DIR__.'/locale/nl1.php'
        );

        $this->assertSame(
            'Hallo &lt;/body&gt;!',
            \trim($template->render('tpl6', ['userId' => '</body>']))
        );
    }

    public function testThemeLayout()
    {
        // tpl7 points to layout1, which is available both in the "tpl/theme1"
        // and "tpl" directory, but because "tpl/theme1" is specified first,
        // for all templates (and layouts) that are there, they are taken from
        // that folder... if it is missing from the first folder, the next
        // folder is used...
        $template = new Template(
            [
                __DIR__.'/tpl/theme1',
                __DIR__.'/tpl',
            ]
        );

        $this->assertSame(
            '<html><body>Foo</body></html>',
            \trim($template->render('tpl7', []))
        );
    }

    public function testEscapeFunctions()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ]
        );

        $this->assertSame(
            'VALUE',
            \trim($template->render('tpl8', ['key' => 'value']))
        );
    }

    public function testEscapeFunctionRegisteredCallback()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ]
        );
        $template->addCallback('my_strrev', function ($v) { return \strrev($v); });

        $this->assertSame(
            'EULAV',
            \trim($template->render('tpl9', ['key' => 'value']))
        );
    }

    public function testEscapeEncode()
    {
        $template = new Template(
            [
                __DIR__.'/tpl',
            ]
        );
        $this->assertSame(
            'foo%2Bbar',
            \trim($template->render('tpl10', ['key' => 'foo+bar']))
        );
    }
}
