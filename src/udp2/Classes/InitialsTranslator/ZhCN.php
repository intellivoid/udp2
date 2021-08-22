<?php

    namespace udp2\Classes\InitialsTranslator;

    use Overtrue\Pinyin\Pinyin;
    use udp2\Interfaces\LanguageBase;

    class ZhCN implements LanguageBase
    {
        /**
         * Inherent instance of zh-CN translator
         *
         * @var Pinyin
         */
        protected $inherent;

        /**
         * ZhCN constructor, set the instance of PinYin
         */
        public function __construct()
        {
            $this->inherent = new Pinyin();
        }

        /**
         * @inheritdoc
         */
        public function translate($words)
        {
            return implode(' ', $this->inherent->name($words));
        }

        /**
         * @inheritdoc
         */
        public function getSourceLanguage()
        {
            return 'zh-CN';
        }
    }