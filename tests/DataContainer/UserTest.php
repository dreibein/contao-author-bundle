<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle.
 * (c) Werbeagentur Dreibein GmbH
 */

namespace Dreibein\ContaoAuthorBundle\Tests\DataContainer;

use Dreibein\ContaoAuthorBundle\DataContainer\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testModifyPalette(): void
    {
        $palettes = ['login', 'admin', 'default', 'group', 'extend', 'custom'];
        $dc = new \stdClass();
        $dc->table = 'tl_user';

        include_once __DIR__ . '/../../src/Resources/contao/dca/tl_user.php';

        // prepare
        foreach ($palettes as $palette) {
            $GLOBALS['TL_DCA']['tl_user']['palettes'][$palette] = '{name_legend},name;';
        }

        $callback = new User();

        $callback->modifyPalette($dc);

        foreach ($palettes as $palette) {
            $haystack = $GLOBALS['TL_DCA']['tl_user']['palettes'][$palette];

            $this->assertStringContainsString('{author_legend}', $haystack);
            $this->assertStringContainsString('authorPicture', $haystack);
            $this->assertStringContainsString('authorDescription', $haystack);
            $this->assertStringContainsString('authorLinks', $haystack);
            $this->assertStringContainsString('authorPage', $haystack);
        }
    }
}
