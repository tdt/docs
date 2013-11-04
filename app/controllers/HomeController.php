<?php

use \Michelf\Markdown;

class HomeController extends BaseController {

	public function handleRequest(){

        $uri = \Request::path();

        // Show the correct md contents
		$md = file_get_contents(__DIR__ . '/docs/4.0/introduction.md');
        $sidebar = file_get_contents(__DIR__ . '/docs/4.0/sidebar.md');

		$md_html = Markdown::defaultTransform($md);
        $sidebar_html = Markdown::defaultTransform($sidebar);

        return View::make('layouts.master')
                                    ->with('sidebar', $sidebar_html)
                                    ->with('content', $md_html);
	}}