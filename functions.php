<?php

add_action('init', function () {
    register_block_style('core/code', [
        'name'  => 'terminal',
        'label' => __('Terminal', 'your-textdomain'),
        'inline_style' => '
            .wp-block-code.is-style-terminal {
                padding: 22px 24px;
                background: #080b08;
                color: #64ff5f;
                font-family: "SFMono-Regular", "Consolas", "Courier New", monospace;
                font-size: clamp(22px, 3vw, 36px);
                line-height: 1.75;
                font-weight: 700;
                white-space: pre-wrap;
                text-shadow: 0 0 8px rgba(100, 255, 95, 0.35);
                box-shadow: inset 0 0 0 1px rgba(100, 255, 95, 0.16);
            }

            .wp-block-code.is-style-terminal code::before {
                content: "$ ";
                color: #b6ffb0;
            }

            .wp-block-code.is-style-terminal code::after {
                content: "";
                display: inline-block;
                width: 0.65ch;
                height: 1em;
                margin-left: 0.18ch;
                background: #64ff5f;
                vertical-align: -0.12em;
                animation: terminal-cursor-blink 1s steps(1, end) infinite;
                box-shadow: 0 0 10px rgba(100, 255, 95, 0.7);
            }

            @keyframes terminal-cursor-blink {
                0%, 49% { opacity: 1; }
                50%, 100% { opacity: 0; }
            }
        ',
    ]);
});