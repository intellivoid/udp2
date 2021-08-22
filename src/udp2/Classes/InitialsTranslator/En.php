<?php

    namespace udp2\Classes\InitialsTranslator;

    use udp2\Interfaces\LanguageBase;

    class En implements LanguageBase
    {
        /**
         * @inheritdoc
         */
        public function translate($words)
        {
            return $words;
        }

        /**
         * @inheritdoc
         */
        public function getSourceLanguage()
        {
            return 'en';
        }
    }