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

namespace Laemmi\SimpleTemplateEngine\Plugins;

use Laemmi\SimpleTemplateEngine\Modifier\ModifierDefault;
use Laemmi\SimpleTemplateEngine\ModifierInterface;
use Laemmi\SimpleTemplateEngine\PluginsInterface;

class CompileVariable implements PluginsInterface
{
    private $format = '#\{\#(.+?)\#\}#s';

    private $modifier = [];

    public function __invoke(string $content, array $data)
    {
        foreach ($data as $key => $value) {
            $content = preg_replace_callback($this->format, function ($match) use ($data) {
                $arr = explode('|',  $match[1]);
                $val = array_shift($arr);
                $val = isset($data[$val]) ? $data[$val] : '';

                foreach ($arr as $modifier) {
                    $val = $this->modify($modifier, $val);
                }

                return $val;
            }, $content);
        }

        return $content;
    }

    public function addModifier(ModifierInterface $modifier)
    {
        $this->modifier[$modifier->getName()] = $modifier;
    }

    private function modify(string $modifier, $value)
    {
        if (isset($this->modifier[$modifier])) {
            return $this->modifier[$modifier]($value);
        }

        if (isset($this->modifier['default'])) {
            $this->modifier['default']->modifier = $modifier;
            return $this->modifier['default']($value);
        }

        return $value;
    }
}