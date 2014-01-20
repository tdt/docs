<?php

use \Michelf\Markdown;

class HomeController extends BaseController {

	public function handleRequest(){

        // TODO create "page not found" page
        $uri = Request::path();

        // Default version of the documentation
        $version = "4.0";
        $page = 'introduction';

        // If not the root, then split the uri to find the content
        $segment1 = Request::segment(1);
        $segment2 = Request::segment(2);

        if(!empty($segment1)){
            $version = $segment1;

            if(!empty($segment2)){
                $page = $segment2;
            }
        }

        // Show the correct markdown contents
        $page = __DIR__ . '/docs/' . $version . '/' . $page . '.md';

        if(file_exists($page)){

            $contents = file_get_contents($page);
            $sidebar = file_get_contents(__DIR__ . '/docs/' . $version . '/sidebar.md');

            // Transform documents
            $contents_html = Markdown::defaultTransform($contents);
            $sidebar_html = Markdown::defaultTransform($sidebar);

            // Replace url variable
            $sidebar_html = preg_replace('/{url}/mi', URL::to($version), $sidebar_html);

            return View::make('layouts.master')
                        ->with('version', $version)
                        ->with('sidebar', $sidebar_html)
                        ->with('content', $contents_html);

        }else{
            \App::abort(400, "The page you were looking for could not be found.");
        }
	}
}