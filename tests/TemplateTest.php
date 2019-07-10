<?php
/**
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @category   simple-template-engine
 * @author     Michael Lämmlein <laemmi@spacerabbit.de>
 * @copyright  ©2019 laemmi
 * @license    http://www.opensource.org/licenses/mit-license.php MIT-License
 * @version    1.0.0
 * @since      2019-07-09
 */

declare(strict_types=1);

namespace Laemmi\SimpleTemplateEngine;

use Laemmi\SimpleTemplateEngine\Modifier\ModifierCallback;
use Laemmi\SimpleTemplateEngine\Plugins\CompileVariable;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    /**
     * @dataProvider dateProvider
     *
     * @param string $content
     * @param string $expected
     */
    public function testTemplateFull(string $content, string $expected)
    {
        $template = TemplateFactory::factory($content);
        $template->assign('name', 'Michael');
        $template->assign('age', 99);
        $template->assign('x', 'x');
        $template->assign('foo', '');

        $this->assertEquals(
            $expected,
            $template->render()
        );
    }

    public function testModifierCallback()
    {
        $callback = new ModifierCallback('custom', function($value) {
            return sprintf('Sir %s', $value);
        });

        $compiler = new CompileVariable();
        $compiler->addModifier($callback);

        $template = new Template('My name is {#name|custom#}');
        $template->addPlugin($compiler);
        $template->assign('name', 'Michael');

        $this->assertEquals(
            'My name is Sir Michael',
            $template->render()
        );
    }

    public function dateProvider() : array
    {
        return [
            [
                'Mein Name ist {#name#} und ich bin {#age#} Jahre alt.',
                'Mein Name ist Michael und ich bin 99 Jahre alt.'
            ],
            [
                '{#x#}-{#x#}',
                'x-x'
            ],
            [
                'Mein Name ist {if $name}{#name#}{/if} und ich bin {#age#} Jahre alt.',
                "Mein Name ist Michael und ich bin 99 Jahre alt."
            ],
            [
                'a{if $foo}b{#name#}{/if}c',
                "ac"
            ],
            [
                'a{if $name===\'Michael\'}b{#name#}{/if}c',
                "abMichaelc"
            ],
            [
                '{#name|strtolower#} {#name|strtoupper#}',
                "michael MICHAEL"
            ],
        ];
    }
}