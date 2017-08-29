<?php
/**
 * Created by PhpStorm.
 * User: qunabu
 * Date: 20.04.17
 * Time: 14:41
 */

class HTMLTextExtension extends DataExtension {
  public function getProtectEmails() {

    /** @var HTMLText $html */
    $html = $this->owner->RAW();;
    $pattern = "/\<a.+?href=\"mailto:(.*?)\".+?\<\/a\>/";
    //$replacement = '${1}1,$3';
    $html = preg_replace_callback($pattern, function($matches){
      $e = $matches[1];
      $mail = trim($matches[1]);
      $umail = base64_encode($mail);
      $html = "<a class='_m_' href='mailto:spam@teatrwybrzeze.pl' data-email='$umail'>Kliknij aby zobaczyć adres email</a>";
      return $html;
    }, $html);

    $js = <<<JS
    <script>
    (function () {
      function spamOnClick(e) {
        var el = e.currentTarget || e.target;
        e.preventDefault();
        var email = el.getAttribute('data-email');
        email = atob(email);
        el.href= 'mailto:' + (email);
        el.innerText = email;
        el.removeEventListener('click', spamOnClick)
      }
      function spam() {
        var elements = document.querySelectorAll('a._m_');
        Array.prototype.forEach.call(elements, function(el, i){
          el.addEventListener('click', spamOnClick);
        });
      }
      if (document.readyState != 'loading'){
        spam();
      } else {
        document.addEventListener('DOMContentLoaded', spam);
      }
    })()
    </script>
JS;


    return $html.$js;

  }

  public function StripStyle() {
    $input = $this->owner->RAW();
    $html = preg_replace('/(<.+?)style=".+?"(>.+?)/i', "$1$2", $input);
    $output = HTMLText::create();
    $output ->setValue($html);
    return $output;
  }
} 
