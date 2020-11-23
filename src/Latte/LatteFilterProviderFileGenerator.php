<?php

declare(strict_types=1);

namespace Symplify\TemplateChecker\Latte;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\SmartFileSystem\SmartFileSystem;
use Symplify\TemplateChecker\PhpParser\LatteFilterProviderFactory;
use Symplify\TemplateChecker\ValueObject\ClassMethodName;

final class LatteFilterProviderFileGenerator
{
    /**
     * @var LatteFilterProviderFactory
     */
    private $latteFilterProviderGenerator;

    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;

    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    public function __construct(
        LatteFilterProviderFactory $latteFilterProviderGenerator,
        SmartFileSystem $smartFileSystem,
        SymfonyStyle $symfonyStyle
    ) {
        $this->latteFilterProviderGenerator = $latteFilterProviderGenerator;
        $this->smartFileSystem = $smartFileSystem;
        $this->symfonyStyle = $symfonyStyle;
    }

    public function generate(ClassMethodName $classMethodName): void
    {
        $generatedContent = $this->latteFilterProviderGenerator->createFromClassMethodName($classMethodName);

        $filterProviderClassName = $classMethodName->getFilterProviderClassName();
        $shortFilePath = 'generated/' . $filterProviderClassName . '.php';

        $this->smartFileSystem->dumpFile(getcwd() . '/' . $shortFilePath, $generatedContent);

        $generateMessage = sprintf('File "%s" was generated', $shortFilePath);
        $this->symfonyStyle->note($generateMessage);
    }
}
