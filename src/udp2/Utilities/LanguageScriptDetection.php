<?php

    namespace udp2\Utilities;
    
    use udp2\Abstracts\LanguageScriptRegex;

    class LanguageScriptDetection
    {

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isCommon($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_COMMON, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isArabic($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_ARABIC, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isArmenian($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_ARMENIAN, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isBengali($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_BENGALI, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isBopomofo($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_BOPOMOFO, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isBraille($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_BRAILLE, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isBuhid($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_BUHID, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isCanadian_Aboriginal($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_CANADIAN_ABORIGINAL, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isCherokee($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_CHEROKEE, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isCyrillic($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_CYRILLIC, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isDevanagari($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_DEVANAGARI, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isEthiopic($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_ETHIOPIC, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isGeorgian($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_GEORGIAN, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isGreek($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_GREEK, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isGujarati($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_GUJARATI, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isGurmukhi($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_GURMUKHI, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpRedundantDocCommentInspection
         */
        public static function isHan($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_HAN, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isHangul($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_HANGUL, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isHanunoo($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_HANUNOO, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isHebrew($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_HEBREW, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpRedundantDocCommentInspection
         */
        public static function isHiragana($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_HIRAGANA, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isInherited($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_INHERITED, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isKannada($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_KANNADA, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         */
        public static function isKatakana($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_KATAKANA, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isKhmer($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_KHMER, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isLao($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_LAO, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isLatin($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_LATIN, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isLimbu($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_LIMBU, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isMalayalam($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_MALAYALAM, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isMongolian($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_MONGOLIAN, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isMyanmar($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_MYANMAR, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isOgham($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_OGHAM, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isOriya($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_ORIYA, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isRunic($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_RUNIC, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isSinhala($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_SINHALA, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isSyriac($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_SYRIAC, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isTagalog($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_TAGALOG, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isTagbanwa($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_TAGBANWA, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isTaiLe($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_TAILE, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isTamil($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_TAMIL, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isTelugu($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_TELUGU, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isThaana($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_THAANA, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isThai($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_THAI, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isTibetan($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_TIBETAN, $string) > 0;
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isYi($string): bool
        {
            return preg_match(LanguageScriptRegex::REGEX_YI, $string) > 0;
        }
    
        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isChinese($string): bool
        {
            return self::isHan($string);
        }

        /**
         * @param $string
         * @return bool
         * @noinspection PhpUnused
         */
        public static function isJapanese($string): bool
        {
            return self::isHiragana($string) || self::isKatakana($string);
        }
    }