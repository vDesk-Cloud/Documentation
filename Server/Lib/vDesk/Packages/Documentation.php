<?php
declare(strict_types=1);

namespace vDesk\Packages;

use vDesk\Configuration\Settings;
use vDesk\Package;
use vDesk\Pages\IPackage;

/**
 * Class Documentation
 *
 * @package vDesk\Packages
 * @author  Kerry <DevelopmentHero@gmail.com>
 */
final class Documentation extends Package implements IPackage {
    
    /**
     * The name of the Package.
     */
    public const Name = "Documentation";
    
    /**
     * The version of the Package.
     */
    public const Version = "1.0.0";
    
    /**
     * The name of the Package.
     */
    public const Vendor = "Kerry <DevelopmentHero@gmail.com>";
    
    /**
     * The name of the Package.
     */
    public const Description = "Package that provides a documentation website.";
    
    /**
     * The dependencies of the Package.
     */
    public const Dependencies = ["Pages" => "1.0.0"];
    
    /**
     * The files and directories of the Package.
     */
    public const Files = [
        self::Server => [
            self::Lib         => [
                "vDesk/Documentation"
            ],
            self::Modules     => [
                "Documentation.php"
            ],
            self::Pages       => [
                "Documentation.php",
                "Documentation"
            ],
            self::Templates   => [
                "Documentation.php",
                "Documentation"
            ],
            self::Stylesheets => [
                "Documentation.css"
            ],
            self::Images      => [
                "Documentation"
            ]
        ]
    ];
    
    /**
     * @inheritDoc
     */
    public static function Install(\Phar $Phar, string $Path): void {
        Settings::$Local["Routes"]["Documentation/Topic/{Topic}"] = [
            "Module"  => "Documentation",
            "Command" => "Topic"
        ];
        static::Deploy($Phar, $Path);
    }
    
    /**
     * @inheritDoc
     */
    public static function Uninstall(string $Path): void {
        static::Undeploy();
    }
    
}