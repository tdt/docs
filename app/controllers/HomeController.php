<?php

use \Michelf\Markdown;

class HomeController extends BaseController {

	public function handleRequest(){

        // TODO create page not found page
        $uri = \Request::path();

        // Default version of the documentation
        $version = "4.0";
        $content_file = 'introduction';

        // If not the root, then split the uri to find the content
        if($uri == '/'){

            $content_file = 'introduction';

        }else{

            // Return content based on the uri
            $pieces = explode('/', $uri);

            // Assuming that the uri consists of 2 pieces: version_number/content
            if(count($pieces) > 2){
                \App::abort("The uri $uri could not be resolved");
            }else if(count($pieces) == 1){
                $version = $pieces[0];
            }else{
                $version = $pieces[0];
                $content_file = $pieces[1];
            }
        }

        // Show the correct markdown contents
        $content_file = __DIR__ . '/docs/' . $version . '/' . $content_file . '.md';

        if(file_exists($content_file)){

            $contents = file_get_contents($content_file);
            $sidebar = file_get_contents(__DIR__ . '/docs/' . $version . '/sidebar.md');

            $contents_html = Markdown::defaultTransform($contents);
            $sidebar_html = Markdown::defaultTransform($sidebar);

            return View::make('layouts.master')
                        ->with('sidebar', $sidebar_html)
                        ->with('content', $contents_html);

        }else{
            \App::abort("The contents of $content_file could not be found.");
        }
	}
}