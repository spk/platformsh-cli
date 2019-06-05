<?php
declare(strict_types=1);

namespace Platformsh\Cli\Tests;

use PHPUnit\Framework\TestCase;
use function Platformsh\Cli\Installer\findInstallableVersions;

class InstallerTest extends TestCase
{

    public function setUp() {
        require_once CLI_ROOT . '/dist/installer.php';
    }

    public function testFindInstallableVersionsChecksForSuffix()
    {
        $this->assertEquals(
            [
                ['version' => '1.0.0'],
                ['version' => '1.0.1'],
                ['version' => '1.0.2-beta'],
            ],
            findInstallableVersions([
                ['version' => '1.0.0'],
                ['version' => '1.0.1'],
                ['version' => '1.0.2-beta'],
                ['version' => '1.0.3-dev'],
            ], PHP_VERSION, ['beta'])
        );
        $this->assertEquals(
            [
                ['version' => '1.0.0-stable'],
                ['version' => '1.0.1'],
                ['version' => '1.0.2-beta'],
            ],
            findInstallableVersions([
                ['version' => '1.0.0-stable'],
                ['version' => '1.0.1'],
                ['version' => '1.0.2-beta'],
                ['version' => '1.0.3-dev'],
            ], PHP_VERSION, ['stable', 'beta'])
        );
    }

    public function testFindInstallableVersionsChecksFoMinPhp()
    {
        $this->assertEmpty(findInstallableVersions([
            [
                'version' => '1.0.0',
                'php' => ['min' => '5.5.9'],
            ]
        ], '5.5.0'));
    }

}