<?php

declare(strict_types=1);

use Orchestra\Testbench\Foundation\Application;

use function Orchestra\Testbench\default_skeleton_path;

/*
 * Minimal application factory used only by Larastan for static analysis.
 * The package ships no Laravel application of its own, so we boot Testbench's
 * bundled Laravel skeleton (never the package root, which would recurse
 * through package auto-discovery). This file is never autoloaded by consumers.
 */

return Application::create(basePath: default_skeleton_path());
