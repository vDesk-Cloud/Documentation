<?php
declare(strict_types=1);

namespace Modules;

use Pages\Documentation\Index;
use vDesk\Configuration\Settings;
use vDesk\IO\DirectoryInfo;
use vDesk\IO\FileInfo;
use vDesk\IO\Path;
use vDesk\Modules\Module;
use vDesk\Pages\Page;
use vDesk\Pages\Request;

/**
 * Module for serving the Documentation files of the Package.
 *
 * @package Modules
 * @author  Kerry <DevelopmentHero@gmail.com>
 */
class Documentation extends Module {
    
    /**
     * The index function of the Module.
     *
     * @return \Pages\Documentation A Page that represents the current overview of available tutorials.
     */
    public static function Index(): Page {
        return new Page(
            [
                "Pages"   => static::GetPages(),
                "Tutorials" => static::GetTutorials(),
                "Current" => new Index()
            ],
            ["Documentation"]
        );
    }
    
    /**
     * Gets the currently installed Documentation Pages.
     *
     * @return array
     */
    public static function GetPages(): array {
        return (new DirectoryInfo(Settings::$Local["Pages"]["Pages"] . Path::Separator . "Documentation"))
            ->GetFiles()
            ->Map(static fn(FileInfo $Page): string => "\\Pages\\Documentation\\{$Page->Name}")
            ->Map(static fn(string $Page): Page => new $Page())
            ->ToArray();
    }
    
    /**
     * Displays a specified Documentation Page.
     *
     * @param string|null $Page The Page to display.
     *
     * @return \Pages\Documentation The requested tutorial.
     */
    public static function Page(string $Page = null): Page {
        $Page    ??= Request::$Parameters["Page"];
        $Class   = "\\Pages\\Documentation\\{$Page}";
        $Current = new $Class(["Pages" => static::GetPages()]);
        $Current->Values->Add("Current", $Current);
        return $Current;
    }
    
    /**
     * Gets the currently installed Tutorial Pages.
     *
     * @return array
     */
    public static function GetTutorials(): array {
        return (new DirectoryInfo(Settings::$Local["Pages"]["Pages"] . Path::Separator . "Documentation" . Path::Separator . "Tutorials"))
            ->GetFiles()
            ->Map(static fn(FileInfo $Tutorial): string => "\\Pages\\Documentation\\Tutorials\\{$Tutorial->Name}")
            ->Map(static fn(string $Tutorial): Page => new $Tutorial())
            ->ToArray();
    }
    
    /**
     * Displays the Tutorials index Page.
     *
     * @param string|null $Tutorial The Tutorial Page to display.
     *
     * @return \Pages\Documentation The requested tutorial.
     */
    public static function Tutorials(): Page {
        return static::Tutorial("Index");
    }
    
    /**
     * Displays a specified Tutorial Page.
     *
     * @param string|null $Tutorial The Tutorial Page to display.
     *
     * @return \Pages\Documentation The requested tutorial.
     */
    public static function Tutorial(string $Tutorial = null): Page {
        $Tutorial ??= Request::$Parameters["Tutorial"];
        $Class    = "\\Pages\\Documentation\\Tutorials\\{$Tutorial}";
        return new $Class(
            [
                "Current"   => new $Class(),
                "Pages"     => static::GetPages(),
                "Tutorials" => static::GetTutorials(),
            ],
            ["Documentation/Tutorials"]
        );
    }
    
}