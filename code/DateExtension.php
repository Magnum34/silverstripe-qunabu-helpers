<?php

/**
 * Created by PhpStorm.
 * User: qunabu
 * Date: 06.02.2017
 * Time: 15:28
 */
class DateExtension extends DataExtension {
  public function UTF8FormatI18N($formattingString) {
    if (i18n::get_locale() == 'pl_PL') {
            $to_convert = array(
                'l' => array('dat' => 'N', 'str' => array('Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela')),
                'F' => array('dat' => 'n', 'str' => array('styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień')),
                'f' => array('dat' => 'n', 'str' => array('stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'))
            );
            $time = strtotime($this->owner);
            $formattingString = str_replace('%', '', $formattingString);
            if ($pieces = preg_split('#[:/.\-, ]#', $formattingString)) {
                if ($time === null) {
                    $time = time();
                }
                foreach ($pieces as $datepart) {
                    if (array_key_exists($datepart, $to_convert)) {
                        $replace[] = $to_convert[$datepart]['str'][(date($to_convert[$datepart]['dat'], $time) - 1)];
                    } else {
                        $replace[] = date($datepart, $time);
                    }
                }
                $result = strtr($formattingString, array_combine($pieces, $replace));
                return $result;
            }
      }
      return utf8_encode($this->owner->FormatI18N($formattingString));
  }
}
