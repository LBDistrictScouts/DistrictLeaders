<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\MarkdownHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;
use Josbeir\Filesystem\FilesystemAwareTrait;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

/**
 * App\View\Helper\MarkdownHelper Test Case
 */
class MarkdownHelperTest extends TestCase
{
    use FilesystemAwareTrait;

    /**
     * Test subject
     *
     * @var MarkdownHelper
     */
    public MarkdownHelper $Markdown;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $view = new View();
        $this->Markdown = new MarkdownHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Markdown);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        TestCase::assertClassHasAttribute('converter', '\App\View\Helper\MarkdownHelper');
    }

    /**
     * Test markdownToHtml method
     *
     * @return void
     * @throws FilesystemException
     */
    public function testMarkdownToHtml(): void
    {
        $adapter = new LocalFilesystemAdapter(TESTS);
        $fileSystem = new Filesystem($adapter);

        $markdownText = $fileSystem->read('dummy_readme.md');
        TestCase::assertStringContainsString('# CakePHP Application Skeleton', $markdownText);
        TestCase::assertStringContainsString('[![Build Status](https://travis-ci.org/LBDistrictScouts/DistrictLeaders.svg?branch=Development)](https://travis-ci.org/LBDistrictScouts/DistrictLeaders)', $markdownText);
        TestCase::assertStringContainsString('Then visit `http://localhost:8765` to see the welcome page.', $markdownText);

        $htmlText = $this->Markdown->markdownToHtml($markdownText);

        TestCase::assertStringContainsString('<h1>CakePHP Application Skeleton</h1>', $htmlText);
        TestCase::assertStringContainsString('<a href="https://travis-ci.org/LBDistrictScouts/DistrictLeaders"><img src="https://travis-ci.org/LBDistrictScouts/DistrictLeaders.svg?branch=Development" alt="Build Status" /></a>', $htmlText);
        TestCase::assertStringContainsString('<p>Then visit <code>http://localhost:8765</code> to see the welcome page.</p>', $htmlText);
    }
}
