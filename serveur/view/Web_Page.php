<?php
class Web_Page
{
    public const LANG = 'fr-CA';
    public const AUTHOR = 'Votre nom ici';
    public const ICON = 'web_site_icon.jpg';
    public $title = 'manchesterUnited.com - Acceuil';
    public $description = 'Les meilleurs produits du manchester United';

    public $content = '';
    public $count = '';

    public function render()
    {
        require_once 'view/head.php';
        require_once 'view/header.php';
        require_once 'view/nav.php';
        echo $this->content;
        require_once 'view/footer.php';
    }
    public function ViewCount($filename)
    {
        $count = 0;

        if (!file_exists($filename)) {
            $count = 0;
        } else {
            $count = (int)file_get_contents($filename);
            $count++;
            file_put_contents($filename, $count);
        }
        return (int)file_get_contents($filename);
    }
}
