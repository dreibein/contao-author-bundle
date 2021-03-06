<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle.
 * (c) Werbeagentur Dreibein GmbH
 */

namespace Dreibein\ContaoAuthorBundle\Tests\ContaoManager;

use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use Dreibein\ContaoAuthorBundle\ContaoManager\Plugin;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;

class PluginTest extends TestCase
{
    public function testRegisterContainerConfiguration(): void
    {
        $loader = $this->createMock(LoaderInterface::class);

        $plugin = new Plugin();

        $loader
            ->expects($this->once())
            ->method('load')
            ->with($this->stringContains('Resources/config/services.yaml'))
        ;

        $plugin->registerContainerConfiguration($loader, []);
    }

    public function testGetBundles(): void
    {
        $parser = $this->createMock(ParserInterface::class);

        $plugin = new Plugin();

        $bundles = $plugin->getBundles($parser);

        $this->assertInstanceOf(ConfigPluginInterface::class, $plugin);
        $this->assertCount(1, $bundles);
        $this->assertSame([
            ContaoCoreBundle::class,
            ContaoNewsBundle::class,
            ContaoCalendarBundle::class,
        ], $bundles[0]->getLoadAfter());
    }
}
