<?php

namespace App\Services;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;

class MarkdownRenderer
{
    protected MarkdownConverter $markdownConverter;

    protected array $config = [
        'renderer' => [
            'block_separator' => "\n",
            'inner_separator' => "\n",
            'soft_break' => "\n",
        ],
        'html_input' => 'escape',
        'allow_unsafe_links' => false
    ];

    public function __construct()
    {
        $environment = new Environment($this->config);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $environment->addRenderer(FencedCode::class, new FencedCodeRenderer());
        $environment->addRenderer(IndentedCode::class, new IndentedCodeRenderer());

        $this->markdownConverter = new MarkdownConverter($environment);
    }

    public function render(string $markdown): string
    {
        return $this->markdownConverter->convert($markdown)->getContent();
    }
}
