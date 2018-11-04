<?php
/**
 * Created by PhpStorm.
 * User: bml
 * Date: 11/3/18
 * Time: 11:44 AM
 */

namespace Detectify\Alice;


use Detectify\Exceptions\HtmlNotFoundException;
use Detectify\Support\Response;
use Exception;

class Alice
{

    protected $title = 'Guestbook';

    protected $header;

    protected $footer;

    public function __construct()
    {
        $this->header = $this->header();
        $this->footer = $this->footer();
    }

    /**
     * @return mixed
     */
    protected function header(){
        try {
            $html = $this->getHtml("header");
            return $this->applyData($html, ['title' => $this->title]);
        }catch(Exception $exception){
            Response::renderException($exception);
        }
    }

    /**
     * @return mixed
     */
    protected function footer()
    {
        try {
            $html = $this->getHtml("footer");
            return $this->applyData($html, []);
        } catch (Exception $exception) {
            Response::renderException($exception);
        }
    }

    final protected function applyData($html, $data, $isHtml = false){
        foreach($data as $find => $replace){
            if(!$isHtml){
                $replace = htmlentities($replace);
            }
            $html = str_replace("{#".$find."#}", $replace, $html);
        }
        return $html;
    }

    /**
     * @param $name
     * @return bool|string
     * @throws HtmlNotFoundException
     */
    protected function getHtml($name){
        $actualName = __DIR__.'/Html/'.$name . ".html";
        if(file_exists($actualName)) {
            return file_get_contents($actualName);
        }else{
            throw new HtmlNotFoundException;
        }
    }

    /**
     * @param array $htmlChunks
     */
    protected function renderChunks(array $htmlChunks){
        $collected = null;
        foreach ($htmlChunks as $html){
            $collected.=$html;
        }
        echo $collected;
    }

    /**
     * @param $view
     * @param null $data
     */
    protected function renderView($view, $data = null){
        try {
            $viewHtml = $this->getHtml($view);
            if($data){
                $this->applyData($viewHtml, $data);
            }
            echo $this->header . $this->getHtml($view) . $this->footer;
        }catch(Exception $exception){
            Response::renderException($exception);
        }
    }

    /**
     * @param $viewHtml
     * @param null $data
     */
    protected function renderHtml($viewHtml, $data = null){
        echo $this->header . $viewHtml . $this->footer;
    }

    /**
     * @param array $cssFiles
     */
    protected function addCustomCss(array $cssFiles){
        $linkTemplate = '<link href="[]" rel="stylesheet">';
        $links = '';
        foreach($cssFiles as $css){
            $links.= str_replace('[]','css/'.$css.'.css', $linkTemplate);
        }
        $this->header = $this->applyData($this->header, ["customCss" => $links], true);
    }

    /**
     * @param array $cssFiles
     */
    protected function addCustomJs(array $cssFiles){
        $linkTemplate = '<script src="[]"></script>';
        $links = '';
        foreach($cssFiles as $css){
            $links.= str_replace('[]','js/'.$css.'.js', $linkTemplate);
        }
        $this->footer = $this->applyData($this->footer, ["customJs" => $links], true);
    }
}