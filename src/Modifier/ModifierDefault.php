<?php
/**
 * Copyright 2007-2019 wdv Gesellschaft für Medien & Kommunikation mbH & Co. OHG
 *
 *
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
 * @category    simple-template-engine
 * @author      Michael Lämmlein <m.laemmlein@wdv.de>
 * @copyright   ©2007-2019 wdv Gesellschaft für Medien & Kommunikation mbH & Co. OHG
 * @license     http://www.opensource.org/licenses/mit-license.php MIT-License
 * @version     ${Version}
 * @since       2019-07-10
 */

declare(strict_types=1);

namespace Laemmi\SimpleTemplateEngine\Modifier;

use Laemmi\SimpleTemplateEngine\ModifierInterface;

class ModifierDefault implements ModifierInterface
{
    public $modifier = 'trim';

    public function getName() : string
    {
        return 'default';
    }

    public function __invoke($value)
    {
        return call_user_func($this->modifier, $value);
    }
}