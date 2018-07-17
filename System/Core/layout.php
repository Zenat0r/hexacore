<?php
/**
* Layout manager
*/
class Layout
{
    private $name;

    private $title;
    private $styles;
    private $fonts;
    private $scripts;

    private $remote_fonts;

    private $layoutData;
    private $flashData;

    private $og_tag;

    public function __construct($argument)
    {
        $this->name = Config::get("appPath") . "/views/layouts/" . $argument . ".php";
        $this->styles = [];
        $this->fonts = [];
        $this->scripts = [];
        $this->og_tag = ["title" => null, "description" => null, "img" => null, "url" => null];
        $this->layoutData = null;
        $this->flashData = null;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function addStyle($style)
    {
        array_push($this->styles, $style);
    }

    public function addScript($script)
    {
        array_push($this->scripts, $script);
    }

    public function addFonts($font)
    {
        array_push($this->fonts, $font);
    }

    public function addRemote_fonts($remote_font)
    {
        array_push($this->remote_fonts, $remote_font);
    }

    public function setLayoutData($data)
    {
        $this->layoutData = $data;
    }

    public function setFlashData($data)
    {
        $this->flashData = $data;
    }

    public function og_title($title)
    {
        $this->og_tag["title"] = $title;
        $this->og_url();
    }

    public function og_description($description)
    {
        $this->og_tag["description"] = $description;
    }

    public function og_img($img)
    {
        $this->og_tag["img"] = $img;
    }

    private function og_url()
    {
        $urlNoneRewrite = $_SERVER["QUERY_STRING"];
        $controller = explode("&", explode("=", $urlNoneRewrite)[1])[0];
        $action = explode("&", explode("=", $urlNoneRewrite)[2])[0];
        $gets = explode("=", $urlNoneRewrite)[3];
        $this->og_tag["url"] = base_url() . $controller;
        if ($action === null && $gets !== null) {
            $this->og_tag["url"] .= "/index" . "/" . $gets;
        } else {
            $this->og_tag["url"] .= "/" . $action;
            if ($gets !== null) {
                $this->og_tag["url"] .= "/" . $gets;
            }
        }
    }

    public function render($nameView, $data = null)
    {
        $view = new View($nameView);
        $content = $view->showFile(Config::get("appPath") . "/views/" . $nameView . ".php", $data);

        if (file_exists($this->name)) {
            // Rend les éléments du tableau $data accessibles dans la vue
            $layout_data = [
                'title' => $this->title != null ? $this->title : [],
                'styles' => $this->styles != null ? $this->styles : [],
                'fonts' => $this->fonts != null ? $this->fonts : [],
                'scripts' => $this->scripts != null ? $this->scripts : [],
                'remote_fonts' => $this->remote_fonts != null ? $this->remote_fonts : [],
                'og_tag' => $this->og_tag,
                'layoutData' => $this->layoutData,
                "flashData" => $this->flashData
            ];
            if ($layout_data !== null) {
                extract($layout_data);
            }
            // Démarrage de la temporisation de sortie
            ob_start();
            // Inclut le fichier vue
            // Son résultat est placé dans le tampon de sortie
            require $this->name;
            // Arrêt de la temporisation et renvoi du tampon de sortie
            echo ob_get_clean();
        } else {
            throw new Exception("Fichier layout: '$this->name' introuvable");
        }
    }

    public function renderMail($nameView, $data = null)
    {
        $view = new View($nameView);
        $content = $view->showFile(Config::get("appPath") . "/views/email/" . $nameView . ".php", $data);

        if (file_exists($this->name)) {
            // Rend les éléments du tableau $data accessibles dans la vue
            $layout_data = [
                'title' => $this->title != null ? $this->title : [],
            ];
            if ($layout_data !== null) {
                extract($layout_data);
            }
            // Démarrage de la temporisation de sortie
            ob_start();
            // Inclut le fichier vue
            // Son résultat est placé dans le tampon de sortie
            require $this->name;
            // Arrêt de la temporisation et renvoi du tampon de sortie
            return ob_get_clean();
        } else {
            throw new Exception("Fichier layout: '$this->name' introuvable");
        }
    }
}
